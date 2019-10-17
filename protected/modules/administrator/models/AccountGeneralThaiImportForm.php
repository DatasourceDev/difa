<?php

class AccountGeneralThaiImportForm extends CFormModel {

    public $course_name;
    public $course_date;
    public $excel_file;
    public $importData;

    public function columnMapper() {
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

    public function rules() {
        return array(
            array('course_name, course_date', 'required'),
            array('excel_file', 'file', 'allowEmpty' => false, 'types' => array('xls', 'xlsx')),
            array('importData', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'course_name' => 'ชื่อหลักสูตรฝึกอบรม',
            'course_date' => 'วันที่ฝึกอบรม',
            'excel_file' => 'ไฟล์ Excel',
        );
    }

    public function import() {
        if ($this->validate()) {
            $file = CUploadedFile::getInstance($this, 'excel_file');
            if ($file) {
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $objPHPExcel = PHPExcel_IOFactory::load($file->tempName);
                $sheet = $objPHPExcel->getActiveSheet();
                $this->importData = array();
                for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
                    $item = array();
                    foreach ($this->columnMapper() as $key => $name) {
                        $item[$name] = $sheet->getCellByColumnAndRow($key, $i)->getValue();
                        switch ($name) {
                            case 'nationality':
                            case 'passport_issue_country':
                                $item[$name] = CHtml::value(CodeCountry::model()->findByAttributes(array('name_th' => $item[$name])), 'id');
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

    public function save() {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($this->importData as $item) {
                $account = Account::model()->findByAttributes(array(
                    'username' => CHtml::value($item, 'username'),
                    'status' => Account::STATUS_ACTIVED,
                ));
                if (!isset($account)) {
                    $account = new Account('import');
                    $account->account_type_id = AccountType::getId('accountProfileGeneralThai');
                }
                $account->scenario = 'import';
                $account->entry_code = CHtml::value($item, 'username');
                $account->username = CHtml::value($item, 'username');
                $account->status = Account::STATUS_ACTIVED;
                $account->tmp_password = Helper::getTempPassword();
                $account->course_name = $this->course_name;
                $account->course_date = $this->course_date;
                if ($account->save()) {
                    $profile = $account->getProfile();
                    if (!isset($profile)) {
                        $profile = new AccountProfileGeneralThai('import');
                        $profile->account_id = $account->id;
                    }
                    $profile->scenario = 'import';
                    $profile->title_th = CHtml::value($item, 'title_th');
                    $profile->firstname_th = CHtml::value($item, 'firstname_th');
                    $profile->midname_th = CHtml::value($item, 'midname_th');
                    $profile->lastname_th = CHtml::value($item, 'lastname_th');
                    $profile->title_en = CHtml::value($item, 'title_en');
                    $profile->firstname_en = CHtml::value($item, 'firstname_en');
                    $profile->midname_en = CHtml::value($item, 'midname_en');
                    $profile->lastname_en = CHtml::value($item, 'lastname_en');
                    $profile->birth_date = CHtml::value($item, 'birth_date');
                    $profile->birth_province = CHtml::value($item, 'birth_province');
                    $profile->nationality_id = CHtml::value($item, 'nationality');
                    $profile->contact_email = CHtml::value($item, 'contact_email');
                    $profile->contact_phone = CHtml::value($item, 'contact_phone');
                    $profile->contact_mobile = CHtml::value($item, 'contact_mobile');
                    $profile->work_position = CHtml::value($item, 'position');
                    $profile->work_level = '99';
                    $profile->work_level_other = CHtml::value($item, 'level');
                    $profile->work_office_id = '9999';
                    $profile->work_office_other = CHtml::value($item, 'office');
                    $profile->passport_no = CHtml::value($item, 'passport_no');
                    $profile->passport_issue_country = CHtml::value($item, 'passport_issue_country');
                    $profile->passport_issue_date = CHtml::value($item, 'passport_issue_date');
                    $profile->passport_expire_date = CHtml::value($item, 'passport_expire_date');
                    if (!$profile->save()) {
                        throw new CException('Database error.');
                    }
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
