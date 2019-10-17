<?php

class SiteController extends Controller {

   public function accessRules() {
      return array_merge(array(
          array(
              'allow',
              'users' => array('*'),
              'actions' => array(
                  'qzSignRequest',
                  'qzTrayDownload',
                  'download',
                  'question',
              ),
          ),
          array(
              'allow',
              'users' => array('?'),
              'actions' => array(
                  'feed',
                  'clickDay',
                  'clickEvent',
                  'error',
                  'forgot',
                  'forgotUsername',
                  'forgotUsernameComplete',
                  'forgotQuestion',
                  'forgotComplete',
                  'index',
                  'switchLanguage',
                  'login',
                  'logout',
                  'captcha',
                  'calendar',
                  'createGeneralThai',
                  'createGeneralForeigner',
                  'createDiplomatThai',
                  'createDiplomatForeigner',
                  'resetPassword',
                  'takeback',
                  'takebackComplete',
                  'customTheme',
              ),
          ),
              ), parent::accessRules());
   }

   /**
    * Declares class-based actions.
    */
   public function actions() {
      return array(
          // captcha action renders the CAPTCHA image displayed on the contact page
          'captcha' => array(
              'class' => 'CCaptchaAction',
              'backColor' => 0xFFFFFF,
          ),
          // page action renders "static" pages stored under 'protected/views/site/pages'
          // They can be accessed via: index.php?r=site/page&view=FileName
          'page' => array(
              'class' => 'CViewAction',
          ),
          'qzSignRequest' => array(
              'class' => 'ext.qz-print.actions.QzSignRequestAction',
          ),
          'qzTrayDownload' => array(
              'class' => 'ext.qz-print.actions.QzTrayDownloadAction',
          ),
      );
   }

   /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    */
   public function actionIndex() {
      if (date('Y-m-d') <= '2018-01-31') {
         if (Yii::app()->user->isGuest) {
            $this->isRequestRepassword = true;
         } elseif (isset(Yii::app()->user->account) && Yii::app()->user->account->isLegacy) {
            $this->isRequestRepassword = true;
         }
      }

      if (!Yii::app()->user->isGuest) {
         if (Yii::app()->user->getIsOfficeUser()) {
            $this->redirect(array('office/index'));
         }
         $this->redirect(array('calendar'));
      }
      $examTypes = ExamType::model()->sortBy('id')->findAll();

      $contentList = new WebContent('search');
      $contentList->unsetAttributes();
      $contentProvider = $contentList->current()->search();

      if(!WebNewsTicker::useNewsTickerOptions()) {
         $i = 0;
         $items = WebContent::getContentList(3);
         $newsList = array(array());

         foreach ($items as $item) {
            $new =  array();
            $new[0] =  CHtml::value($item, 'name', '');
            $new[1] =  CHtml::value($item, 'id', '');
            $new[2] =  CHtml::value($item, 'custom_link');
            $newsList[$i++] =  $new;
         }
      }
      else {
         $i = 0;
			$newsList = array(array());
         $id =  Configuration::getKey('id');
         $datefrom1 =  Configuration::getKey('custom_date_from1');
         $dateto1 =  Configuration::getKey('custom_date_to1');
         if (( $datefrom1 ==null || date('Y-m-d') >= $datefrom1) && ( $dateto1 ==null ||  date('Y-m-d') <= $dateto1)) {
            if(!WebNewsTicker::useNewsTicker1Options()) {
               $item = WebContent::getContent(Configuration::getKey('custom_new1'));
               $new =  array();
               $new[0] =  CHtml::value($item, 'name', '');
               $new[1] =  CHtml::value($item, 'id', '');
               $new[2] =  CHtml::value($item, 'custom_link');
               $newsList[$i++] =  $new;
            }
            else{
               $custom_content1 = Configuration::getKey('custom_content1');
               if(isset($custom_content1) && $custom_content1 != '')
               {
                  $new =  array();
                  $new[0] = $custom_content1;
                  $new[1] =  0;
                  $new[2] =  "";
                  $newsList[$i++] = $new;
               }
            }
         }
         $datefrom2 =  Configuration::getKey('custom_date_from2');
         $dateto2 =  Configuration::getKey('custom_date_to2');
         if (( $datefrom2 ==null || date('Y-m-d') >= $datefrom2) && ( $dateto2 ==null ||  date('Y-m-d') <= $dateto2)) {
            if(!WebNewsTicker::useNewsTicker2Options()) {
               $item = WebContent::getContent(Configuration::getKey('custom_new2'));
               $new =  array();
               $new[0] =  CHtml::value($item, 'name', '');
               $new[1] =  CHtml::value($item, 'id', '');
               $new[2] =  CHtml::value($item, 'custom_link');
               $newsList[$i++] =  $new;
            }
            else{
               $custom_content2 = Configuration::getKey('custom_content2');
               if(isset($custom_content2) && $custom_content2 != '')
               {
                  $new =  array();
                  $new[0] =$custom_content2;
                  $new[1] =  0;
                  $new[2] =  "";
                  $newsList[$i++] = $new;
               }

            }
         }
         $datefrom3 =  Configuration::getKey('custom_date_from3');
         $dateto3 =  Configuration::getKey('custom_date_to3');
         if (( $datefrom3 ==null || date('Y-m-d') >= $datefrom3) && ( $dateto3 ==null ||  date('Y-m-d') <= $dateto3)) {
            if(!WebNewsTicker::useNewsTicker3Options()) {
               $item = WebContent::getContent(Configuration::getKey('custom_new3'));
               $new =  array();
               $new[0] =  CHtml::value($item, 'name', '');
               $new[1] =  CHtml::value($item, 'id', '');
               $new[2] =  CHtml::value($item, 'custom_link');
               $newsList[$i++] =  $new;
            }
            else{
               $custom_content3 = Configuration::getKey('custom_content3');
               if(isset($custom_content3) && $custom_content3 != '')
               {
                  $new =  array();
                  $new[0] = $custom_content3;
                  $new[1] =  0;
                  $new[2] =  "";
                  $newsList[$i++] = $new;
               }
            }
         }
      }

      $this->render('index', array(
          'examTypes' => $examTypes,
          'contentProvider' => $contentProvider,
          'newsList' => $newsList,
      ));
   }

