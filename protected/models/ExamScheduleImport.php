<?php

Yii::import('application.models._base.BaseExamScheduleImport');

class ExamScheduleImport extends BaseExamScheduleImport {

    const TYPE_THAI = '0';
    const TYPE_FOREIGN = '1';

    public $import_file;
    public $importData;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getImportTypeOptions($code = null) {
        $ret = array(
            self::TYPE_THAI => 'คนไทย',
            self::TYPE_FOREIGN => 'ชาวต่างชาติ'
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'course_name' => 'ชื่อหลักสูตรฝึกอบรม',
            'course_date' => 'วันที่ฝึกอบรม',
            'import_type' => 'ประเภทของไฟล์',
            'exam_schedule_objective_id' => 'วัตถุประสงค์การสอบ',
            'import_file' => 'ไฟล์นำเข้า',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('exam_schedule_objective_id, course_name, course_date, import_type', 'required'),
            array('import_file', 'file', 'types' => array('xls', 'xlsx'), 'allowEmpty' => false),
            array('importData', 'safe'),
        ));
    }

    public function columnMapper() {
        switch ($this->import_type) {
            case self::TYPE_FOREIGN:
                return array(
                    0 => 'title_en',
                    1 => 'firstname_en',
                    2 => 'midname_en',
                    3 => 'lastname_en',
                    4 => 'birth_date',
                    5 => 'birth_province',
                    6 => 'nationality',
                    7 => 'mobile',
                    8 => 'email',
                    9 => 'position',
                    10 => 'level',
                    11 => 'office',
                    12 => 'passport_no',
                    13 => 'passport_issue_country',
                    14 => 'passport_issue_date',
                    15 => 'passport_expire_date',
                );
            default:
                return array(
                    0 => 'username',
                    1 => 'title_th',
                    2 => 'title_en',
                    3 => 'firstname_th',
                    4 => 'firstname_en',
                    5 => 'midname_th',
                    6 => 'midname_en',
                    7 => 'lastname_th',
                    8 => 'lastname_en',
                    9 => 'birth_date',
                    10 => 'birth_province',
                    11 => 'nationality',
                    12 => 'mobile',
                    13 => 'email',
                    14 => 'position',
                    15 => 'level',
                    16 => 'office',
                    17 => 'passport_no',
                    18 => 'passport_issue_country',
                    19 => 'passport_issue_date',
                    20 => 'passport_expire_date',
                );
        }
    }

    public function import() {
        if ($this->validate()) {
            $file = CUploadedFile::getInstance($this, 'import_file');
            if ($file) {
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $objPHPExcel = PHPExcel_IOFactory::load($file->tempName);
                $sheet = $objPHPExcel->getActiveSheet();
                $this->importData = array();
                for ($i = 2; $i <= $sheet->getHighestDataRow(); $i++) {
                    $item = array();
                    foreach ($this->columnMapper() as $key => $name) {
                        $item[$name] = $sheet->getCellByColumnAndRow($key, $i)->getValue();
                        switch ($name) {
                            case 'nationality':
                                $item[$name] = CHtml::value(CodeCountry::model()->findByAttributes(array('nationality' => $item[$name])), 'id');
                                break;
                            case 'passport_issue_country':
                                $item[$name] = CHtml::value(CodeCountry::model()->findByAttributes(array($this->import_type === self::TYPE_FOREIGN ? 'name_en' : 'name_th' => $item[$name])), 'id');
                                break;
                            case 'birth_date':
                            case 'passport_issue_date':
                            case 'passport_expire_date':
                                $item[$name] = date('Y-m-d', Helper::excelDateToUnix($item[$name]));
                                break;
                        }
                    }
                    $this->importData[] = $item;
                }
                return true;
            }
        }
    }

    public function saveBulk() {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($this->importData as $item) {
                if ($this->import_type === self::TYPE_FOREIGN) {
                    $account = new Account('import');
                    $account->account_type_id = AccountType::getId('accountProfileGeneralForeigner');
                } else {
                    $account = Account::model()->findByAttributes(array(
                        'username' => CHtml::value($item, 'username'),
                    ));
                    if (!isset($account)) {
                        $account = new Account('import');
                        $account->account_type_id = AccountType::getId('accountProfileGeneralThai');
                    }
                }
                $account->scenario = 'import';
                $account->entry_code = CHtml::value($item, 'username');
                $account->username = CHtml::value($item, 'username');
                $account->status = Account::STATUS_ACTIVED;
                $account->tmp_password = Helper::getTempPassword();
                if ($account->save()) {
                    $account->isNewRecord = false;
                    $profile = $account->getProfile();
                    if (!isset($profile)) {
                        if ($this->import_type === self::TYPE_FOREIGN) {
                            $profile = new AccountProfileGeneralForeigner('import');
                        } else {
                            $profile = new AccountProfileGeneralThai('import');
                        }
                        $profile->account_id = $account->id;
                    }
                    $profile->scenario = 'import';
                    if ($this->import_type === self::TYPE_FOREIGN) {
                        $profile->title_en = strtoupper(CHtml::value($item, 'title_en'));
                        $profile->firstname_en = strtoupper(CHtml::value($item, 'firstname_en'));
                        $profile->midname_en = strtoupper(CHtml::value($item, 'midname_en'));
                        $profile->lastname_en = strtoupper(CHtml::value($item, 'lastname_en'));
                        $profile->birth_date = CHtml::value($item, 'birth_date');
                        $profile->nationality_id = CHtml::value($item, 'nationality');
                        $profile->contact_email = CHtml::value($item, 'email');
                        $profile->contact_phone = CHtml::value($item, 'mobile');
                        $profile->contact_mobile = CHtml::value($item, 'mobile');
                        $profile->work_position = CHtml::value($item, 'position');
                        $profile->work_level = '99';
                        $profile->work_level_other = CHtml::value($item, 'level');
                        $profile->work_office_id = '9999';
                        $profile->work_office_other = strtoupper(CHtml::value($item, 'office'));
                        $profile->passport_no = CHtml::value($item, 'passport_no');
                        $profile->passport_issue_country = CHtml::value($item, 'passport_issue_country');
                        $profile->passport_issue_date = CHtml::value($item, 'passport_issue_date');
                        $profile->passport_expire_date = CHtml::value($item, 'passport_expire_date');
                    } else {
                        $profile->title_th = CHtml::value($item, 'title_th');
                        $profile->firstname_th = CHtml::value($item, 'firstname_th');
                        $profile->midname_th = CHtml::value($item, 'midname_th');
                        $profile->lastname_th = CHtml::value($item, 'lastname_th');
                        $profile->title_en = CHtml::value($item, 'title_en');
                        $profile->firstname_en = strtoupper(CHtml::value($item, 'firstname_en'));
                        $profile->midname_en = strtoupper(CHtml::value($item, 'midname_en'));
                        $profile->lastname_en = strtoupper(CHtml::value($item, 'lastname_en'));
                        $profile->birth_date = CHtml::value($item, 'birth_date');
                        $profile->birth_province = CHtml::value($item, 'birth_province');
                        $profile->nationality_id = CHtml::value($item, 'nationality');
                        $profile->contact_email = CHtml::value($item, 'email');
                        $profile->contact_phone = CHtml::value($item, 'mobile');
                        $profile->contact_mobile = CHtml::value($item, 'mobile');
                        $profile->work_position = CHtml::value($item, 'position');
                        $profile->work_level = '99';
                        $profile->work_level_other = CHtml::value($item, 'level');
                        $profile->work_office_id = '9999';
                        $profile->work_office_other = strtoupper(CHtml::value($item, 'office'));
                        $profile->passport_no = CHtml::value($item, 'passport_no');
                        $profile->passport_issue_country = CHtml::value($item, 'passport_issue_country');
                        $profile->passport_issue_date = CHtml::value($item, 'passport_issue_date');
                        $profile->passport_expire_date = CHtml::value($item, 'passport_expire_date');
                    }
                    if ($profile->save()) {

                        if ($this->import_type === self::TYPE_FOREIGN) {
                            $key = KeyCounter::getNewKey('foreigner_register');
                            $account->scenario = 'importForeigner';
                            $account->username = 'F' . str_pad(CHtml::value($profile, 'nationality_id', '999'), 3, '0', STR_PAD_LEFT) . str_pad(CHtml::value($profile, 'passport_issue_country', '999'), 3, '0', STR_PAD_LEFT) . str_pad($key, 6, '0', STR_PAD_LEFT);
                            $account->entry_code = $account->username;
                            $account->save();
                        }

                        $application = ExamApplication::model()->findByAttributes(array(
                            'account_id' => $account->id,
                            'exam_schedule_id' => $this->exam_schedule_id,
                        ));
                        if (!isset($application)) {
                            $application = new ExamApplication('bulk');
                            $application->apply_type = ExamApplication::APPLY_STAFF_IMPORT;
                            $application->is_applicable = ExamApplication::YES;
                            $application->account_id = $account->id;
                            $application->exam_schedule_id = $this->exam_schedule_id;
                            $application->exam_schedule_objective_id = $this->exam_schedule_objective_id;
                            if (!$application->apply(false)) {
                                throw new CException('ไม่สามารถสมัครบัญชี <span class="text-primary">' . $profile->firstname_en . ' ' . $profile->lastname_en . '</span><br/> ' . CHtml::errorSummary($application) . '');
                            }
                        } else {
                            $application->is_applicable = ExamApplication::YES;
                            $application->capital_name = $this->course_name;
                            $application->capital_description = $this->course_date;
                            $application->save();
                        }
                    } else {
                        throw new CException('ไม่สามารถสร้างบัญชี <span class="text-primary">' . $profile->firstname_en . ' ' . $profile->lastname_en . '</span><br/> ' . CHtml::errorSummary($profile) . '');
                    }
                } else {
                    throw new CException('ไม่สามารถสร้างบัญชีได้ (' . CHtml::errorSummary($account) . ')');
                }
            }
            $transaction->commit();
            return true;
        } catch (CException $e) {
            Yii::app()->user->setFlash('success', $e->getMessage());
            $transaction->rollback();
        }
        return false;
    }

}
