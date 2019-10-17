<?php

class DebugController extends AdministratorController {

    public function actionSms() {
        $data = Yii::app()->request->getPost('sms');
        if (isset($data)) {
            $sms = new Sms;
            $result = $sms->sendDebug($data['msisdn'], $data['message']);
            Yii::app()->user->setFlash('success', 'ผลการส่งข้อความ : "<pre>"' . print_r($result, true) . "</pre>");
            $this->redirect(['sms']);
        }
        $this->render('sms');
    }

    public function actionGeneratePermission() {
        $permission = new Permission;
        $permission->generatePermissionTable();
        Yii::app()->user->setFlash('success', 'สร้างสิทธิการใช้งานเรียบร้อย');
        $this->redirect(array('home/index'));
    }

    public function actionMemberClear() {
        set_time_limit(0);
        $accounts = Account::model()->findAll();
        foreach ($accounts as $account) {
            $account->delete();
        }
        Yii::app()->user->setFlash('success', 'ลบข้อมูลเรียบร้อย');
        $this->redirect(array('home/index'));
    }

    public function actionMail() {
        Yii::import('administrator.models.DebugMailerForm');
        $model = new DebugMailerForm;
        $data = Yii::app()->request->getPost('DebugMailerForm');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->send()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('mail'));
            }
        }
        $this->render('mail', array(
            'model' => $model,
        ));
    }

    public function actionImport20160511() {
        set_time_limit(0);
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/difa20160728e.xlsx');
        $sheet = $objPHPExcel->getActiveSheet();
        $rows = $sheet->getRowIterator();

        $transaction = Yii::app()->db->beginTransaction();

        $titleOptions = array(
            'นาย' => '1',
            'นาง' => '2',
            'นางสาว' => '3',
        );
        $religionOptions = array(
            'พุทธ' => '1',
            'คริสต์' => '2',
            'อิสลาม' => '3',
        );
        $educateOptions = array(
            'ปริญญาเอก' => 'P',
            'ปริญญาโท' => 'M',
            'ปริญญาตรี' => 'B',
        );


        foreach ($rows as $count => $row) {
            /* @var $row PHPExcel_Worksheet_Row */
            if ($count <= 1) {
                continue;
            }
            $account = Account::model()->findByAttributes(array(
                'username' => $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
            ));
            if (!isset($account)) {
                $account = new Account;
                $account->username = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                $account->save(false);
                $account->isNewRecord = false;
                $account->created = new CDbExpression('NOW()');
            }
            $account->entry_code = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
            $account->secret = Account::encrypt($sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue());
            $account->account_type_id = 1;
            $account->is_staff_user = 1;
            $account->status = Account::STATUS_ACTIVED;
            $account->created = new CDbExpression('NOW()');
            $account->modified = new CDbExpression('NOW()');
            $account->save(false);

            $profile = $account->getProfile();
            if (!isset($profile)) {
                $profile = new AccountProfileGeneralThai;
                $profile->account_id = $account->id;
                $profile->save(false);
                $profile->isNewRecord = false;
            }

            $profile->title_id_th = isset($titleOptions[$sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue()]) ? $titleOptions[$sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue()] : 'O';
            $profile->title_th = $profile->title_id_th === 'O' ? $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue() : null;
            $profile->title_id_en = $profile->title_id_th;
            $profile->title_en = $profile->title_id_en === 'O' ? strtoupper($sheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue()) : null;

            $profile->firstname_th = $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
            $profile->lastname_th = $sheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
            $profile->firstname_en = strtoupper($sheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue());
            $profile->lastname_en = strtoupper($sheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());

            $profile->gender = $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue() === 'ชาย' ? 'M' : 'F';
            $profile->birth_date = date('Y-m-d', Helper::excelDateToUnix($sheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue()));

            $profile->religion_id = isset($religionOptions[$sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue()]) ? $religionOptions[$sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue()] : '9999';
            $profile->religion_other = $sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue();
            $profile->nationality_id = '764';

            $profile->educate_degree = isset($educateOptions[$sheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue()]) ? $educateOptions[$sheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue()] : 'O';
            $profile->educate_subject = $sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue();
            $profile->educate_university = $sheet->getCellByColumnAndRow(14, $row->getRowIndex())->getValue();
            $profile->educate_country = $sheet->getCellByColumnAndRow(15, $row->getRowIndex())->getValue();

            $profile->work_office_type = '1';
            $profile->work_office_id = '9999';

            if ($sheet->getCellByColumnAndRow(50, $row->getRowIndex())->getValue()) {
                $profile->work_office_other = $sheet->getCellByColumnAndRow(50, $row->getRowIndex())->getValue();
            } else {
                $profile->work_office_other = $sheet->getCellByColumnAndRow(17, $row->getRowIndex())->getValue();
            }

            if ($sheet->getCellByColumnAndRow(49, $row->getRowIndex())->getValue()) {
                $profile->work_department = $sheet->getCellByColumnAndRow(49, $row->getRowIndex())->getValue();
            } else {
                $profile->work_department = $sheet->getCellByColumnAndRow(16, $row->getRowIndex())->getValue();
            }

            $profile->work_position = $sheet->getCellByColumnAndRow(18, $row->getRowIndex())->getValue();
            $profile->work_level = 99;
            $profile->work_level_other = $sheet->getCellByColumnAndRow(19, $row->getRowIndex())->getValue();

            $profile->emp_card = $sheet->getCellByColumnAndRow(20, $row->getRowIndex())->getValue();
            $profile->emp_card_issue_date = $sheet->getCellByColumnAndRow(21, $row->getRowIndex())->getValue();
            $profile->emp_card_expire_date = $sheet->getCellByColumnAndRow(22, $row->getRowIndex())->getValue();

            $profile->work_address_homeno = $sheet->getCellByColumnAndRow(23, $row->getRowIndex())->getValue();
            $profile->work_address_building = $sheet->getCellByColumnAndRow(24, $row->getRowIndex())->getValue();
            $profile->work_address_floor = $sheet->getCellByColumnAndRow(25, $row->getRowIndex())->getValue();
            $profile->work_address_soi = $sheet->getCellByColumnAndRow(26, $row->getRowIndex())->getValue();
            $profile->work_address_street = $sheet->getCellByColumnAndRow(27, $row->getRowIndex())->getValue();
            $profile->work_address_tumbon_id = $sheet->getCellByColumnAndRow(58, $row->getRowIndex())->getValue();
            $profile->work_address_amphur_id = $sheet->getCellByColumnAndRow(59, $row->getRowIndex())->getValue();
            $profile->work_address_province_id = $sheet->getCellByColumnAndRow(60, $row->getRowIndex())->getValue();
            $profile->work_address_postcode = $sheet->getCellByColumnAndRow(31, $row->getRowIndex())->getValue();

            $profile->reply_address_homeno = $sheet->getCellByColumnAndRow(32, $row->getRowIndex())->getValue();
            $profile->reply_address_building = $sheet->getCellByColumnAndRow(33, $row->getRowIndex())->getValue();
            $profile->reply_address_floor = $sheet->getCellByColumnAndRow(34, $row->getRowIndex())->getValue();
            $profile->reply_address_soi = $sheet->getCellByColumnAndRow(35, $row->getRowIndex())->getValue();
            $profile->reply_address_street = $sheet->getCellByColumnAndRow(36, $row->getRowIndex())->getValue();
            $profile->reply_address_tumbon_id = $sheet->getCellByColumnAndRow(64, $row->getRowIndex())->getValue();
            $profile->reply_address_amphur_id = $sheet->getCellByColumnAndRow(65, $row->getRowIndex())->getValue();
            $profile->reply_address_province_id = $sheet->getCellByColumnAndRow(66, $row->getRowIndex())->getValue();
            $profile->reply_address_postcode = $sheet->getCellByColumnAndRow(40, $row->getRowIndex())->getValue();

            $profile->contact_phone_country = '+66';
            $profile->contact_phone = $sheet->getCellByColumnAndRow(41, $row->getRowIndex())->getValue();
            $profile->contact_fax_country = '+66';
            $profile->contact_fax = $sheet->getCellByColumnAndRow(42, $row->getRowIndex())->getValue();
            $profile->contact_mobile_country = '+66';
            $profile->contact_mobile = $sheet->getCellByColumnAndRow(43, $row->getRowIndex())->getValue();
            $profile->contact_email = $sheet->getCellByColumnAndRow(44, $row->getRowIndex())->getValue();
            $profile->emergency_name = $sheet->getCellByColumnAndRow(45, $row->getRowIndex())->getValue();
            $profile->emergency_phone = $sheet->getCellByColumnAndRow(46, $row->getRowIndex())->getValue();

            $profile->save(false);
            if ($account->hasErrors()) {
                var_dump($account->errors);
                exit;
            }
            if ($profile->hasErrors()) {
                var_dump($profile->errors);
                exit;
            }

            $examSchedule = ExamSchedule::model()->findByPk($sheet->getCellByColumnAndRow(54, $row->getRowIndex())->getValue());
            $examSchedule->addApplication($account);

            echo $account->username . '.... Done<br/>';
        }

        $transaction->commit();
    }

    public function actionImport2() {
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/20160511.xlsx');
        $sheet = $objPHPExcel->getActiveSheet();
        $rows = $sheet->getRowIterator();

        $transaction = Yii::app()->db->beginTransaction();
        foreach ($rows as $row) {
            if ((int) $sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue()) {
                $account = Account::model()->findByAttributes(array(
                    'username' => $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                ));
                if (!isset($account)) {
                    $account = new Account;
                    $account->username = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                    $account->save(false);
                    $account->isNewRecord = false;
                    $account->created = new CDbExpression('NOW()');
                }
                $account->entry_code = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                $account->secret = Account::encrypt($sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue());
                $account->account_type_id = 3;
                $account->status = Account::STATUS_ACTIVED;
                $account->created = new CDbExpression('NOW()');
                $account->modified = new CDbExpression('NOW()');
                $account->save(false);

                $profile = $account->getProfile();
                if (!isset($profile)) {
                    $profile = new AccountProfileDiplomatThai;
                    $profile->account_id = $account->id;
                    $profile->save(false);
                    $profile->isNewRecord = false;
                }
                $profile->diplomat_type = 'THAILAND';
                $profile->title_th = $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                $profile->firstname_th = $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
                $profile->lastname_th = $sheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
                $profile->title_en = $sheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue();
                $profile->firstname_en = strtoupper($sheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue());
                $profile->lastname_en = strtoupper($sheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());
                $profile->diplomat_position = $sheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue() === 'Diplomat' ? 'DPMT' : 'TICA';
                $profile->diplomat_level = '9999';
                $profile->diplomat_level_other = $sheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
                $profile->diplomat_office = $sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue();
                $profile->contact_voip = $sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue();
                $profile->contact_mobile_country = '66';
                $profile->contact_mobile = $sheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue();
                $profile->contact_email = $sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue();

                list($profile->educate_bachelor_year_from, $profile->educate_bachelor_year_to) = array_pad(explode('-', $sheet->getCellByColumnAndRow(17, $row->getRowIndex())->getValue()), 2, null);

                $profile->educate_bachelor = $sheet->getCellByColumnAndRow(16, $row->getRowIndex())->getValue();
                $profile->educate_bachelor_university = $sheet->getCellByColumnAndRow(18, $row->getRowIndex())->getValue();
                $profile->educate_bachelor_country = $sheet->getCellByColumnAndRow(19, $row->getRowIndex())->getValue();

                $profile->save(false);
                if ($account->hasErrors()) {
                    var_dump($account->errors);
                    exit;
                }
                if ($profile->hasErrors()) {
                    var_dump($profile->errors);
                    exit;
                }
            }
        }
        $transaction->commit();
    }

    public function actionImport() {
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/import-diplomat-thai.xls');
        $sheet = $objPHPExcel->getActiveSheet();
        $rows = $sheet->getRowIterator();

        $transaction = Yii::app()->db->beginTransaction();

        foreach ($rows as $row) {
            if ((int) $sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue()) {
                $account = Account::model()->findByAttributes(array(
                    'username' => $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue(),
                ));
                if (!isset($account)) {
                    $account = new Account;
                    $account->username = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                    $account->save(false);
                    $account->isNewRecord = false;
                    $account->created = new CDbExpression('NOW()');
                }
                $account->entry_code = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                $account->secret = Account::encrypt($sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue());
                $account->account_type_id = 3;
                $account->status = Account::STATUS_ACTIVED;
                $account->created = new CDbExpression('NOW()');
                $account->modified = new CDbExpression('NOW()');
                $account->save(false);

                $profile = $account->getProfile();
                if (!isset($profile)) {
                    $profile = new AccountProfileDiplomatThai;
                    $profile->account_id = $account->id;
                    $profile->save(false);
                    $profile->isNewRecord = false;
                }
                $profile->diplomat_type = 'THAILAND';
                $profile->title_th = $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                $profile->firstname_th = $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
                $profile->lastname_th = $sheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
                $profile->title_en = $sheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue();
                $profile->firstname_en = strtoupper($sheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue());
                $profile->lastname_en = strtoupper($sheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());
                $profile->diplomat_position = $sheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue() === 'Diplomat' ? 'DPMT' : 'TICA';
                $profile->diplomat_level = '9999';
                $profile->diplomat_level_other = $sheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
                $profile->diplomat_office = $sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue();
                $profile->contact_voip = $sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue();
                $profile->contact_mobile_country = '66';
                $profile->contact_mobile = $sheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue();
                $profile->contact_email = $sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue();

                list($profile->educate_bachelor_year_from, $profile->educate_bachelor_year_to) = array_pad(explode('-', $sheet->getCellByColumnAndRow(17, $row->getRowIndex())->getValue()), 2, null);

                $profile->educate_bachelor = $sheet->getCellByColumnAndRow(16, $row->getRowIndex())->getValue();
                $profile->educate_bachelor_university = $sheet->getCellByColumnAndRow(18, $row->getRowIndex())->getValue();
                $profile->educate_bachelor_country = $sheet->getCellByColumnAndRow(19, $row->getRowIndex())->getValue();

                $profile->save(false);

                if ($account->hasErrors()) {
                    var_dump($account->errors);
                    exit;
                }
                if ($profile->hasErrors()) {
                    var_dump($profile->errors);
                    exit;
                }
            }
        }
        $transaction->commit();
    }

    public function actionUat() {
        $examSchedule = ExamSchedule::model()->findByPk(108);
        $data = array(
            "5100900112115",
            "3101400689086",
            "1101401989826",
            "1102001453474",
            "1101400781806",
            "1101401818363",
            "1102001602747",
            "1101401967105",
            "1100500100354",
            "1609900111161",
            "1100701142411",
            "1100700535222",
            "1709900568585",
            "1659900279576",
            "1669900122430",
            "1529900348331",
            "1709900627476",
            "1100400290615",
            "3659900396340",
            "3250400534242",
            "1859900073844",
            "1103300047363",
            "1101401908621",
            "1509900891248",
            "1100900422260",
            "1909800473629",
            "2630100018930",
            "1100700314081",
            "1239900156117",
            "1103300002629",
            "1819900099479",
            "1100500380331",
            "1160100256781",
            "1100701346610",
            "1103700816020",
            "1100800664288",
            "1101400983981",
            "1100800455450",
            "3469900098120",
            "1101401883181",
            "1103700120319",
            "1509900842867",
            "2301300019526",
            "1101401682585",
            "1102001070206",
            "1102700055036",
            "1103700542175",
            "1209700324326",
            "1909800291792",
            "1103300059531",
            "1341100126991",
            "1100700919811",
            "1102001473394",
            "1100701307673",
            "1100800688586",
            "1849900114095",
            "1100900400126",
            "1200100222885",
            "1100400646851",
            "5100500037582",
            "1101401681708",
            "1539900255317",
            "1101400582153",
            "1102800018060",
            "1100800181899",
            "5100900011131",
            "1199900213944",
            "1709900335882",
            "5100900176270",
            "1909800474013",
            "1910100134726",
            "1103300009437",
            "1199900091547",
            "3100602091679",
            "1100700690481",
            "1100701300369",
            "1103300091745",
            "1769900239689",
            "1100800423931",
            "1929900219970",
            "1100600217628",
            "1101401548455",
            "1100700951447",
            "1529900392403",
            "1101401707171",
            "1103700460527",
            "1102001097961",
            "1100800596274",
            "1100600169895",
            "1100800300804",
            "1101500419980",
            "1100700210005",
            "1101401898405",
            "1729900123028",
            "1830100065261",
            "3321000374256",
            "1101700064531",
            "1101401506515",
            "1103000012084",
            "1100800504612",
        );
        $criteria = new CDbCriteria();
        $criteria->addInCondition('username', $data);
        $accounts = Account::model()->findAll($criteria);
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($accounts as $account) {
                $examSchedule->addApplication($account);
            }
            $transaction->commit();
        } catch (CException $e) {
            var_dump($e->getMessage());
            $transaction->rollback();
        }
    }

    public function actionTestCase1() {
        $schedule_ids = array(37, 38, 42, 43, 46, 47, 50, 53, 54, 57, 58);

        foreach ($schedule_ids as $count => $schedule_id) {
            $applications = ExamApplication::model()->scopeValid()->findAllByAttributes(array(
                'exam_schedule_id' => $schedule_id,
            ));
            foreach ($applications as $application) {
                /* @var $application ExamApplication */
                if ($count % 2) {
                    $item = ExamScheduleItem::model()->findByAttributes(array(
                        'exam_schedule_id' => $schedule_id,
                        'exam_set_id' => 'ETL0002_15',
                    ));
                    if (!isset($item)) {
                        echo $schedule_id . ':ETL0002_15';
                        exit;
                    }
                    $application->takeExamSet($item);

                    $item = ExamScheduleItem::model()->findByAttributes(array(
                        'exam_schedule_id' => $schedule_id,
                        'exam_set_id' => 'ETR0002_15',
                    ));
                    if (!isset($item)) {
                        echo $schedule_id . ':ETR0002_15';
                        exit;
                    }
                    $application->takeExamSet($item);
                } else {
                    $item = ExamScheduleItem::model()->findByAttributes(array(
                        'exam_schedule_id' => $schedule_id,
                        'exam_set_id' => 'ETL0001_15',
                    ));
                    if (!isset($item)) {
                        echo $schedule_id . ':ETL0001_15';
                        exit;
                    }
                    $application->takeExamSet($item);

                    $item = ExamScheduleItem::model()->findByAttributes(array(
                        'exam_schedule_id' => $schedule_id,
                        'exam_set_id' => 'ETR0001_15',
                    ));
                    if (!isset($item)) {
                        echo $schedule_id . ':ETR0001_15';
                        exit;
                    }
                    $application->takeExamSet($item);
                }
            }
        }
    }

    public function actionGenerateName() {
        /*
          $applications = ExamApplication::model()->findAllByAttributes(array(
          'is_confirm' => 1,
          )); */
        $criteria = new CDbCriteria();
        $criteria->addCondition('firstname_th = lastname_th');
        $criteria->compare('is_confirm', 1);
        $applications = ExamApplication::model()->findAll($criteria);
        foreach ($applications as $application) {
            /* @var $application ExamApplication */
            $application->fullname_en = CHtml::value($application->account, 'profile.fullnameEn');
            $application->title_en = CHtml::value($application->account, 'profile.textTitleEn');
            $application->firstname_en = CHtml::value($application->account, 'profile.textFirstnameEn');
            $application->midname_en = CHtml::value($application->account, 'profile.textMidnameEn');
            $application->lastname_en = CHtml::value($application->account, 'profile.textLastnameEn');
            $application->fullname_th = CHtml::value($application->account, 'profile.fullnameTh');
            $application->title_th = CHtml::value($application->account, 'profile.textTitleTh');
            $application->firstname_th = CHtml::value($application->account, 'profile.textFirstnameTh');
            $application->midname_th = CHtml::value($application->account, 'profile.textMidnameTh');
            $application->lastname_th = CHtml::value($application->account, 'profile.textLastnameTh');

            $application->department = CHtml::value($application->account, 'profile.textDepartment');
            $application->office = CHtml::value($application->account, 'profile.textWorkOffice');
            $application->department_th = CHtml::value($application->account, 'profile.textDepartmentTh', $application->department);
            $application->office_th = CHtml::value($application->account, 'profile.textWorkOfficeTh', $application->office);

            $application->save();
        }
    }

    public function actionImport20170327() {
        set_time_limit(0);
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/difa20170327.xlsx');
        $sheet = $objPHPExcel->getActiveSheet();
        $rows = $sheet->getRowIterator();

        $transaction = Yii::app()->db->beginTransaction();

        $titleOptions = array(
            'Mr.' => '1',
            'Mrs.' => '2',
            'Ms.' => '3',
        );
        $religionOptions = array(
            'พุทธ' => '1',
            'คริสต์' => '2',
            'อิสลาม' => '3',
        );
        $educateOptions = array(
            'ปริญญาเอก' => 'P',
            'ปริญญาโท' => 'M',
            'bachelor' => 'B',
        );

        $accounts = array();
        foreach ($rows as $count => $row) {
            /* @var $row PHPExcel_Worksheet_Row */
            if ($count <= 1) {
                continue;
            }

            if (substr($sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue(), 1, 2) !== '00') {
                continue;
            }

            $account = Account::model()->findByAttributes(array(
                'username' => $sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue(),
            ));
            if (!isset($account)) {
                $account = new Account;
                $account->username = $sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
                $account->save(false);
                $account->isNewRecord = false;
                $account->created = new CDbExpression('NOW()');
            }
            $account->entry_code = $sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
            $account->secret = Account::encrypt($sheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue());
            $account->account_type_id = 2;
            $account->is_staff_user = 1;
            $account->status = Account::STATUS_ACTIVED;
            $account->created = new CDbExpression('NOW()');
            $account->modified = new CDbExpression('NOW()');
            $account->save(false);

            $profile = $account->getProfile();
            if (!isset($profile)) {
                $profile = new AccountProfileGeneralForeigner;
                $profile->account_id = $account->id;
                $profile->save(false);
                $profile->isNewRecord = false;
            }

            $profile->gender = $sheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue() === 'Male' ? 'M' : 'F';
            $profile->title_id_en = isset($titleOptions[$sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue()]) ? $titleOptions[$sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue()] : 'O';
            $profile->title_en = $profile->title_id_en === 'O' ? $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue() : null;


            $profile->firstname_en = strtoupper($sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue());
            $profile->midname_en = strtoupper($sheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue());
            $profile->lastname_en = strtoupper($sheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue());
            $profile->birth_date = strtoupper($sheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue());
            $profile->religion_id = null;
            switch ($sheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue()) {
                case 'Lao':
                    $profile->nationality_id = '418';
                    break;
                case 'Burmese':
                    $profile->nationality_id = '104';
                    break;
                case 'Cambodian':
                    $profile->nationality_id = '116';
                    break;
            }


            $profile->educate_degree = 'B';
            $profile->educate_degree_other = null;
            $profile->educate_subject = $sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue();
            $profile->educate_university = $sheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue();
            $profile->educate_country = $sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue();
            $profile->work_office_id = '9999';
            $profile->work_office_other = $sheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue();
            $profile->work_department = null;
            $profile->work_position = $sheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
            $profile->work_level = '99';
            $profile->work_level_other = '';
            $profile->work_address = $sheet->getCellByColumnAndRow(14, $row->getRowIndex())->getValue();
            $profile->work_address_country_id = $profile->nationality_id;
            $profile->work_address_postcode = $sheet->getCellByColumnAndRow(16, $row->getRowIndex())->getValue();
            $profile->reply_address = $sheet->getCellByColumnAndRow(17, $row->getRowIndex())->getValue();
            $profile->reply_address_country_id = $profile->nationality_id;
            $profile->reply_address_postcode = $sheet->getCellByColumnAndRow(19, $row->getRowIndex())->getValue();
            $profile->contact_phone_country = '';
            $profile->contact_phone = '';
            $profile->contact_phone_ext = '';
            $profile->contact_fax_country = '';
            $profile->contact_fax = '';
            $profile->contact_mobile_country = '';
            $profile->contact_mobile = $sheet->getCellByColumnAndRow(20, $row->getRowIndex())->getValue();
            $profile->contact_email = $sheet->getCellByColumnAndRow(21, $row->getRowIndex())->getValue();
            $profile->emergency_name = '';
            $profile->emergency_phone = '';

            $profile->passport_no = $sheet->getCellByColumnAndRow(23, $row->getRowIndex())->getValue();
            $profile->passport_issue_country = $profile->nationality_id;
            $profile->passport_issue_date = $sheet->getCellByColumnAndRow(25, $row->getRowIndex())->getValue();
            $profile->passport_expire_date = $sheet->getCellByColumnAndRow(26, $row->getRowIndex())->getValue();
            $profile->is_same_address = 1;
            $profile->religion_other = null;
            $profile->emp_type = $sheet->getCellByColumnAndRow(22, $row->getRowIndex())->getValue() === 'Passport' ? AccountProfileGeneralForeigner::EMP_PASSPORT : AccountProfileGeneralForeigner::EMP_SELF;

            $profile->save(false);
            if ($account->hasErrors()) {
                var_dump($account->errors);
                exit;
            }
            if ($profile->hasErrors()) {
                var_dump($profile->errors);
                exit;
            }

            $accounts[$account->username] = $account;
            echo $account->username . '.... Done<br/>';
        }

        ksort($accounts);

        foreach ($accounts as $app) {
            $examSchedule = ExamSchedule::model()->findByPk('196');
            $examSchedule->addApplication($app, '0');
        }

        $transaction->commit();
    }

}