   public function actionCalendar($exam_type_id = null) {
      $type = ExamType::model()->findByPk($exam_type_id);
      $this->render('calendar', array(
          'type' => $type,
      ));
   }

   /**
    * This is the action to handle external exceptions.
    */
   public function actionError() {
      if ($error = Yii::app()->errorHandler->error) {
         if (Yii::app()->request->isAjaxRequest)
            echo $error['message'];
         else
            $this->render('error', $error);
      }
   }

   /**
    * Displays the contact page
    */
   public function actionContact() {
      $model = new ContactForm;
      if (isset($_POST['ContactForm'])) {
         $model->attributes = $_POST['ContactForm'];
         if ($model->validate()) {
            $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
            $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
            $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

            mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
            Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
            $this->refresh();
         }
      }
      $this->render('contact', array('model' => $model));
   }
   public function actionDownload() {
      $model = WebDownload::model()->sortBy('order_no')->findAll();
      $this->render('download', array(
          'model' => $model
      ));
   }

   public function actionQuestion() {
      $model = WebFAQ::model()->sortBy('order_no')->findAll();
      $this->render('question', array(
          'model' => $model
      ));
   }

   /**
    * Displays the login page
    */
   public function actionLogin() {
      $model = new LoginForm;
      $model->attributes = Yii::app()->request->getQuery('LoginForm');
      // if it is ajax validation request
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
         echo CActiveForm::validate($model);
         Yii::app()->end();
      }

