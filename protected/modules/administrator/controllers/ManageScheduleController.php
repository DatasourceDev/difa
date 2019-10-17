<?php

class ManageScheduleController extends AdministratorController {

   public $layout = '/manageSchedule/_layout';
   public $title = 'ข้อมูลการจัดสอบ';
   public $label1 = 'เลื่อนไปที่';

   public function actionIndex() {
      $model = new ExamSchedule('search');
      $model->unsetAttributes();
      $model->attributes = Yii::app()->request->getQuery('ExamSchedule');
      $dataProvider = $model->with('examType:scopeActive')->sortBy('exam_code DESC')->search();
      $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
      $this->render('index', array(
          'model' => $model,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionCalendar() {
      $this->title = 'ปฏิทินการสอบ';
      $this->label1 = 'เลื่อนไปที่';
      $this->render('calendar', array(
      ));
   }

   public function actionDoPresent($id) {
      $model = ExamApplication::model()->findByPk($id);

      if (Yii::app()->request->isPostRequest) {
         if ($model->doConfirm()) {
            Yii::app()->user->setFlash('success', 'ลงทะเบียนเรียบร้อย');
            $this->redirect(array('viewAttendee', 'id' => $model->exam_schedule_id));
         }
      }

      $this->renderPartial('do-present', array(
          'model' => $model,
      ));
   }

   public function actionClickDay($d) {
      $holiday = CodeHoliday::model()->findByPk($d);
      if (isset($holiday)) {
         $this->renderPartial('createHoliday', array(
             'holiday' => $holiday,
         ));
      } else {
         $model = new ExamSchedule();
         $model->db_date = $d;
         $this->renderPartial('clickDay', array(
             'model' => $model,
         ));
      }
   }

   public function actionClickEvent($id) {
      $model = ExamSchedule::model()->findByAttributes(array(
          'exam_code' => $id,
      ));
      $this->renderPartial('clickEvent', array(
          'model' => $model,
      ));
   }

   public function actionCreate($d) {
      $model = new ExamSchedule();
      $model->db_date = $d;
      $data = Yii::app()->request->getPost('ExamSchedule');
      if (isset($data)) {
         $model->attributes = $data;
         $model->loadDefaultFee();
         if(isset($data->calendar_color)){
            $model->loadDefaultColor();
         }
         if (!Yii::app()->request->isAjaxRequest && $model->create()) {
            $this->redirect(array('view', 'id' => $model->id));
         }
      }
      $this->render('form', array(
          'model' => $model,
      ));
   }

   public function actionUpdate($id) {
      $model = ExamSchedule::model()->findByPk($id);

      if (empty($model->calendar_color)) {
         $model->loadDefaultColor();
      }

      if ($model->isExpired) {
         $model->is_close = ExamSchedule::YES;
      }
      $data = Yii::app()->request->getPost('ExamSchedule');
      if (isset($data)) {
         $model->attributes = $data;
         if (!Yii::app()->request->isAjaxRequest && $model->save()) {
            $this->redirect(array('view', 'id' => $model->id));
         }
      }
      $this->render('form', array(
          'model' => $model,
      ));
   }

   public function actionUpdateInfo($id) {
      $model = ExamApplication::model()->findByPk($id);
      $model->scenario = 'updateInfo';
      $data = Yii::app()->request->getPost('ExamApplication');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->save()) {
            echo CJSON::encode(array('success' => true));
            Yii::app()->end();
         }
      }
      $this->renderPartial('updateInfo', array(
          'model' => $model,
      ));
   }

   public function actionFeed($start = null, $end = null) {
      header('Content-Type: application/json');
      $ret = array();
      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('id', $start, $end);
      $holidays = CodeHoliday::model()->findAll($criteria);
      foreach ($holidays as $holiday) {
         $ret[] = array(
             'title' => Yii::app()->language === 'th' ? $holiday->name_th : $holiday->name_en,
             'start' => $holiday->id,
             'className' => 'event-holiday',
         );
      }

      $criteria = new CDbCriteria();
      $criteria->with = array(
          'examSchedule' => array(
              'together' => true,
          ),
      );
      $criteria->addBetweenCondition('t.db_date', $start, $end);
      $criteria->group = 'examSchedule.exam_code';
      $events = ExamScheduleItem::model()->findAll($criteria);
      foreach ($events as $event) {
         $ret[] = array(
             'id' => $event->examSchedule->exam_code,
             'title' => $event->examSchedule->getExamCodeText(),
             'start' => $event->db_date,
             'className' => 'event-exam ' . $event->examSchedule->examType->getClassName() . $event->examSchedule . ' ' . $event->examSchedule->eventClass,
             'color' => $event->examSchedule->calendar_color ? $event->examSchedule->calendar_color : $event->examSchedule->badgeColor,
             'description' => $event->examSchedule->remark,
         );
      }
      echo CJSON::encode($ret);
   }

   public function actionDelete($id) {
      $model = ExamSchedule::model()->findByPk($id);
      if (isset($model)) {
         if ($model->delete()) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
         }
      }
      if (!Yii::app()->request->isAjaxRequest) {
         $this->redirect(array('index'));
      }
   }

