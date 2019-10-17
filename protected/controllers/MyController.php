<?php

class MyController extends Controller {

   public $model;

   public function init() {
      parent::init();
      $this->model = Account::model()->findByPk(Yii::app()->user->id);
   }

   public function actionIndex() {
      $model = $this->model;
      $model->scenario = 'changePassword';
      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->save()) {
            Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
            $this->redirect(array('index'));
         }
      }
      $this->render('index', array(
          'model' => $this->model,
      ));
   }

   public function actionResult() {
      $model = new ExamApplication('search');
      $model->unsetAttributes();
      $model->account_id = $this->model->id;
      $dataProvider = $model->scopeValid()->with(array('examSchedule' => array('together' => true)))->sortBy('examSchedule.exam_code DESC, t.desk_no')->search();
      $dataProvider->pagination = false;
      $this->render('result', array(
          'model' => $this->model,
          'dataProvider' => $dataProvider,
      ));
   }




   public function actionresultForm($id) {

      $profile = $this->model->getProfile();
      $account =Yii::app()->user->Account;

      $model = new ExamApplicationResult('search');
      $model->exam_application_id = $id;
      $model->name =$profile->fullname;
      $model->member_id =$account->id;
      $model->id_card =$account->username;
      $model->tel =$profile->contact_phone;

      $addr = $profile->reply_address_homeno;
      if(isset( $profile->reply_address_building))
         $addr = $addr . " " . $profile->reply_address_building;

      if(isset( $profile->reply_address_floor))
         $addr = $addr . " " . $profile->reply_address_floor;

      if(isset( $profile->reply_address_soi))
         $addr = $addr . " " . $profile->reply_address_soi;

      if(isset( $profile->reply_address_street))
         $addr = $addr . " " . $profile->reply_address_street;

      if(isset( $profile->reply_address_province_id)){
         $province = CodeProvince::model()->findByPk($profile->reply_address_province_id);
         $addr = $addr . " " . $province->name;
      }

      if(isset( $profile->reply_address_amphur_id)){
         $aumper = CodeAmphur::model()->findByPk($profile->reply_address_amphur_id);
         $addr = $addr . " " . $aumper->name;
      }

      if(isset( $profile->reply_address_tumbon_id)){
         $tumbon = CodeTumbon::model()->findByPk($profile->reply_address_tumbon_id);
         $addr = $addr . " " . $tumbon->name;
      }

      if(isset( $profile->reply_address_postcode))
         $addr = $addr . " " . $profile->reply_address_postcode;

      $model->address =$addr;
      $model->is_request = 1;

      $exam = ExamApplication::model()->findByPk($id);
      $model->exam_schedule_id =  $exam->exam_schedule_id;

      if (Yii::app()->request->isPostRequest) {
         $model->attributes = Yii::app()->request->getPost(get_class($model));
         if(!isset( $model->address)){
            $model->address = 'N/A';
         }
         $model->request_date= new CDbExpression('NOW()');

         $valid =  $model->validate();
         if (!Yii::app()->request->isAjaxRequest && $valid && $model->save(false)) {
            $exam = ExamApplication::model()->findByPk($id);
            $exam->doRequestResult();
            $excode = $exam->examSchedule->exam_code;
            $text = 'สถาบันการต่างประเทศฯ<br/>ได้รับคำร้องการขอใบรับรองผลการทดสอบ DIFA TES (รอบสอบ ' . $excode . ') ฉบับใหม่/ขอเพิ่ม<br/>โดยได้จัดส่งแบบฟอร์มการชำระเงินไปที่ Email ของท่านเรียบร้อยแล้ว<br/><br/>กรุณาชำระค่าธรรมเนียมและส่งหลักฐานการชำระเงินให้สถาบันการต่างประเทศฯ<br/>ที่ Email : difates.thailand@gmail.com หรือ โทรสาร 02 143 9326';
            $textmail = 'สถาบันการต่างประเทศฯ<br/>ได้รับคำร้องการขอใบรับรองผลการทดสอบ DIFA TES (รอบสอบ ' . $excode . ') ฉบับใหม่ของท่านเรียบร้อยแล้ว<br/><br/>กรุณาชำระค่าธรรมเนียมและส่งหลักฐานการชำระเงินให้สถาบันการต่างประเทศฯ<br/>ที่ Email : difates.thailand@gmail.com หรือ โทรสาร 02 143 9326<br/><br/>ทั้งนี้ สถาบันการต่างประเทศฯ จะดำเนินการออกใบรับรองผลการทดสอบฯ และจัดส่งให้ตามช่องทางที่ท่านระบุภายใน 7 วันทำการ นับจากวันถัดไปจากที่ได้รับหลักฐานการชำระเงินแล้ว<br/><br/>ดาวน์โหลดแบบฟอร์มการชำระเงินได้ตามเอกสารแนบ';
            Mailer::sendRequestResult($profile->contact_email, array(
                          'data' => array(
                                'model' => $model,
                          ),
                          'message' => array(
                                'text' => $textmail,
                          ),
                       ));

            Yii::app()->user->setFlash('success', $text);
            $this->redirect(array('result'));
         }
      }
      $this->render('resultForm', array(
                    'model' => $model,
                    'profile' => $profile,
                    'account' => $account
                ));
   }


   public function actionRequestResult($id) {
      $model = ExamApplication::model()->findByPk($id);
      $model->doRequestResult();
      if (!Yii::app()->request->isAjaxRequest) {
         $data = Yii::app()->user->Account;
         if(isset($data)){
            Mailer::sendRequestResult($data->getProfile()->contact_email, array(
                  'data' => array(
                      'model' => $data,
                  ),
                 'message' => array(
                      'text' => 'มารับใบรับรองได้ตั้งแต่วันที่' . Yii::app()->format->formatDate(Helper::getNextWorkDay(date("Y-m-d"), 3)) . 'ติดต่อที่เบอร์ 02-2035000 ต่อ 47024 ในเวลาราชการ',
                  ),
              ));
         }

         Yii::app()->user->setFlash('success', 'มารับใบรับรองได้ตั้งแต่วันที่' . Yii::app()->format->formatDate(Helper::getNextWorkDay(date("Y-m-d"), 3)) . 'ติดต่อที่เบอร์ 02-2035000 ต่อ 47024 ในเวลาราชการ');
         $this->redirect(array('result'));
      }
   }
   public function actionPrintCerSlip() {
      $pdf = new PDFMaker;
      $pdf->addRequestResltTmpSlip();
      $pdf->output();
   }


   public function actionSecurity() {
      $model = $this->model;
      $model->scenario = 'changePassword';
      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;
         $model->legacy_date = date('Y-m-d H:i:s');
         $model->is_legacy_update = 1;
         if ($model->save()) {
            Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
            $this->redirect(array('index'));
         }
      }
      $this->render('security', array(
          'model' => $this->model,
      ));
   }

   public function actionProfile() {
      $profile = $this->model->getProfile();
      $profile->scenario = 'update';
      if (!$this->model->secure_question_1) {
         $this->model->secure_question_1 = '10';
      }
      $data = Yii::app()->request->getPost(get_class($profile));
      if (isset($data)) {
         $profile->attributes = $data;
         $this->model->attributes = Yii::app()->request->getPost('Account');
         $valid = $profile->validateRegister();
         if ($valid && !Yii::app()->request->isAjaxRequest && $profile->save() && $this->model->save()) {
            Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
            $this->redirect(array('profile'));
         } else {
            //var_dump($this->model->errors, $profile->errors);
            //exit;
            //$this->model->validate();
            //$profile->validate();
         }
      }

      switch (get_class($profile)) {
         case 'AccountProfileGeneralThai':
            Yii::app()->setLanguage('th');
            $view = 'createGeneralThai';
            break;
         case 'AccountProfileGeneralForeigner':
            Yii::app()->setLanguage('en');
            $view = 'createGeneralForeigner';
            break;
         case 'AccountProfileDiplomatThai':
            Yii::app()->setLanguage('th');
            $view = 'createDiplomatThai';
            break;
         case 'AccountProfileDiplomatForeigner':
            Yii::app()->setLanguage('en');
            $view = 'createDiplomatForeigner';
            break;
         case 'AccountProfileOfficeUser':
            $this->redirect(array('office/profile'));
            break;
      }

      $this->render('profile', array(
          'model' => $this->model,
          'profile' => $profile,
          'view' => $view,
      ));
   }

   public function actionApplication() {
      $model = new ExamApplication('search');
      $model->unsetAttributes();
      $model->account_id = $this->model->id;
      $dataProvider = $model->sortBy()->scopeValid()->search();
      $dataProvider->pagination = false;
      $this->render('application', array(
          'model' => $this->model,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionCertificate() {
      $model = new ExamApplication('search');
      $model->unsetAttributes();
      $model->account_id = $this->model->id;
      $dataProvider = $model->with(array('examSchedule' => array('together' => true)))->scopeValid()->sortBy('examSchedule.db_date DESC')->search();
      $dataProvider->pagination = false;
      $this->render('certificate', array(
          'model' => $this->model,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionSchedule() {
      $this->render('schedule', array(
          'model' => $this->model,
      ));
   }

   public function actionChangeName() {
      $log = new ProfileChangeName('search');
      $log->unsetAttributes();
      $log->account_id = $this->model->id;
      $dataProvider = $log->sortBy('created DESC')->search();
      $dataProvider->pagination = false;

      $work = new ProfileChangeDepartment('search');
      $work->unsetAttributes();
      $work->account_id = $this->model->id;
      $workProvider = $work->sortBy('created DESC')->search();
      $workProvider->pagination = false;
      $this->render('changeName', array(
          'model' => $this->model,
          'profile' => $this->model->getProfile(),
          'dataProvider' => $dataProvider,
          'workProvider' => $workProvider,
      ));
   }

   public function actionGetSelfFile() {
      $file = CHtml::value($this, 'model.profile.selfFile.filePath');
      Yii::app()->request->sendFile(basename($file), $file);
   }

}