      $data = Yii::app()->request->getPost('LoginForm');
      if (isset($data)) {
         $model->attributes = $data;
         // validate user input and redirect to the previous page if valid
         if (Yii::app()->request->isPostRequest && $model->validate() && $model->login()) {
            $this->redirect(array('generateSessionKey'));
         }
      }
      // display the login form
      $this->render('login', array('model' => $model));
   }

   public function actionGenerateSessionKey() {
      if (Yii::app()->user->getIsOfficeUser()) {
         $model = CHtml::value(Yii::app()->user, 'account');
         if ($model) {
            Yii::app()->user->setState('session_ip', Yii::app()->request->userHostAddress);
            Yii::app()->user->setState('session_timeout', date('Y-m-d H:i:s', strtotime('+10 minutes')));
            Yii::app()->user->setState('session_key', time());
            $model->saveAttributes(array(
                'session_ip' => Yii::app()->user->getState('session_ip'),
                'session_timeout' => Yii::app()->user->getState('session_timeout'),
                'session_key' => Yii::app()->user->getState('session_key'),
            ));
         }
      }
      $this->redirect(array('index'));
   }

   /**
    * Logs out the current user and redirect to homepage.
    */
   public function actionLogout() {
      Yii::app()->user->logout();
      $this->redirect(Yii::app()->homeUrl);
   }

   public function actionSwitchLanguage($lang = 'th') {
      Yii::app()->user->setState('current_language', $lang);
      $this->redirect(Yii::app()->request->getQuery('returnUrl', Yii::app()->homeUrl));
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

         /* @todo change to programmatic */
         if ($event->examSchedule->examType->code === 'IH') {
            if (!in_array(CHtml::value(Yii::app()->user, 'account.account_type_id'), array('3', '4'))) {
               continue;
            }
         }

         if ($event->examSchedule->is_private === ExamSchedule::YES) {
            $departments = $event->examSchedule->examScheduleDepartments;
            /* case Diplomate */
            if (in_array(CHtml::value(Yii::app()->user, 'account.account_type_id'), array('3', '4'))) {
               if (!in_array(CHtml::value(Yii::app()->user, 'account.profile.work_office_id', 103), CHtml::listData($departments, 'code_department_id', 'code_department_id'))) {
                  continue;
               }
            } else { /* case General */
               if (!in_array(CHtml::value(Yii::app()->user, 'account.profile.work_office_id'), CHtml::listData($departments, 'code_department_id', 'code_department_id'))) {
                  continue;
               }
            }
         }


         $isExpired = false;
         $now = new DateTime();
         $date = new DateTime($event->examSchedule->db_date);
         if ($now <= $date) {
            $period = $date->diff($now);
            if ($period->days < 6) {
               $isExpired = true;
            }
         }

         $ret[] = array(
             'id' => $event->examSchedule->exam_code,
             'title' => $event->examSchedule->getExamCodeText(),
             'start' => $event->db_date,
             'className' => 'event-exam ' . $event->examSchedule->examType->getClassName() . $event->examSchedule . ' ' . $event->examSchedule->eventClass,
             'color' => $event->examSchedule->calendar_color ? $event->examSchedule->calendar_color : $event->examSchedule->badgeColor,
             'description' => $event->examSchedule->remark,
             'date_start' => $event->examSchedule->getRegisterDateStart(),
             'date_end' => $event->examSchedule->getRegisterDateEnd(),
         );
      }

      echo CJSON::encode($ret);
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

   public function actionForgotUsername() {
      $model = new AccountInquiry('forgotUsername');
      $data = Yii::app()->request->getPost('AccountInquiry');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->saveForgotUsername()) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'We have got you message. We will get to you before ' . Yii::app()->format->formatDate(Helper::getNextWorkDay(date('Y-m-d'), 2))));
            $this->redirect(array('forgotUsernameComplete'));
         }
      }
      $this->render('forgotUsername', array(
          'model' => $model,
      ));
   }

   public function actionForgotUsernameComplete() {
      $this->render('forgotUsernameComplete');
   }

   public function actionForgot() {
      $model = new Account('forgot');
      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;



         if ($model->validate()) {
            /* ถ้าเป็น User ที่หน่วยงานสมัครให้ */
            if ($model->id) {
               $account = Account::model()->findByPk($model->id);
               if (!$account->secure_question_1) {
                  if ($account->doRequestResetPassword()) {
                     $this->redirect(array('forgotComplete', 'id' => $account->id));
                  }
               }
            }

            $this->redirect(array('forgotQuestion', 'id' => $model->id));
         }
      }
      $this->render('forgot', array(
          'model' => $model,
      ));
   }

   public function actionForgotQuestion($id) {
      $model = Account::model()->findByPk($id);

      // Language
      Helper::setLaguage($model->isForeign ? 'en' : 'th');

      $model->scenario = 'forgotQuestion';
      $num = Yii::app()->user->getState('ss_question');
      if (!$num) {
         Yii::app()->user->setState('ss_question', 1);
         $num = 1;
      }
      $model->secure_answer_num = $num;

      $profile = $model->getProfile();
      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->doRequestResetPassword()) {
            $this->redirect(array('forgotComplete', 'id' => $model->id));
         } else {
            if (Yii::app()->user->getState('ss_question') === 1) {
               Yii::app()->user->setState('ss_question', 2);
               //Yii::app()->user->setFlash('success', 'Incorrect answer please try again in second question.');
               $this->redirect(array('forgotQuestion', 'id' => $model->id));
            } else {
               //Yii::app()->user->setFlash('success', 'Incorrect answer.');
               Yii::app()->user->setState('ss_question', 1);
               $model->scenario = 'bypass';
               $model->doRequestResetPassword();
               $this->redirect(array('forgotComplete', 'id' => $model->id));
            }
         }
      }
      $this->render('forgotQuestion', array(
          'model' => $model,
          'profile' => $profile,
          'quiz' => $model->secure_answer_num,
      ));
   }

   public function actionForgotComplete() {
      $this->render('forgotComplete');
   }

   public function actionCreateGeneralThai() {
      Yii::app()->user->setState('current_language', 'th');
      Yii::app()->language = 'th';
      $type = AccountType::model()->findByPk(1);
      $this->render('calendar', array(
          'type' => $type,
      ));
   }

   public function actionCreateGeneralForeigner() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $type = AccountType::model()->findByPk(2);
      $this->render('calendar', array(
          'type' => $type,
      ));
   }

   public function actionCreateDiplomatThai() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $type = AccountType::model()->findByPk(3);
      $this->render('calendar', array(
          'type' => $type,
      ));
   }

   public function actionCreateDiplomatForeigner() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $type = AccountType::model()->findByPk(4);
      $this->render('calendar', array(
          'type' => $type,
      ));
   }

   public function actionResetPassword($id, $key) {
      $model = Account::model()->findByPk($id);

      if (!isset($model)) {
         Yii::app()->user->setFlash('success', 'Access Denied.');
         $this->redirect(array('index'));
      }

      if ($model->tmp_password !== $key) {
         Yii::app()->user->setFlash('success', 'Access Denied.');
         $this->redirect(array('index'));
      }

      $model->scenario = 'changePassword';
      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->save()) {
            if ($model->is_office_user === Account::YES) {
               $model->saveAttributes(array(
                   'is_office_user' => Account::NO,
               ));
            }
            Yii::app()->user->setFlash('success', 'You have reset password successfully.');
            $this->redirect(array('index'));
         }
      }

      $this->render('resetPassword', array(
          'model' => $model,
      ));
   }

   public function actionTakeback($entry_code) {
      $model = Account::model()->findByAttributes(array(
          'entry_code' => $entry_code,
          'is_office_user' => Account::YES,
      ));
      if (!isset($model)) {
         $model = Account::model()->findByAttributes(array(
             'entry_code' => $entry_code,
             'is_staff_user' => Account::YES,
         ));
         if (!isset($model)) {
            Yii::app()->user->setFlash('success', 'Invalid request. Please contact administrator');
            $this->redirect(Yii::app()->homeUrl);
         }
      }
      $model->scenario = 'doTackback';

      $data = Yii::app()->request->getPost('Account');
      if (isset($data)) {
         $model->attributes = $data;
         if ($model->doTakeback()) {
            $this->redirect(array('takebackComplete', 'id' => $model->id));
         }
      }
      $profile = $model->getProfile();
      $this->render('takeback', array(
          'model' => $model,
          'profile' => $profile,
      ));
   }

   public function actionTakebackComplete($id) {
      $model = Account::model()->findByPk($id);
      $this->render('takebackComplete', array(
          'model' => $model,
      ));
   }

}