   public function actionView($id) {
      $model = ExamSchedule::model()->findByPk($id);

      $examSet = new ExamScheduleItem('search');
      $examSet->unsetAttributes();
      $examSet->exam_schedule_id = $model->id;
      $examSetProvider = $examSet->sortBy('t.order_no')->search();
      $examSetProvider->pagination = false;

      $this->render('view', array(
          'model' => $model,
          'examSetProvider' => $examSetProvider,
      ));
   }

   public function actionViewObjective($id) {
      $model = ExamSchedule::model()->findByPk($id);

      $objective = new ExamScheduleObjective('search');
      $objective->unsetAttributes();
      $objective->exam_schedule_id = $model->id;
      $dataProvider = $objective->search();
      $dataProvider->pagination = false;

      $this->render('viewObjective', array(
          'model' => $model,
          'objective' => $objective,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionViewAttendee($id, $exam_set_id = null) {
      Yii::app()->qz->deploy();
      $model = ExamSchedule::model()->findByPk($id);

      if ($exam_set_id) {
         $examSet = ExamScheduleItem::model()->findByAttributes(array('exam_schedule_id' => $model->id, 'exam_set_id' => $exam_set_id));
      } else {
         $examSet = ExamScheduleItem::model()->findByAttributes(array('exam_schedule_id' => $model->id));
      }

      if (!isset($examSet)) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดข้อสอบก่อน');
         $this->redirect(array('viewExamSet', 'id' => $model->id));
      }

      $menu = array();
      foreach ($model->examScheduleItems as $item) {
         if (isset($item->examSet)) {
            $menu[] = array(
                'label' => $item->examSet->id,
                'url' => array('viewAttendee', 'id' => $model->id, 'exam_set_id' => $item->exam_set_id),
                'buttonType' => 'link',
                'context' => $examSet->exam_set_id === $item->exam_set_id ? 'primary' : 'info',
                'active' => $examSet->exam_set_id === $item->exam_set_id,
            );
         }
      }


      $application = new ExamApplication('search');
      $application->unsetAttributes();
      $application->exam_schedule_id = $model->id;
      $dataProvider = $application->scopeValid()->scopeActive()->sortBy('desk_no')->search();
      $dataProvider->pagination = false;

      $data = Yii::app()->request->getPost('ExamApplication');
      if (isset($data)) {
         $desk = ExamApplication::model()->scopeValid()->findByAttributes(array(
             'exam_schedule_id' => $model->id,
             'desk_code' => CHtml::value($data, 'desk_code'),
         ));
         if (isset($desk)) {
            if ($desk->doSeatIn()) {
               if (!Yii::app()->request->isAjaxRequest) {
                  $this->redirect(array('viewAttendee', 'id' => $model->id));
               } else {
                  echo CJSON::encode(array(
                      'result' => true,
                      'description' => 'ลงทะเบียนเรียบร้อย',
                      'deskCode' => CHtml::value($data, 'desk_code'),
                  ));
                  Yii::app()->end();
               }
            } else {
               echo CJSON::encode(array(
                   'result' => false,
                   'description' => Helper::errorSummary($desk),
               ));
               Yii::app()->end();
            }
         }

         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('account.entry_code', CHtml::value($data, 'desk_code'));
         $criteria->compare('t.exam_schedule_id', $model->id);
         $desk = ExamApplication::model()->scopeValid()->find($criteria);
         if (isset($desk)) {
            if ($desk->doSeatIn()) {
               if (!Yii::app()->request->isAjaxRequest) {
                  $this->redirect(array('viewAttendee', 'id' => $model->id));
               } else {
                  echo CJSON::encode(array(
                      'result' => true,
                      'description' => 'ลงทะเบียนเรียบร้อย',
                      'deskCode' => CHtml::value($data, 'desk_code'),
                  ));
                  Yii::app()->end();
               }
            } else {
               echo CJSON::encode(array(
                   'result' => false,
                   'description' => Helper::errorSummary($desk),
               ));
               Yii::app()->end();
            }
         }
         echo CJSON::encode(array(
             'result' => false,
             'description' => 'ไม่พบผู้เข้าสอบที่มีรหัสตรงกัน',
         ));
         Yii::app()->end();
      }

      $this->render('viewAttendee', array(
          'model' => $model,
          'application' => $application,
          'dataProvider' => $dataProvider,
          'menu' => $menu,
          'examSet' => $examSet,
      ));
   }

   public function actionViewUser($id) {
      $model = ExamSchedule::model()->findByPk($id);

      $account = new ExamScheduleAccount('search');
      $account->unsetAttributes();
      $account->exam_schedule_id = $model->id;
      $dataProvider = $account->search();

      $this->render('viewUser', array(
          'model' => $model,
          'account' => $account,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionViewExamSet($id) {
      $model = ExamSchedule::model()->findByPk($id);

      $examScheduleItem = new ExamScheduleItem('search');
      $examScheduleItem->unsetAttributes();
      $examScheduleItem->exam_schedule_id = $model->id;
      //$dataProvider = $examScheduleItem->sortBy('t.db_date, t.time_start, t.order_no')->search();
      $dataProvider = $examScheduleItem->with(array('examSubject' => array('together' => true)))->sortBy('examSubject.order_no')->search();
      $dataProvider->pagination = false;

      $this->render('viewExamSet', array(
          'model' => $model,
          'examScheduleItem' => $examScheduleItem,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionPrintNameList($id) {

   }

   public function actionPrintCard($id) {
      $model = ExamApplication::model()->findByPk($id);
      PDFHelper::printPayinSlip($model);
   }

   public function actionRegisterGeneralThai($id) {
      $this->title = 'สมัครสอบ สำหรับคนไทย';
      $schedule = ExamSchedule::model()->findByPk($id);

      $model = new Account('createGeneralThai');

      $profile = new AccountProfileGeneralThai('register');
      $profile->nationality_id = CHtml::value(CodeCountry::model()->findByAttributes(array('alpha2' => 'TH')), 'id');
      $profile->contact_phone_country = '66';
      $profile->contact_fax_country = '66';
      $profile->contact_mobile_country = '66';
      $this->render('registerGeneralThai', array(
          'schedule' => $schedule,
          'model' => $model,
          'profile' => $profile,
      ));
   }

   public function actionRegister($id) {
      $this->title = 'เจ้าหน้าที่สถาบัน สมัครสอบให้';
      $model = ExamSchedule::model()->findByPk($id);

      $register = new StaffRegisterForm;
      $data = Yii::app()->request->getPost('StaffRegisterForm');
      if (isset($data)) {
         $register->attributes = $data;
         if ($register->save()) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
            $this->redirect(array('viewAttendee', 'id' => $model->id));
         }
      }
      $this->render('register', array(
          'model' => $model,
          'register' => $register,
      ));
   }

   public function actionCheckExistingAccount($id, $exam_schedule_id) {
      $examSchedule = ExamSchedule::model()->findByPk($exam_schedule_id);
      $model = Account::model()->findByAttributes(array(
          'entry_code' => $id,
      ));
      if (isset($model)) {
         $examSchedule->checkCondition();
         $examSchedule->checkDuplicateApply($id);
         $application = ExamApplication::model()->findByAttributes(array(
             'account_id' => $model->id,
             'exam_schedule_id' => $examSchedule->id,
             'is_confirm' => ActiveRecord::YES,
             'is_applicable' => ActiveRecord::YES,
         ));
         $this->renderPartial('checkExistingAccount', array(
             'model' => $model,
             'examSchedule' => $examSchedule,
             'application' => $application,
         ));
      } else {
         echo 'OK';
      }
   }

   /**
    * สมัครสอบ จากบัญชีที่มีอยู่เดิม
    * @param int $id Account ID
    * @param int $exam_schedule_id Exam Schedule ID
    */
   public function actionAccountApply($id, $exam_schedule_id) {
      /* @var $examSchedule ExamSchedule */
      $examSchedule = ExamSchedule::model()->findByPk($exam_schedule_id);

      $application = new ExamApplication;
      $application->account_id = $id;
      $application->exam_schedule_id = $examSchedule->id;

      $data = Yii::app()->request->getPost('ExamApplication');
      if (isset($data)) {
         $application->attributes = $data;
         if ($application->apply(true)) {
            Yii::app()->user->setFlash('success', 'ทำการสมัครเรียบร้อย');
            $this->redirect(array('viewAttendee', 'id' => $examSchedule->id));
         }
      }

      $this->render('accountApply', array(
          'application' => $application,
          'examSchedule' => $examSchedule,
      ));
   }

   /**
    * สมัครสอบ จากบัญชีที่มีอยู่เดิม (แบบ List)
    * @param int $id Exam Schedule ID
    */
   public function actionAccountApplyFromList($id) {
      /* @var $examSchedule ExamSchedule */
      $examSchedule = ExamSchedule::model()->findByPk($id);

      if ($examSchedule->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $examSchedule->id));
      }

      if (!$examSchedule->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $examSchedule->id));
      }

      $application = new ExamApplication();
      $application->apply_type = ExamApplication::APPLY_STAFF;
      $application->exam_schedule_id = $examSchedule->id;
      $data = Yii::app()->request->getPost('ExamApplication');
      if (isset($data)) {
         $application->attributes = $data;
         // Bypass Rule
         $application->is_applicable = ExamApplication::YES;
         if ($application->apply(false, true)) {
            Yii::app()->user->setFlash('success', 'ทำการสมัครเรียบร้อย');
            $this->redirect(array('viewAttendee', 'id' => $examSchedule->id));
         }
      }

      $this->render('accountApplyFromList', array(
          'application' => $application,
          'examSchedule' => $examSchedule,
      ));
   }

   public function actionCreateGeneralThai($id) {
      /* @var $model ExamSchedule */
      $model = ExamSchedule::model()->findByPk($id);
      /*
      if ($model->getIsExpired()) {
      Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากหมดเขตการสมัครสอบ');
      $this->redirect(array('view', 'id' => $model->id));
      } */

      if ($model->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $model->id));
      }

      if (!$model->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $model->id));
      }

