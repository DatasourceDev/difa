<?php

class ImportCommand extends CConsoleCommand {

    public function actionImport20160622e() {
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/difa20160622e.xlsx');
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

            echo $account->username . '.... Done' . "\n";
        }

        $transaction->commit();
    }

    public function actionImport20160622() {
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
        $objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.test-xls') . '/difa20160622.xlsx');
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

            if (!in_array($count, array(
                        216,
                        217,
                        219,
                        220,
                        221,
                        222,
                        223,
                        224,
                        225,
                        226,
                        227,
                        228,
                        229,
                        230,
                        231,
                    ))) {
                continue;
            }

            echo $count . ':' . $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue() . "\n";
            continue;

            $account = Account::model()->findByAttributes(array(
                'username' => $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue(),
            ));
            if (!isset($account)) {
                $account = new Account;
                $account->username = $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                $account->save(false);
                $account->isNewRecord = false;
                $account->created = new CDbExpression('NOW()');
            }
            $account->entry_code = $sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
            $account->secret = Account::encrypt($sheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue());
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

            $profile->title_id_th = isset($titleOptions[$sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue()]) ? $titleOptions[$sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue()] : 'O';
            $profile->title_th = $profile->title_id_th === 'O' ? $sheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue() : null;
            $profile->title_id_en = $profile->title_id_th;
            $profile->title_en = $profile->title_id_en === 'O' ? strtoupper($sheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue()) : null;

            $profile->firstname_th = $sheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
            $profile->lastname_th = $sheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue();
            $profile->firstname_en = strtoupper($sheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());
            $profile->lastname_en = strtoupper($sheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue());

            $profile->gender = $sheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue() === 'ชาย' ? 'M' : 'F';
            $profile->birth_date = date('Y-m-d', Helper::excelDateToUnix($sheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue()));

            $profile->religion_id = isset($religionOptions[$sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue()]) ? $religionOptions[$sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue()] : '9999';
            $profile->religion_other = $sheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue();
            $profile->nationality_id = '764';

            $profile->educate_degree = isset($educateOptions[$sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue()]) ? $educateOptions[$sheet->getCellByColumnAndRow(13, $row->getRowIndex())->getValue()] : 'O';
            $profile->educate_subject = $sheet->getCellByColumnAndRow(14, $row->getRowIndex())->getValue();
            $profile->educate_university = $sheet->getCellByColumnAndRow(15, $row->getRowIndex())->getValue();
            $profile->educate_country = $sheet->getCellByColumnAndRow(16, $row->getRowIndex())->getValue();

            $profile->work_office_type = '1';
            $profile->work_office_id = '9999';

            if ($sheet->getCellByColumnAndRow(51, $row->getRowIndex())->getValue()) {
                $profile->work_office_other = $sheet->getCellByColumnAndRow(51, $row->getRowIndex())->getValue();
            } else {
                $profile->work_office_other = $sheet->getCellByColumnAndRow(18, $row->getRowIndex())->getValue();
            }

            if ($sheet->getCellByColumnAndRow(50, $row->getRowIndex())->getValue()) {
                $profile->work_department = $sheet->getCellByColumnAndRow(50, $row->getRowIndex())->getValue();
            } else {
                $profile->work_department = $sheet->getCellByColumnAndRow(17, $row->getRowIndex())->getValue();
            }

            $profile->work_position = $sheet->getCellByColumnAndRow(19, $row->getRowIndex())->getValue();
            $profile->work_level = 99;
            $profile->work_level_other = $sheet->getCellByColumnAndRow(20, $row->getRowIndex())->getValue();

            $profile->emp_card = $sheet->getCellByColumnAndRow(21, $row->getRowIndex())->getValue();
            $profile->emp_card_issue_date = $sheet->getCellByColumnAndRow(22, $row->getRowIndex())->getValue();
            $profile->emp_card_expire_date = $sheet->getCellByColumnAndRow(23, $row->getRowIndex())->getValue();

            $profile->work_address_homeno = $sheet->getCellByColumnAndRow(24, $row->getRowIndex())->getValue();
            $profile->work_address_building = $sheet->getCellByColumnAndRow(25, $row->getRowIndex())->getValue();
            $profile->work_address_floor = $sheet->getCellByColumnAndRow(26, $row->getRowIndex())->getValue();
            $profile->work_address_soi = $sheet->getCellByColumnAndRow(27, $row->getRowIndex())->getValue();
            $profile->work_address_street = $sheet->getCellByColumnAndRow(28, $row->getRowIndex())->getValue();
            $profile->work_address_tumbon_id = $sheet->getCellByColumnAndRow(59, $row->getRowIndex())->getValue();
            $profile->work_address_amphur_id = $sheet->getCellByColumnAndRow(60, $row->getRowIndex())->getValue();
            $profile->work_address_province_id = $sheet->getCellByColumnAndRow(61, $row->getRowIndex())->getValue();
            $profile->work_address_postcode = $sheet->getCellByColumnAndRow(32, $row->getRowIndex())->getValue();

            $profile->reply_address_homeno = $sheet->getCellByColumnAndRow(33, $row->getRowIndex())->getValue();
            $profile->reply_address_building = $sheet->getCellByColumnAndRow(34, $row->getRowIndex())->getValue();
            $profile->reply_address_floor = $sheet->getCellByColumnAndRow(35, $row->getRowIndex())->getValue();
            $profile->reply_address_soi = $sheet->getCellByColumnAndRow(36, $row->getRowIndex())->getValue();
            $profile->reply_address_street = $sheet->getCellByColumnAndRow(37, $row->getRowIndex())->getValue();
            $profile->reply_address_tumbon_id = $sheet->getCellByColumnAndRow(65, $row->getRowIndex())->getValue();
            $profile->reply_address_amphur_id = $sheet->getCellByColumnAndRow(66, $row->getRowIndex())->getValue();
            $profile->reply_address_province_id = $sheet->getCellByColumnAndRow(67, $row->getRowIndex())->getValue();
            $profile->reply_address_postcode = $sheet->getCellByColumnAndRow(41, $row->getRowIndex())->getValue();

            $profile->contact_phone_country = '+66';
            $profile->contact_phone = $sheet->getCellByColumnAndRow(42, $row->getRowIndex())->getValue();
            $profile->contact_fax_country = '+66';
            $profile->contact_fax = $sheet->getCellByColumnAndRow(43, $row->getRowIndex())->getValue();
            $profile->contact_mobile_country = '+66';
            $profile->contact_mobile = $sheet->getCellByColumnAndRow(44, $row->getRowIndex())->getValue();
            $profile->contact_email = $sheet->getCellByColumnAndRow(45, $row->getRowIndex())->getValue();
            $profile->emergency_name = $sheet->getCellByColumnAndRow(46, $row->getRowIndex())->getValue();
            $profile->emergency_phone = $sheet->getCellByColumnAndRow(47, $row->getRowIndex())->getValue();

            $profile->save(false);
            if ($account->hasErrors()) {
                var_dump($account->errors);
                exit;
            }
            if ($profile->hasErrors()) {
                var_dump($profile->errors);
                exit;
            }

            $examSchedule = ExamSchedule::model()->findByPk($sheet->getCellByColumnAndRow(55, $row->getRowIndex())->getValue());
            $examSchedule->addApplication($account);

            echo $account->username . '.... Done' . "\n";
        }

        $transaction->commit();
    }

}
