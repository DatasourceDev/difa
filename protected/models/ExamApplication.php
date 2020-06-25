<?php

Yii::import('application.models._base.BaseExamApplication');

/**
 * @property boolean $isPaid
 */
class ExamApplication extends BaseExamApplication implements PayableTransaction {

   const STATUS_WAIT = '0';
   const TYPE_SELF = '1';
   const TYPE_OFFICE = '2';
   const PAYMENT_WAITING = '0';
   const PAYMENT_SUCCESS = '1';
   const PAYMENT_EXPIRED = '2';
   const APPLY_SELF = '0';
   const APPLY_OFFICE = '1';
   const APPLY_STAFF = '2';
   const APPLY_STAFF_IMPORT = '3';

   const DELIVERY_TYPE_PICKUP = '0';
   const DELIVERY_TYPE_POST = '1';
   const DELIVERY_TYPE_EMS = '2';

   public $count_application;
   public $date_start;
   public $date_end;
   public $input_accounts;
   public $exam_data;

   public static function model($className = __CLASS__) {
      return parent::model($className);
   }

   public static function getApplyTypeOptions($code = null) {
      $ret = array(
          self::APPLY_SELF => Helper::t('Self', 'สมัครด้วยตนเอง'),
          self::APPLY_OFFICE => Helper::t('By Office', 'สมัครโดยตัวแทนหน่วยงาน'),
          self::APPLY_STAFF => Helper::t('By Staff', 'สมัครโดยเจ้าหน้าที่สถาบันฯ'),
          self::APPLY_STAFF_IMPORT => Helper::t('By Import', 'นำเข้าจากระบบฝึกอบรม'),
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public static function getPaymentStatusOptions($code = null) {
      $ret = array(
          self::PAYMENT_WAITING => Helper::t('Waiting for payment', 'รอการชำระเงิน'),
          self::PAYMENT_SUCCESS => Helper::t('Paid', 'ชำระเงินเรียบร้อย'),
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public static function getHtmlPaymentStatusOptions($code = null) {
      $ret = array(
          self::PAYMENT_WAITING => '<span class="text-bold text-warning">' . Helper::t('Waiting for payment', 'รอการชำระเงิน') . '</span>',
          self::PAYMENT_SUCCESS => '<span class="text-bold text-success">' . Helper::t('Paid', 'ชำระเงินเรียบร้อย') . '</span>',
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public function relations() {
      return array_merge(parent::relations(), array(
          'receipt' => array(self::BELONGS_TO, 'Receipt', 'receipt_id'),
          'examScheduleObjective' => array(self::BELONGS_TO, 'ExamScheduleObjective', array('exam_schedule_objective_id' => 'id', 'exam_schedule_id' => 'exam_schedule_id')),
          'officeUser' => array(self::BELONGS_TO, 'Account', 'office_user_id'),
          'presentPreventSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'is_present_prevent'),
      ));
   }

   public function behaviors() {
      return array_merge(parent::behaviors(), array(
          'CTimestampBehavior' => array(
              'class' => 'zii.behaviors.CTimestampBehavior',
              'createAttribute' => 'created',
              'updateAttribute' => 'modified',
              'setUpdateOnCreate' => true,
          ),
      ));
   }

   public function rules() {
      return array_merge(parent::rules(), array(
          array('exam_schedule_objective_id', 'required'),
          array('is_sms', 'checkSmsRegister'),
          array('search', 'safe', 'on' => 'search'),
          array('payment_code', 'required', 'on' => 'ktbPayment'),
          array('input_accounts', 'required', 'on' => 'applyBulk'),
          array('search', 'checkReportTestRequestByOffice', 'on' => 'reportTestRequestByOffice'),
          array('exam_data', 'safe'),
          array('title_en, firstname_en, lastname_en, department, department_th, office, office_th', 'required', 'on' => 'updateInfo'),
      ));
   }

   public function checkReportTestRequestByOffice($attribute) {
      if (empty($this->search['account_type'])) {
         $this->addError($attribute, 'Can not be blank.');
      }
   }

   public function checkSmsRegister() {
      if ($this->is_sms === self::YES) {
         return true;
         if (!SmsRegister::isRegistered($this->msisdn)) {
            $this->addError('msisdn', 'Please register SMS before proceed.');
            return false;
         }
      }
   }

   public function getDeskNo() {
      return str_pad($this->desk_no, 3, '0', STR_PAD_LEFT);
   }

   public function attributeLabels() {
      return array_merge(parent::attributeLabels(), array(
          'exam_schedule_objective_id' => Helper::t('Objective', 'วัตถุประสงค์การสอบ'),
          'desk_no' => Helper::t('No.', 'เลขที่สอบ'),
          'is_sms' => Yii::t('model', 'BaseExamApplication.attribute.is_sms'),
          'capital_name' => Yii::t('model', 'BaseExamApplication.attribute.capital_name'),
          'capital_description' => Yii::t('model', 'BaseExamApplication.attribute.capital_description'),
          'objective' => Yii::t('model', 'BaseExamApplication.attribute.objective'),
          'msisdn' => Yii::t('model', 'BaseExamApplication.attribute.msisdn'),
          'applicationNumber' => Helper::t('Application No.', 'เลขที่ใบสมัคร'),
          'deskCode' => Helper::t('Examination No.', 'รหัสประจำตัวสอบ'),
          'paymentTax' => Helper::t('Tax ID', 'เลขประจำตัวผู้เสียภาษี'),
          'payment_tax' => Helper::t('Tax ID', 'เลขประจำตัวผู้เสียภาษี'),
          'payment_amount' => Helper::t('Amount', 'จำนวนเงินที่ต้องชำระ'),
          'is_paid' => Helper::t('Payment Status', 'สถานะการชำระเงิน'),
          'apply_date' => Helper::t('Apply Date', 'วันที่สมัคร'),
          'due_date' => Helper::t('Due Date', 'หมดเขตชำระเงิน'),
          'textObjective' => Yii::t('model', 'BaseExamApplication.attribute.objective'),
          'department' => 'Department',
          'department_th' => 'กระทรวง/หน่วยงาน',
          'office' => 'Office',
          'office_th' => 'กรม/สำนัก',
          'request_number' => 'จำนวนใบรับรองที่ต้องการขอใหม่',
          'request_delivery_type' => 'การรับใบรับรอง',
 'temp_order_index' => 'ลำดับจำลอง',
      ));
   }

   public function getSeatCode() {
      return $this->id;
   }

   public function getDeskNumber() {
      return str_pad($this->desk_no, 3, '0', STR_PAD_LEFT);
   }

   public function getQrCode() {
      return base64_encode(CJSON::encode(array(
                  'id' => $this->id,
      )));
   }

   public function getPaymentCode($asText = true) {
      $code = '|' . $this->getPaymentTax() . ' ' . $this->getRef1() . ' ' . $this->getRef2() . ' ' . $this->getPaymentAmount();
      if ($asText) {
         return $code;
      } else {
         return str_replace(' ', "\r", $code);
      }
   }

   public function getConfirmLink() {
      return Yii::app()->createAbsoluteUrl('/administrator/examApplication/confirm', array('code' => $this->getQrCode()));
   }

   public function applyBulk() {
      if ($this->validate()) {
         //$transaction = Yii::app()->db->beginTransaction();
         foreach ($this->input_accounts as $account) {
            $application = new ExamApplication;
            $application->account_id = $account;
            $application->exam_schedule_id = $this->exam_schedule_id;
            $application->exam_schedule_objective_id = $this->exam_schedule_objective_id;
            $application->apply();
         }
         //$transaction->commit();
         $this->scenario = 'applyBulk';
         return true;
      }
   }

   /**
    * สมัครเข้ารับการสอบ
    * @return boolean
    */
   public function apply($validateApplyCondition = false, $sendMail = true) {
      if ($validateApplyCondition) {
         if (!$this->checkApplyCondition()) {
            $this->addError('account_id', $this->applicable_error);
            return false;
         }
      }

      $this->scenario = 'apply';
      $examApplication = $this->examSchedule->getIsAccountJoined($this->account_id);
      if(isset($examApplication)){
         $this->addError('account_id', Helper::t('You could not register to same test. ', 'ผู้สมัครเคยสมัครในรอบสอบนี้แล้ว'));
         return false;
      }
      //else{
      //   /* check self */
      //   $model = ExamApplication::model()->findByAttributes(array(
      //       'account_id' => $this->account_id,
      //       'exam_schedule_id' => $this->exam_schedule_id,
      //       //'id' => '<>' . $this->id,
      //       'is_confirm' => self::YES,
      //   ));
      //   if (isset($model)) {
      //      $this->addError('account_id', Helper::t('You could not register to same test. ', 'ผู้สมัครเคยสมัครในรอบสอบนี้แล้ว'));
      //      return false;
      //   }
      //}
      
      /* check seat */
      if ($this->office_user_id) {
         if (CHtml::value($this, 'officeUser.examScheduleAccount.countApplicationConfirmed') >= CHtml::value($this, 'officeUser.examScheduleAccount.preserved_quota')) {
            $this->addError('exam_schedule_id', 'ไม่สามารถสมัครได้ เนื่องจากมีผู้สมัครครบตามจำนวนโควต้าแล้ว (' . CHtml::value($this, 'officeUser.examScheduleAccount.countApplicationBeforeApply') . '/' . CHtml::value($this, 'officeUser.examScheduleAccount.preserved_quota') . ')');
            return false;
         }
      } else {
         $count = $this->examSchedule->getCountSeatAvailable();
         if ($count <= 0) {
            $this->addError('exam_schedule_id', 'ไม่สามารถสมัครได้ เนื่องจากมีผู้สมัครครบตามจำนวนโควต้าแล้ว');
            return false;
         }
      }

      /* create a new application no. */
      $counter = ApplicationCounter::getLastest(self::TYPE_SELF, date('y'));
      $this->application_year = $counter->app_year;
      $this->application_type = $counter->app_type;
      $this->application_no = $counter->getIncrement();

      $this->fullname_en = CHtml::value($this->account, 'profile.fullnameEn');
      $this->title_en = CHtml::value($this->account, 'profile.textTitleEn');
      $this->firstname_en = CHtml::value($this->account, 'profile.textFirstnameEn');
      $this->lastname_en = CHtml::value($this->account, 'profile.textLastnameEn');

      $this->fullname_th = CHtml::value($this->account, 'profile.fullnameTh');
      $this->title_th = CHtml::value($this->account, 'profile.textTitleTh');
      $this->firstname_th = CHtml::value($this->account, 'profile.textFirstnameTh');
      $this->lastname_th = CHtml::value($this->account, 'profile.textLastnameTh');

      $this->department = CHtml::value($this->account, 'profile.textDepartment');
      $this->office = CHtml::value($this->account, 'profile.textWorkOffice');
      $this->department_th = CHtml::value($this->account, 'profile.textDepartmentTh');
      $this->office_th = CHtml::value($this->account, 'profile.textWorkOfficeTh');
      $this->position = CHtml::value($this->account, 'profile.textWorkPosition');
      $this->level = CHtml::value($this->account, 'profile.textWorkLevel');
      $this->work_year = CHtml::value($this->account, 'profile.work_year');
      $transaction = Yii::app()->db->beginTransaction();
      if ($this->save()) {

         /* Put attendee to best free availiable seat. */
         $this->saveAttributes(array(
             'desk_no' => $this->examSchedule->getAvailableSeat(),
         ));
         $this->doConfirmApply();
         $this->saveAttributes(array(
             'payment_tax' => Configuration::getKey('payment_tax'),
             'payment_suffix' => Configuration::getKey('payment_suffix'),
             'payment_amount' => $this->examSchedule->register_fee,
             'desk_code' => $this->getDeskCode(),
             'status' => self::STATUS_WAIT,
         ));
         $this->saveAttributes(array(
             'payment_code' => $this->getPaymentCode(),
         ));
         if ($this->examSchedule->register_fee <= 0) {
            $this->saveAttributes(array(
                'is_paid' => self::YES,
            ));
         }

         /* Create empty ExamSet data. */
         foreach ($this->examSchedule->examScheduleItems as $item) {
            /* @var $item ExamScheduleItem */
            $examSet = new ExamApplicationExamSet;
            $examSet->exam_application_id = $this->id;
            $examSet->exam_schedule_id = $this->exam_schedule_id;
            $examSet->exam_set_id = $item->exam_set_id;
            $examSet->exam_subject_id = $item->exam_subject_id;
            $examSet->grade_expire = date('Y', strtotime($item->examSchedule->db_date)) + 2 . date('-m-d', strtotime($item->examSchedule->db_date));
            $examSet->save();
         }
         $transaction->commit();

         if ($sendMail) {
            Mailer::sendExamApplyConfirmation(CHtml::value($this, 'account.profile.contact_email'), array(
                'data' => array(
                    'model' => CHtml::value($this, 'account'),
                    'examApplication' => $this,
                ),
            ));
         }
         return true;
      }
      $transaction->rollback();
   }

   public function doConfirmApply() {
      $this->saveAttributes(array(
          'is_confirm' => self::YES,
          'apply_date' => date('Y-m-d'),
          'due_date' => $this->account->getIsForeign() ? date('Y-m-d', strtotime('+1 days', strtotime($this->examSchedule->db_date))) : date('Y-m-d', strtotime('+1 days', time())),
      ));
      return true;
   }

   public function beforeDelete() {
      if (parent::beforeDelete()) {

         if (isset($this->receipt)) {
            $this->receipt->delete();
         }

         foreach ($this->examApplicationExamSets as $item) {
            $item->delete();
         }

         return true;
      }
   }

   public function getHtmlPresent() {
      return Helper::htmlSignSuccess('ลงทะเบียนเรียบร้อย ' . ($this->present_date ? '(' . $this->present_date . ')' : ''));
   }

   public function getIsPrintPaymentSlip() {

      if ($this->getIsPaid()) {
         return true;
      }

      $due_date = $this->due_date . ' ' . Configuration::getKey('payment_due_time', '22:00') . ':00';
      if (date('Y-m-d H:i:s') <= $due_date) {
         return true;
      }
   }

   public function doConfirm() {
      $this->is_present = self::YES;
      $this->present_account_id = Yii::app()->user->id;
      $this->present_date = date('Y-m-d H:i:s');
      if ($this->save()) {
         /* ป้องกันการสมัครสอบที่มีทักษะซ้ำกัน */
         foreach ($this->examSchedule->examScheduleUniqueItems as $item) {
            /* @var $item ExamApplicationExamSet */
            $criteria = new CDbCriteria();

            $criteria->with = array(
                'examApplicationExamSets' => array(
                    'together' => true,
                    'select' => false,
                ),
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('t.account_id', $this->account_id);
            $criteria->compare('t.exam_schedule_id', '<>' . $this->exam_schedule_id);
            $criteria->compare('t.is_applicable', self::YES);
            $criteria->compare('t.is_confirm', self::YES);
            $criteria->compare('t.is_present', self::NO);
            $criteria->compare('examSchedule.db_date', '>=' . date('Y-m-d', strtotime('-' . Configuration::getKey('exam_retry_month', 6) . ' months', strtotime($item->examSchedule->db_date))));
            $criteria->compare('examSchedule.db_date', '<=' . date('Y-m-d', strtotime('+' . Configuration::getKey('exam_retry_month', 6) . ' months', strtotime($item->examSchedule->db_date))));
            $criteria->compare('examApplicationExamSets.exam_subject_id', $item->exam_subject_id);
            $applications = ExamApplication::model()->findAll($criteria);
            foreach ($applications as $application) {
               /* @var $application ExamApplication */
               $application->is_present_prevent = $this->exam_schedule_id;
               $application->save();
            }
         }
         return true;
      }
   }

   public function cancel() {
      $this->delete();
      return true;
      //}
   }

   public function getGradeByExamSet($exam_set_id) {
      return ExamApplicationExamSet::model()->findByAttributes(array(
                  'exam_application_id' => $this->id,
                  'exam_schedule_id' => $this->exam_schedule_id,
                  'exam_set_id' => $exam_set_id,
      ));
   }

   public function getExamSetBySubject($code) {
      $criteria = new CDbCriteria();
      $criteria->with = array(
          'examSubject' => array(
              'together' => true,
          ),
      );
      $criteria->compare('t.exam_application_id', $this->id);
      $criteria->compare('t.exam_schedule_id', $this->exam_schedule_id);
      $criteria->compare('examSubject.code', $code);
      return ExamApplicationExamSet::model()->find($criteria);
   }

   public function getGradeBySubject($code) {
      $criteria = new CDbCriteria();
      $criteria->with = array(
          'examSubject' => array(
              'together' => true,
          ),
      );
      $criteria->compare('exam_application_id', $this->id);
      $criteria->compare('exam_schedule_id', $this->exam_schedule_id);
      $criteria->compare('examSubject.code', $code);
      return ExamApplicationExamSet::model()->find($criteria);
   }

   public function scopeSelfRegister() {
      $criteria = new CDbCriteria();
      $criteria->addCondition('t.office_user_id IS NULL');
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function scopeNonFree() {
      $criteria = new CDbCriteria();
      $criteria->compare('payment_amount', '>' . 0);
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function scopeActive() {
      $criteria = new CDbCriteria();
      $criteria->with = array(
          'account' => array(
              'together' => true,
          ),
      );
      $criteria->compare('account.status', Account::STATUS_ACTIVED);
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function scopeValid() {
      $criteria = new CDbCriteria();
      $criteria->compare('is_applicable', self::YES);
      $criteria->compare('is_confirm', self::YES);
      $criteria->addCondition('apply_type IN (2,3) OR is_paid = 1 OR (is_paid = 0 AND CONCAT(due_date," ' . Configuration::getKey('payment_due_time') . '") >= NOW())');
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function scopeValidWithAnyPayment() {
      $criteria = new CDbCriteria();
      $criteria->compare('is_applicable', self::YES);
      $criteria->compare('is_confirm', self::YES);
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function search() {
      $dataProvider = parent::search();
      if (!empty($this->search['username'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('account.username', $this->search['username'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['firstname'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
             'account.accountProfile' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('accountProfile.firstname', $this->search['firstname'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['lastname'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
             'account.accountProfile' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('accountProfile.lastname', $this->search['lastname'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['position'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
             'account.accountProfile' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('accountProfile.position', $this->search['position'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['level'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
             'account.accountProfile' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('accountProfile.level', $this->search['level'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['payment_date_range'])) {
         list($this->date_start, $this->date_end) = array_pad(explode(' - ', $this->search['payment_date_range']), 2, date('Y-m-d'));
         $criteria = new CDbCriteria();
         $criteria->addBetweenCondition('DATE(t.payment_date)', $this->date_start, $this->date_end);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['exam_date_range'])) {
         list($this->date_start, $this->date_end) = array_pad(explode(' - ', $this->search['exam_date_range']), 2, date('Y-m-d'));
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
         );
         $criteria->addBetweenCondition('DATE(examSchedule.db_date)', $this->date_start, $this->date_end);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['exam_schedule_date_start'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('DATE(examSchedule.db_date)', '>=' . $this->search['exam_schedule_date_start']);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['exam_schedule_date_end'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('DATE(examSchedule.db_date)', '<=' . $this->search['exam_schedule_date_end']);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['exam_type_id'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('examSchedule.exam_type_id', $this->search['exam_type_id']);
         $dataProvider->criteria->mergeWith($criteria);
      }

      /* ค้นหา ทักษะ */
      if (!empty($this->search['exam_subject_id'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
             'examSchedule.examScheduleItems' => array(
                 'select' => false,
                 'together' => true,
             ),
         );
         $criteria->compare('examScheduleItems.exam_subject_id', $this->search['exam_subject_id']);
         $dataProvider->criteria->mergeWith($criteria);
      }

      if (!empty($this->search['is_office_user'])) {
         $criteria = new CDbCriteria();
         switch ($this->search['is_office_user']) {
            case '0':
               $criteria->addCondition('t.office_user_id IS NULL');
               break;
            case '1':
               $criteria->addCondition('t.office_user_id IS NOT NULL');
               break;
         }
         $dataProvider->criteria->mergeWith($criteria);
      }

      /* ค้นหา หน่วยงาน */
      if (!empty($this->search['department'])) {
         $criteria = new CDbCriteria();
         $criteria->compare('t.department_th', $this->search['department'], true);
         $dataProvider->criteria->mergeWith($criteria);
      }

      /* ค้นหา วัตถุประสงค์ */
      if (!empty($this->search['exam_objective'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examScheduleObjective' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('examScheduleObjective.name_th', $this->search['exam_objective'], true, 'OR');
         $criteria->compare('examScheduleObjective.name_en', $this->search['exam_objective'], true, 'OR');
         $dataProvider->criteria->mergeWith($criteria);
      }

      /* ค้นหา ประเภท */
      if (!empty($this->search['account_type'])) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('account.account_type_id', $this->search['account_type']);
         $dataProvider->criteria->mergeWith($criteria);
      }
      return $dataProvider;
   }

   public function getApplicationNumber() {
      return $this->application_year . $this->application_type . str_pad($this->application_no, 5, '0', STR_PAD_LEFT);
   }

   public function getRef1() {
      return str_pad(str_replace('F', '0', CHtml::value($this, 'account.entry_code')), 13, '0', STR_PAD_LEFT) . str_pad(CHtml::value($this, 'examSchedule.examType.id'), 2, '0', 0);
   }

   public function getRef2() {
      return str_pad(CHtml::value($this, 'applicationNumber'), 8, '0', STR_PAD_LEFT) . date('dmy', strtotime(CHtml::value($this, 'due_date')));
   }

   public function getPaymentAmount() {
      return str_pad((int) CHtml::value($this, 'payment_amount') . '00', 10, '0', STR_PAD_LEFT);
   }

   public function getPaymentTax() {
      return str_pad($this->payment_tax, 13, '0', STR_PAD_LEFT) . str_pad($this->payment_suffix, 2, '0', STR_PAD_LEFT);
   }

   public function getDeskCode() {
      return CHtml::value($this, 'account.entry_code') . ' ' . str_pad($this->desk_no, 3, '0', STR_PAD_LEFT) . ' ' . CHtml::value($this, 'examSchedule.exam_code');
   }

   public function getIsPresent() {
      return $this->is_present === self::YES;
   }

   public function getIsPaid() {
      return $this->is_paid === self::PAYMENT_SUCCESS;
   }

   public function getIsGradeReady() {
      return false;
   }

   public function getIsSms() {
      return $this->is_sms === self::YES;
   }

   public function doPaid() {
      //$transaction = Yii::app()->db->beginTransaction();
      $this->is_paid = self::PAYMENT_SUCCESS;
      $this->payment_date = date('Y-m-d H:i:s');
      if ($this->save()) {
         Mailer::sendPayment(CHtml::value($this, 'account.profile.contact_email'), array(
             'data' => array(
                 'model' => CHtml::value($this, 'account'),
             ),
         ));
         $receipt = new Receipt;
         $receipt->receipt_income_code = CHtml::value($this, 'examSchedule.examType.income_type_id');
         $receipt->receipt_year = Helper::getFiscalYear();
         $receipt->receipt_no = Yii::app()->db->createCommand('SELECT COALESCE(MAX(receipt_no),0)+1 FROM receipt WHERE doc_year =:doc_year AND receipt_income_code = :receipt_income_code')->bindValues(array(
                     ':receipt_income_code' => $receipt->receipt_income_code,
                     ':doc_year' => $receipt->receipt_year
                 ))->queryScalar();
         $receipt->doc_year = $receipt->receipt_year;
         $receipt->doc_no = $receipt->receipt_no;
         $receipt->doc_name = str_pad($receipt->receipt_income_code, 3, '0', STR_PAD_LEFT) . '/' . substr($receipt->receipt_year + 543, 2, 2) . '/' . str_pad($receipt->receipt_no, 5, '0', STR_PAD_LEFT);
         $receipt->payment_date = $this->payment_date;
         $receipt->amount = $this->payment_amount;
         $receipt->payer_name = CHtml::value($this, 'account.profile.fullname');
         $receipt->payer_code = CHtml::value($this, 'account.entry_code');
         $receipt->exam_application_id = $this->id;
         $receipt->exam_schedule_id = $this->exam_schedule_id;

         $approver = ReceiptApprover::model()->findByAttributes(array(
             'is_default' => self::YES,
         ));
         if (isset($approver)) {
            $receipt->approve_id = CHtml::value($approver, 'id');
            $receipt->approve_name = CHtml::value($approver, 'name');
            $receipt->approve_position = CHtml::value($approver, 'position');
         }

         if ($receipt->save()) {
            $this->isNewRecord = false;
            $this->receipt_id = $receipt->id;
            $this->save();
         }

         // Income
         $incomeTypeId = CHtml::value($this, 'examSchedule.examType.income_type_id');
         if ($incomeTypeId) {
            $income = new Income;
            $income->income_date = $this->payment_date;
            $income->comment = $this->desk_code;
            $income->amount = $this->payment_amount;
            $income->income_type_id = $incomeTypeId;
            $income->save();
         }

         // Send SMS
         if ($this->isSms) {
            Sms::send(CHtml::value($this, 'account.msisdn'), Helper::t(Configuration::getKey('sms_template_payment_en'), Configuration::getKey('sms_template_payment_th')), array(
                '{{exam_code}}' => CHtml::value($this, 'examSchedule.exam_code'),
            ));
         }
         //$transaction->commit();
         return true;
      }
      //$transaction->rollback();
   }

   public function undoPaid() {
      $this->is_paid = ActiveRecord::NO;
      $this->payment_date = null;
      if ($this->save()) {
         if (isset($this->receipt)) {
            $this->receipt->delete();
         }
         return true;
      }
   }

   public function reportIncomeDaily() {
      $this->reportIncomeSummary();
      $criteria = new CDbCriteria();
      $criteria->group = 'DATE(t.payment_date)';
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public function reportIncomeSummary() {
      $criteria = new CDbCriteria();
      $criteria->select = array(
          'DATE(t.payment_date) as payment_date',
          'COUNT(t.id) as count_application',
          'SUM(t.payment_amount) as payment_amount',
      );
      $criteria->compare('t.is_paid', self::YES);
      $this->dbCriteria->mergeWith($criteria);

      if (isset($this->search['payment_date_range'])) {
         list($this->date_start, $this->date_end) = array_pad(explode(' - ', $this->search['payment_date_range']), 2, date('Y-m-d'));
         $criteria = new CDbCriteria();
         $criteria->addBetweenCondition('DATE(t.payment_date)', $this->date_start, $this->date_end);
         $this->dbCriteria->mergeWith($criteria);
      }
      return $this;
   }

   public function getTextReplyDocCode() {
      return ($this->application_year + 2543) . '/' . (str_pad($this->application_no, 5, '0', STR_PAD_LEFT));
   }

   public function findByRef($ref1, $ref2) {
      if (substr($ref2, 0, 2) === '99') {
         return ExamScheduleAccount::model()->findByRef($ref1, $ref2);
      } else {

         $criteria = new CDbCriteria();
         $criteria->with = array(
             'account' => array(
                 'together' => true,
             ),
             'examSchedule' => array(
                 'together' => true,
             ),
         );

         $idcard = substr($ref1, 0, 13);
         if (substr($idcard, 0, 1) === '0') {
            $idcard = 'F' . substr($ref1, 1, 12);
         }

         $criteria->compare('account.entry_code', $idcard);
         $criteria->compare('examSchedule.exam_type_id', (int) substr($ref1, 13, 2));
         $criteria->compare('application_year', (int) substr($ref2, 0, 2));
         $criteria->compare('application_type', (int) substr($ref2, 2, 1));
         $criteria->compare('application_no', (int) substr($ref2, 3, 5));
         $due_date = DateTime::createFromFormat('dmy', substr($ref2, 8, 6));
         if ($due_date) {
            $criteria->compare('due_date', $due_date->format('Y-m-d'));
         } else {
            $criteria->compare('due_date', date('Y-m-d'));
         }
         return ExamApplication::model()->find($criteria);
      }
   }

   public function parsePaymentCode($code) {
      return array(
          'ref1' => substr($code, 17, 15),
          'ref2' => substr($code, 33, 14),
          'payment_tax' => substr($code, 1, 13),
          'payment_suffix' => substr($code, 14, 2),
          'entry_code' => substr($code, 17, 13),
          'exam_type_id' => (int) substr($code, 29, 3),
          'application_year' => (int) (substr($code, 33, 2) + 2000),
          'application_type' => (int) (substr($code, 35, 1)),
          'application_no' => (int) (substr($code, 36, 5)),
          'due_date' => DateTime::createFromFormat('dmy', substr($code, 41, 6))->format('Y-m-d'),
          'amount' => ((int) (substr($code, 48, 10)) / 100),
      );
   }

   public static function getDefaultGridViewColumns() {
      return array_merge(self::getExamInfoGridViewColumns(), self::getAccountInfoGridViewColumns());
   }

   public static function getAccountInfoGridViewColumns() {
      return array(
          array(
              'header' => 'ชื่อ-นามสกุล / หน่วยงาน',
              'name' => 'member_id',
              'value' => 'CHtml::link(CHtml::value($data,"fullname_th"),array("ajaxView/accountInfo","id"=> $data->account_id), array("class" => "btn-ajax-modal","data-modal-size" => "large")) . "<br/><small>". CHtml::value($data,"department") ."</small>"',
              'type' => 'raw',
          ),
          array(
              'header' => 'ประเภทการสมัคร',
              'name' => 'apply_type',
              'value' => 'CHtml::value($data,"htmlApplyType")',
              'type' => 'raw',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
          array(
              'header' => 'ตำแหน่ง / ระดับ',
              'name' => 'account.accountProfile.position',
              'value' => '"<div class=\"text-primary\">" . CHtml::value($data,"account.accountProfile.position") . "</div><div><small>" . CHtml::value($data,"account.accountProfile.level") . "</small></div>"',
              'type' => 'raw',
          ),
      );
   }

   public static function getExamInfoGridViewColumns() {
      return array(
          array(
              'header' => 'วันที่สอบ',
              'name' => 'exam_schedule_id',
              'value' => 'CHtml::value($data,"examSchedule.db_date")',
              'type' => 'date',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
          array(
              'header' => 'รอบสอบ',
              'name' => 'exam_schedule_id',
              'value' => 'CHtml::link(CHtml::value($data,"examSchedule.exam_code"),array("manageSchedule/view","id" => $data->exam_schedule_id))',
              'type' => 'raw',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
          array(
              'header' => 'ประเภทการสอบ',
              'name' => 'exam_schedule_id',
              'value' => 'CHtml::value($data,"examSchedule.examType.name")',
              'type' => 'text',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
          array(
              'header' => 'ทักษะ',
              'value' => 'CHtml::value($data,"examSchedule.textSkillCode")',
              'type' => 'text',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
          array(
              'header' => 'วัตถุประสงค์',
              'name' => 'exam_objective_id',
              'value' => 'CHtml::value($data,"textObjective")',
              'type' => 'text',
          ),
          array(
              'header' => 'เลขที่นั่งสอบ',
              'name' => 'desk_no',
              'value' => 'CHtml::value($data,"deskNumber")',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
      );
   }

   public static function getPaymentGridViewColumns() {
      return array(
          array(
              'header' => 'ค่าธรรมเนียม',
              'value' => 'CHtml::value($data,"examSchedule.register_fee")',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-right',
              ),
          ),
          array(
              'header' => 'สถานะการชำระเงิน',
              'name' => 'is_paid',
              'value' => '$data->isPaid ? ($data->payment_amount > 0 ? "<span class=\"text-success\">ชำระเงินเรียบร้อย</span>" : "<span class=\"text-success\">ไม่มีค่าใช้จ่าย</span>") : "<span class=\"text-danger\">ยังไม่ได้ชำระเงิน</span>"',
              'type' => 'html',
              'headerHtmlOptions' => array(
                  'class' => 'text-center',
              ),
              'htmlOptions' => array(
                  'class' => 'text-center',
              ),
          ),
      );
   }

   public function getTextPaymentStatus() {
      if (!$this->isPaid && $this->due_date < date('Y-m-d')) {
         return 'เกินกำหนดชำระ';
      }
      if ($this->isPaid && $this->payment_amount <= 0) {
         return 'ไม่มีค่าใช้จ่าย';
      }
      return self::getPaymentStatusOptions($this->is_paid);
   }

   public function getDueDate() {
      return $this->due_date . ' ' . Configuration::getKey('payment_due_time');
   }

   public function getTextObjective() {
      return $this->examScheduleObjective ? Helper::t($this->examScheduleObjective->name_en, $this->examScheduleObjective->name_th) : $this->objective;
   }

   /**
    * ลงทะเบียนเข้าห้องสอบ
    * @return boolean
    */
   public function doSeatIn() {
      if ($this->checkSeatInCondition()) {
         if ($this->doConfirm()) {
            return true;
         }
      }
      return false;
   }

   public function checkSeatInCondition() {
      if (!$this->isPaid) {
         $this->addError('id', Helper::t('Please pay the registration fee first.', 'ผู้สมัครยังไม่ได้ชำระเงิน'));
         return false;
      }

      if (isset($this->presentPreventSchedule)) {
         $this->addError('id', Helper::t('Please pay the registration fee first.', 'ไม่สามารถลงทะเบียนได้ เนื่องจากคุณได้ลงทะเบียนสมัครสอบ รอบ ' . CHtml::value($this, 'presentPreventSchedule.textExamCode') . ' แล้ว'));
         return false;
      }

      $retryMonth = Configuration::getKey('exam_retry_month');
      $items = $this->examSchedule->examScheduleItems;
      foreach ($items as $item) {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examSchedule' => array(
                 'together' => true,
             ),
             'examApplication' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('examApplication.is_applicable', self::YES);
         $criteria->compare('examApplication.is_confirm', self::YES);
         $criteria->compare('examApplication.is_present', self::YES);
         $criteria->compare('examApplication.account_id', $this->account_id);
         $criteria->compare('t.exam_subject_id', $item->exam_subject_id);
         $criteria->compare('examSchedule.id', '<>' . $this->exam_schedule_id);
         $criteria->order = 'examSchedule.exam_code DESC';
         $prev = ExamApplicationExamSet::model()->find($criteria);
         if ($prev) {
            $date = new DateTime($prev->examSchedule->db_date);
            $m = $date->format('n') + ($retryMonth % 12);
            $y = $date->format('Y') + floor($retryMonth / 12);
            if ($m > 12) {
               $y = $y + 1;
            }
            $due = date('Y-m-d', strtotime(str_pad($y, 4, '0', STR_PAD_LEFT) . '-' . str_pad($m, 2, '0', STR_PAD_LEFT) . '-' . $date->format('d')));

            $subCriteria = new CDbCriteria();
            $subCriteria->with = array(
                'examScheduleItems' => array(
                    'select' => false,
                    'together' => true,
                ),
            );
            $subCriteria->compare('t.db_date', '>=' . $due);
            $subCriteria->compare('examScheduleItems.exam_subject_id', $item->exam_subject_id);
            $subCriteria->compare('is_close', self::NO);
            $nextSchedule = ExamSchedule::model()->find($subCriteria);

            if ($item->db_date <= $due) {
               $txt = '';
               if (isset($nextSchedule)) {
                  $txt = Helper::t(' (Next available test is ' . ($nextSchedule->exam_code) . ' on ' . Yii::app()->format->formatDateText($nextSchedule->db_date) . ')', ' (คุณจะสามารถสมัครสอบอีกครั้งในรอบสอบ ' . ($nextSchedule->exam_code) . ' วัน' . Yii::app()->format->formatDateText($nextSchedule->db_date) . ')');
               }
               $this->addError('id', Helper::t('Could not duplicate within ' . $retryMonth . ' months', 'การสอบซ้ำในทักษะเดียวกันต้องมีระยะห่างอย่างน้อย ' . $retryMonth . ' เดือน') . "\n" . $txt);
               break;
            }
         }
      }
      if (!$this->hasErrors()) {
         return true;
      }
   }

   public function getIsExpired() {
      if ($this->getIsPaid()) {
         return false;
      }
      $due_date = $this->due_date . ' ' . Configuration::getKey('payment_due_time', '22:00') . ':00';
      if (date('Y-m-d H:i:s') > $due_date) {
         return true;
      }
      return false;
   }

   public function validatePaymentAmount($amount) {
      return $this->payment_amount == $amount;
   }

   public function checkApplyCondition() {
      $schedule = $this->examSchedule;
      $schedule->checkCondition();
      $schedule->checkDuplicateApply($this->account_id);
      $schedule->checkPrerequisite($this->account_id);
      if ($schedule->hasErrors()) {
         $this->is_applicable = self::NO;
         $this->applicable_error = Helper::errorSummary($schedule);
         $this->save();
         return false;
      } else {
         $this->is_applicable = self::YES;
         $this->save();
         return true;
      }
   }

   public function getIsApplicable() {
      return $this->is_applicable === self::YES;
   }

   public function getHtmlRemark() {
      if (CHtml::value($this, 'account.isForeign')) {
         if (CHtml::value($this, 'account.profile.fullnameEn') !== CHtml::value($this, 'fullname_en')) {
            return CHtml::value($this, 'fullname_en');
         }
      } else {
         if (CHtml::value($this, 'account.profile.fullnameTh') !== CHtml::value($this, 'fullname_th')) {
            return CHtml::value($this, 'fullname_th');
         }
      }
   }

   public function getHtmlRemarkDepartment() {
      if (CHtml::value($this, 'account.profile.textDepartment') !== CHtml::value($this, 'department')) {
         return 'ปัจจุบันสังกัด ' . CHtml::value($this, 'account.profile.textDepartment');
      }
   }

   public function getScheduleOnDateRange() {
      $model = new ExamSchedule;
      if (!empty($this->search['exam_schedule_date_start'])) {
         $criteria = new CDbCriteria();
         $criteria->compare('DATE(t.db_date)', '>=' . $this->search['exam_schedule_date_start']);
         $model->dbCriteria->mergeWith($criteria);
      }

      if (!empty($this->search['exam_schedule_date_end'])) {
         $criteria = new CDbCriteria();
         $criteria->compare('DATE(t.db_date)', '<=' . $this->search['exam_schedule_date_end']);
         $model->dbCriteria->mergeWith($criteria);
      }

      $criteria = new CDbCriteria();
      $criteria->order = 'exam_code DESC';
      $model->dbCriteria->mergeWith($criteria);
      return $model->findAll();
   }

   public function getHtmlApplyType() {
      return self::getApplyTypeOptions($this->apply_type);
   }

   public function getHtmlApplyTypeWithDepartment() {
      return $this->getHtmlApplyType() . '<div><small class="text-muted">' . CHtml::value($this, 'officeUser.profile.textDepartment') . '</small></div>';
   }

   /**
    * ตรวจสอบสถานะว่า สามารถพิมพ์ใบชำระเงินด้วยตนเองได้หรือไม่
    * @return boolean
    */
   public function getIsSelfPrintablePaymentSlip() {
      if ($this->apply_type === self::APPLY_OFFICE) {
         return false;
      }
      if (!$this->getIsPaid()) {
         return true;
      }
      return false;
   }

   /**
    * ตรวจสอบสถานะว่า สามารถพิมพ์บัตรประจำตัวสอบด้วยตนเองได้หรือไม่
    * @return boolean
    */
   public function getIsSelfPrintableExamCard() {
      if ($this->apply_type === self::APPLY_OFFICE) {
         return false;
      }
      if ($this->getIsPaid()) {
         return true;
      }
      return false;
   }

   /**
    * ตรวจสอบสถานะว่า สามารถพิมพ์ใบชำระเงินด้วยตนเองได้หรือไม่
    * @return boolean
    */
   public function getIsSelfCancel() {
      if ($this->apply_type === self::APPLY_OFFICE) {
         return false;
      }
      if (!$this->getIsPaid()) {
         return true;
      }
      return false;
   }

   public function takeExamSet(ExamScheduleItem $item) {
      $examSet = ExamApplicationExamSet::model()->findByAttributes(array(
          'exam_application_id' => $this->id,
          'exam_schedule_id' => $this->exam_schedule_id,
          'exam_subject_id' => $item->exam_subject_id,
      ));
      if (!isset($examSet)) {
         $examSet = new ExamApplicationExamSet;
         $examSet->exam_application_id = $this->id;
         $examSet->exam_schedule_id = $this->exam_schedule_id;
         $examSet->exam_set_id = $item->exam_set_id;
         $examSet->exam_subject_id = $item->exam_subject_id;
         $examSet->save();
      }
   }

   public function getExamSpeakingByPk($id) {
      return ExamApplicationSpeakingData::model()->findByAttributes(array(
                  'exam_application_id' => $this->id,
                  'exam_speaking_id' => $id,
      ));
   }

   public function getCurrentExamSets() {
      return $this->examSchedule->examScheduleUniqueItems;
   }

   public function getIsTakeSameExamType() {
      $criteria = new CDbCriteria();
      $criteria->with = array(
          'examSchedule' => array(
              'together' => true,
          ),
      );
      $criteria->compare('t.account_id', $this->account_id);
      $criteria->compare('examSchedule.exam_type_id', $this->examSchedule->exam_type_id);
      $criteria->compare('t.exam_schedule_id', '<>' . $this->exam_schedule_id);
      $criteria->compare('examSchedule.db_date', '<' . $this->examSchedule->db_date);
      $criteria->compare('t.is_applicable', self::YES);
      $criteria->compare('t.is_confirm', self::YES);
      $criteria->compare('t.is_paid', self::YES);
      return ExamApplication::model()->count($criteria);
   }

   public function getIsTakeSameExamTypeUnstable() {
      $criteria = new CDbCriteria();
      $criteria->with = array(
          'examSchedule' => array(
              'together' => true,
          ),
      );
      $criteria->compare('t.account_id', $this->account_id);
      $criteria->compare('examSchedule.exam_type_id', $this->examSchedule->exam_type_id);
      $criteria->compare('t.exam_schedule_id', '<>' . $this->exam_schedule_id);
      $criteria->compare('examSchedule.db_date', '<' . $this->examSchedule->db_date);
      $criteria->compare('t.is_applicable', self::YES);
      $criteria->compare('t.is_confirm', self::YES);
      $criteria->addCondition('(t.is_paid = 0 AND CONCAT(t.due_date," ' . Configuration::getKey('payment_due_time') . '") >= NOW())');
      return ExamApplication::model()->count($criteria);
   }

   public function getFullnameEn() {
      return $this->title_en . ' ' . $this->firstname_en . ' ' . $this->lastname_en;
   }

   public function getFullnameTh() {
      return $this->title_th . ' ' . $this->firstname_th . ' ' . $this->lastname_th;
   }

   public function doRequestResult() {
      $this->is_request = self::YES;
      return $this->save();
   }

   public function doPrintRequestResult() {
      $this->is_request = self::NO;
      return $this->save();
   }


}