      Yii::app()->user->setState('current_language', 'th');
      Yii::app()->language = 'th';
      $profile = new AccountProfileGeneralThai('register');
      $profile->nationality_id = CHtml::value(CodeCountry::model()->findByAttributes(array('alpha2' => 'TH')), 'id');
      $profile->educate_country = 'ไทย';
      $profile->contact_phone_country = '66';
      $profile->contact_fax_country = '66';
      $profile->contact_mobile_country = '66';
      $this->create(1, $profile, 'createGeneralThaiByStaff', 'createGeneralThai', $model);
   }

   public function actionCreateGeneralForeigner($id) {
      $model = ExamSchedule::model()->findByPk($id);
      /*
      if ($model->getIsExpired()) {
      Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากหมดเขตการสมัครสอบ');
      $this->redirect(array('view', 'id' => $model->id));
      } */

      if ($model->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $model->id));
      }

      if (!$model->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $model->id));
      }

      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(2, new AccountProfileGeneralForeigner('register'), 'createGeneralForeignerByStaff', 'createGeneralForeigner', $model);
   }

   public function actionCreateDiplomatThai($id) {
      $model = ExamSchedule::model()->findByPk($id);
      /*
      if ($model->getIsExpired()) {
      Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากหมดเขตการสมัครสอบ');
      $this->redirect(array('view', 'id' => $model->id));
      } */

      if ($model->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $model->id));
      }

      if (!$model->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $model->id));
      }

      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(3, new AccountProfileDiplomatThai('register'), 'createDiplomatThaiByStaff', 'createDiplomatThai', $model);
   }

   public function actionCreateDiplomatForeigner($id) {
      $model = ExamSchedule::model()->findByPk($id);
      /*
      if ($model->getIsExpired()) {
      Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากหมดเขตการสมัครสอบ');
      $this->redirect(array('view', 'id' => $model->id));
      } */

      if ($model->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $model->id));
      }

      if (!$model->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $model->id));
      }

      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(4, new AccountProfileDiplomatForeigner('register'), 'createDiplomatForeignerByStaff', 'createDiplomatForeigner', $model);
   }

   public function create($type, $profile, $scenario, $view, $schedule) {
      $model = new Account($scenario);
      $model->account_type_id = $type;
      $pwd = Helper::randomString();
      $model->password_input = $pwd;
      $model->password_confirm = $pwd;
      $model->tmp_password = $pwd;
      $model->status = Account::STATUS_ACTIVED;
      $model->is_office_user = ActiveRecord::YES;
      $model->is_staff_user = ActiveRecord::YES;
      if (Yii::app()->request->isPostRequest) {
         $model->attributes = Yii::app()->request->getPost('Account');
         $profile->attributes = Yii::app()->request->getPost(get_class($profile));
         $profile->account_id = 0;
         $valid = $profile->validateRegister() & $model->validate();
         $model->cProfile = $profile;

         if (!Yii::app()->request->isAjaxRequest && $valid && $model->save(false)) {
            $profile->account_id = $model->id;
            $profile->save(false);

            $application = new ExamApplication;
            $application->apply_type = ExamApplication::APPLY_STAFF;
            $application->exam_schedule_id = $schedule->id;
            $application->account_id = $model->id;
            $application->exam_schedule_objective_id = 1;
            $application->is_applicable = 1;
            if ($application->apply(false)) {
               Mailer::sendAccountInfo($profile->contact_email, array(
                   'data' => array(
                       'model' => $model,
                   ),
               ));
               $this->redirect(array('viewAttendee', 'id' => $schedule->id));
            }
         }
      }
      $this->render($view, array(
          'model' => $model,
          'profile' => $profile,
          'schedule' => $schedule,
      ));
   }

   /**
    * นำเข้าข้อมูลผู้สมัครจากระบบฝึกอบรม
    */
   public function actionImportFile($id) {
      $model = ExamSchedule::model()->findByPk($id);

      if ($model->getQuotaExceed()) {
         Yii::app()->user->setFlash('success', 'ไม่สามารถสมัครเพิ่มได้ เนื่องจากที่นั่งสอบเต็ม');
         $this->redirect(array('view', 'id' => $model->id));
      }

      if (!$model->getIsExamSetReady()) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดสอบก่อน');
         $this->redirect(array('view', 'id' => $model->id));
      }

      $examSet = ExamScheduleItem::model()->findByAttributes(array('exam_schedule_id' => $model->id));
      if (!isset($examSet)) {
         Yii::app()->user->setFlash('success', 'กรุณาเพิ่มชุดข้อสอบก่อน');
         $this->redirect(array('viewExamSet', 'id' => $model->id));
      }


      $import = new ExamScheduleImport;
      $import->exam_schedule_id = $model->id;
      $data = Yii::app()->request->getPost('ExamScheduleImport');
      if (isset($data)) {
         $import->attributes = $data;

         if (!Yii::app()->request->isAjaxRequest) {
            switch (Yii::app()->request->getQuery('mode')) {
               case 'save':
                  if ($import->saveBulk()) {
                     Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                     $this->redirect(array('viewAttendee', 'id' => $model->id));
                  } else {
                     $this->render('importForm', array(
                         'model' => $import,
                     ));
                  }
                  Yii::app()->end();
                  break;
               default:
                  if ($import->import()) {
                     Yii::app()->user->setFlash('success', 'นำเข้าข้อมูลเรียบร้อย');
                     $this->render('importForm', array(
                         'model' => $import,
                     ));
                     Yii::app()->end();
                  }
                  break;
            }
         }
      }

      $this->render('importFile', array(
          'model' => $model,
          'import' => $import,
      ));
   }

   public function actionImport($id) {
      $examSchedule = ExamSchedule::model()->findByPk($id);

      Yii::import('administrator.models.AccountGeneralThaiImportForm');
      $model = new AccountGeneralThaiImportForm;
      $data = Yii::app()->request->getPost('AccountGeneralThaiImportForm');
      if (isset($data)) {
         $model->attributes = $data;
         switch (Yii::app()->request->getQuery('mode')) {
            case 'save':
               if ($model->save()) {
                  Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                  $this->redirect(array('index'));
               } else {
                  $this->render('importForm', array(
                      'model' => $model,
                  ));
               }
               Yii::app()->end();
               break;
            default:
               if ($model->import()) {
                  Yii::app()->user->setFlash('success', 'นำเข้าข้อมูลเรียบร้อย');
                  $this->render('importForm', array(
                      'model' => $model,
                  ));
                  Yii::app()->end();
               }
               break;
         }
      }
      $this->render('import', array(
          'model' => $model,
      ));
   }

   public function actionAttendeeCancel($id) {
      $model = ExamApplication::model()->findByPk($id);
      if (isset($model)) {
         $model->cancel();
         if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('viewAttendee', 'id' => $model->exam_schedule_id));
         }
      } else {
         throw new CHttpException(404, 'ไม่พบหน้าที่คุณต้องการ');
      }
   }

   public function actionTest() {
      $model = ExamApplication::model()->findByAttributes(array(
          'exam_schedule_id' => 37,
          'account_id' => 55,
      ));
      $model->apply();
   }

   public function actionLoginManager($id) {
      $this->redirect(array('/manager/home/autoLogin', 'id' => $id));
   }

   public function actionViewAttendeeExamSet($id) {
      $examSchedule = ExamSchedule::model()->findByPk($id);

      $model = new ExamApplication('search');
      $model->unsetAttributes();
      $model->exam_schedule_id = $examSchedule->id;
      $dataProvider = $model->scopeValid()->scopeActive()->sortBy('desk_no')->search();
      $dataProvider->pagination = false;
      $skillsColumn = array();
      $skills = $examSchedule->examScheduleItems;
      foreach ($skills as $skill) {
         $skillsColumn[] = array(
             'header' => CHtml::value($skill, 'examSubject.name'),
             'value' => 'CHtml::value($data,"")',
             'headerHtmlOptions' => array(
                 'class' => 'text-center',
             ),
             'htmlOptions' => array(
                 'class' => 'text-center',
             ),
         );
      }

      $examSet = new ExamSet;
      $examSet->unsetAttributes();
      $examSet->exam_type_id = $examSchedule->exam_type_id;
      $examSet->exam_schedule_id = $examSchedule->id;

      $this->render('viewAttendeeExamSet', array(
          'model' => $model,
          'dataProvider' => $dataProvider,
          'skills' => $skills,
          'skillsColumn' => $skillsColumn,
          'examSet' => $examSet,
          'examSchedule' => $examSchedule,
      ));
   }

   public function actionViewAttendeeExamSpeaking($id) {
      $examSchedule = ExamSchedule::model()->findByPk($id);

      $model = new ExamApplication('search');
      $model->unsetAttributes();
      $model->exam_schedule_id = $examSchedule->id;
      $dataProvider = $model->scopeValid()->scopeActive()->sortBy('desk_no')->search();
      $dataProvider->pagination = false;

      $skillsColumn = array();
      $skills = ExamSpeaking::model()->findAll();

      foreach ($skills as $skill) {
         $skillsColumn[] = array(
             'class' => 'booster.widgets.TbEditableColumn',
             'editable' => array(
                 'name' => 'data_' . $skill->id,
                 'url' => array('updateSpeaking'),
                 'params' => array(
                     'exam_speaking_id' => $skill->id,
                 ),
             ),
             'name' => 'exam_data',
             'header' => $skill->name,
             'value' => 'CHtml::value($data->getExamSpeakingByPk(' . $skill->id . '),"exam_data",null)',
             'htmlOptions' => array(
                 'class' => 'text-center',
             ),
             'headerHtmlOptions' => array(
                 'class' => 'text-center',
                 'style' => 'width:100px;'
             ),
         );
      }

      $examSet = new ExamSet;
      $examSet->unsetAttributes();
      $examSet->exam_type_id = $examSchedule->exam_type_id;
      $examSet->exam_schedule_id = $examSchedule->id;

      $this->render('viewAttendeeExamSpeaking', array(
          'model' => $model,
          'dataProvider' => $dataProvider,
          'skills' => $skills,
          'skillsColumn' => $skillsColumn,
          'examSet' => $examSet,
          'examSchedule' => $examSchedule,
      ));
   }

   public function actionChangeExamSet() {
      $pk = Yii::app()->request->getPost('pk');
      $name = Yii::app()->request->getPost('name');
      $value = Yii::app()->request->getPost('value');
      $exam_subject_id = Yii::app()->request->getPost('exam_subject_id');
      $exam_schedule_id = Yii::app()->request->getPost('exam_schedule_id');
      $model = ExamApplicationExamSet::model()->findByAttributes(array(
          'exam_schedule_id' => $exam_schedule_id,
          'exam_subject_id' => $exam_subject_id,
          'exam_application_id' => $pk,
      ));
      if (isset($model)) {
         $model->exam_set_id = $value;
         $model->save();
      } else {
         $model = new ExamApplicationExamSet;
         $model->exam_schedule_id = $exam_schedule_id;
         $model->exam_subject_id = $exam_subject_id;
         $model->exam_application_id = $pk;
         $model->exam_set_id = $value;
         $model->save();
      }
   }

   public function actionUpdateSpeaking() {
      $pk = Yii::app()->request->getPost('pk');
      $name = Yii::app()->request->getPost('name');
      $value = Yii::app()->request->getPost('value');
      $exam_speaking_id = Yii::app()->request->getPost('exam_speaking_id');
      $model = ExamApplicationSpeakingData::model()->findByAttributes(array(
          'exam_speaking_id' => $exam_speaking_id,
          'exam_application_id' => $pk,
      ));
      if (isset($model)) {
         $model->exam_data = $value;
         $model->save();
      } else {
         $model = new ExamApplicationSpeakingData;
         $model->exam_speaking_id = $exam_speaking_id;
         $model->exam_application_id = $pk;
         $model->exam_data = $value;
         $model->save();
      }
   }

   public function actionAjaxUpdateSpeakingExamSet() {
      $pk = Yii::app()->request->getPost('pk');
      $name = Yii::app()->request->getPost('name');
      $value = Yii::app()->request->getPost('value');
      $exam_subject_id = Yii::app()->request->getPost('exam_subject_id');
      $exam_schedule_id = Yii::app()->request->getPost('exam_schedule_id');
      $model = ExamApplicationExamSet::model()->findByAttributes(array(
          'exam_schedule_id' => $exam_schedule_id,
          'exam_subject_id' => $exam_subject_id,
          'exam_application_id' => $pk,
      ));
      if (isset($model)) {
         $model->exam_subject_extra = $value;
         $model->save();
      }
   }

   public function actionViewDepartment($id) {
      $model = ExamSchedule::model()->findByPk($id);

      $department = new ExamScheduleDepartment('search');
      $department->unsetAttributes();
      $department->exam_schedule_id = $model->id;
      $dataProvider = $department->search();
      $this->render('viewDepartment', array(
          'model' => $model,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionDepartmentAdd($id) {
      $model = ExamSchedule::model()->findByPk($id);
      $department = new CodeDepartment('search');
      $department->unsetAttributes();
      $department->attributes = Yii::app()->request->getQuery('CodeDepartment');

      $dataProvider = $department->sortBy('department_type_id, name_th')->search();
      $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
      $this->render('departmentAdd', array(
          'model' => $model,
          'department' => $department,
          'dataProvider' => $dataProvider,
      ));
   }

   public function actionDepartmentSelect($id, $exam_schedule_id) {
      $model = ExamScheduleDepartment::model()->findByAttributes(array(
          'code_department_id' => $id,
          'exam_schedule_id' => $exam_schedule_id,
      ));
      if (!isset($model)) {
         $model = new ExamScheduleDepartment;
         $model->code_department_id = $id;
         $model->exam_schedule_id = $exam_schedule_id;
         $model->save();
         Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
      }
      $this->redirect(array('viewDepartment', 'id' => $exam_schedule_id));
   }

   public function actionDepartmentDelete($exam_schedule_id, $code_department_id) {
      $model = ExamScheduleDepartment::model()->findByAttributes(array(
          'code_department_id' => $code_department_id,
          'exam_schedule_id' => $exam_schedule_id,
      ));
      if (isset($model)) {
         Yii::app()->user->setFlash('success', 'ลบข้อมูลเรียบร้อย');
         $model->delete();
      }
      $this->redirect(array('viewDepartment', 'id' => $exam_schedule_id));
   }

}
