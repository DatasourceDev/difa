<?php

Yii::import('application.models._base.BaseExamScheduleAccount');

class ExamScheduleAccount extends BaseExamScheduleAccount implements PayableTransaction {

    const PAYMENT_WAITING = '0';
    const PAYMENT_SUCCESS = '1';
    const PAYMENT_EXPIRED = '2';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'max_quota' => 'จำนวนที่สมัครได้สูงสุด',
            'office_tax' => 'เลขประจำตัวผู้เสียภาษี',
            'office_office' => 'กรม/หน่วยงาน',
            'office_department_type_id' => 'ประเภทหน่วยงาน',
            'office_department_id' => 'กระทรวง/หน่วยงาน',
            'office_address' => 'ที่อยู่',
            'office_co_user' => 'ชื่อผู้ประสานงาน',
            'office_phone' => 'หมายเลขโทรศัพท์',
            'office_doc_no' => 'เลขที่หนังสือ',
            'office_doc_date' => 'ลงวันที่',
            'office_objective_id' => 'วัตถุประสงค์การสอบ',
            'office_objective' => 'วัตถุประสงค์การสอบ',
            'preserved_quota' => 'จำนวนที่สมัครได้สูงสุด',
            'is_paid' => 'สถานะการชำระเงิน',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('office_tax, office_office, office_department_id, office_address, office_co_user, office_phone, office_objective_id', 'required', 'on' => 'prepare'),
            array('office_department_type_id', 'safe', 'on' => 'prepare'),
            array('office_office, office_department_name', 'match', 'pattern' => '/^([a-zA-Z0-9_ \.])+$/u', 'message' => 'กรุณากรอกภาษาอังกฤษเท่านั้น', 'on' => array('prepare')),
            array('office_objective', 'checkObjective', 'on' => array('prepare')),
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public static function getHtmlPaymentStatusOptions($code = null) {
        $ret = array(
            self::PAYMENT_WAITING => '<span class="text-bold text-warning">' . Helper::t('Waiting for payment', 'รอการชำระเงิน') . '</span>',
            self::PAYMENT_SUCCESS => '<span class="text-bold text-success">' . Helper::t('Paid', 'ชำระเงินเรียบร้อย') . '</span>',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function checkObjective() {
        if ($this->office_objective_id === '0' && empty($this->office_objective)) {
            $this->addError('office_objective', 'Can not be blank.');
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
            'officeDepartment' => array(self::BELONGS_TO, 'CodeDepartment', 'office_department_id'),
        ));
    }

    public function getHtmlExpireDate() {
        if (isset($this->expire_date)) {
            return '<span class="text-danger text-bold">' . Yii::app()->format->formatDate($this->expire_date) . '</span>';
        }
        return '<span class="text-muted">no expiry date</span>';
    }

    public function doPaid() {
        $criteria = new CDbCriteria();
        $criteria->compare('t.office_user_id', $this->account_id);
        $criteria->compare('t.exam_schedule_id', $this->exam_schedule_id);
        $applications = ExamApplication::model()->findAll($criteria);
        foreach ($applications as $application) {
            $application->doPaid();
        }
        $this->is_paid = self::PAYMENT_SUCCESS;
        $this->payment_date = date('Y-m-d H:i:s');
        if ($this->save()) {
            return true;
        }
    }

    public function undoPaid() {
        $criteria = new CDbCriteria();
        $criteria->compare('t.office_user_id', $this->account_id);
        $criteria->compare('t.exam_schedule_id', $this->exam_schedule_id);
        $applications = ExamApplication::model()->findAll($criteria);
        foreach ($applications as $application) {
            $application->undoPaid();
        }
        $this->is_paid = self::PAYMENT_WAITING;
        $this->payment_date = null;
        if ($this->save()) {
            return true;
        }
    }

    public function doConfirm() {
        $applications = ExamApplication::model()->findAllByAttributes(array(
            'office_user_id' => $this->account_id,
            'is_applicable' => self::YES,
        ));
        foreach ($applications as $application) {
            $application->account->doActivate();
            if (!$application->apply(false)) {
                var_dump($application->errors);
                exit;
            }
        }
        $this->payment_tax = Configuration::getKey('payment_tax');
        $this->payment_suffix = Configuration::getKey('payment_suffix');
        $this->is_confirm = self::YES;
        $this->confirm_date = date('Y-m-d H:i:s');
        $this->due_date = date('Y-m-d', strtotime('+1 days', time()));
        $this->max_quota = count($applications);

        if ($this->getPaymentAmount() <= 0) {
            $this->is_paid = self::YES;
        }

        return $this->save();
    }

    public function undoConfirm() {
        $this->is_confirm = self::NO;
        $this->confirm_date = null;
        $this->due_date = null;
        $this->max_quota = $this->preserved_quota;
        return $this->save();
    }

    public function doPrepare() {
        $this->is_save_office = self::YES;
        if ($this->save()) {
            /* @var $profile AccountProfileOfficeUser */
            $profile = $this->account->getProfile();
            if ($profile) {
                $profile->scenario = 'prepare';
                $profile->work_office_type = $this->office_department_type_id;
                $profile->work_office_id = $this->office_department_id;
                $profile->work_office = $this->office_department_name;
                $profile->work_department = $this->office_office;
                $profile->save(false);
            }
            return true;
        }
    }

    public function getPaymentCode($asText = true) {
        $code = '|' . $this->getPaymentTax() . ' ' . $this->getRef1() . ' ' . $this->getRef2() . ' ' . $this->getPaymentAmountCode();
        if ($asText) {
            return $code;
        } else {
            return str_replace(' ', "\r", $code);
        }
    }

    public function getPaymentAmount() {
        return $this->examSchedule->register_fee * $this->getCountApplication();
    }

    public function getPaymentAmountCode() {
        return str_pad((int) ($this->getPaymentAmount()) . '00', 10, '0', STR_PAD_LEFT);
    }

    public function getRef1() {
        return str_pad(CHtml::value($this, 'office_tax'), 13, '0', STR_PAD_LEFT) . str_pad(CHtml::value($this, 'examSchedule.examType.id'), 2, '0', 0);
    }

    public function getRef2() {
        return '99' . str_pad(CHtml::value($this, 'applicationNumber'), 6, '0', STR_PAD_LEFT) . date('dmy', strtotime(CHtml::value($this, 'due_date')));
    }

    public function getPaymentTax() {
        return str_pad($this->payment_tax, 13, '0', STR_PAD_LEFT) . str_pad($this->payment_suffix, 2, '0', STR_PAD_LEFT);
    }

    public function getDeskCode() {
        return CHtml::value($this, 'office_tax') . ' ' . str_pad('0', 3, '0', STR_PAD_LEFT) . ' ' . CHtml::value($this, 'examSchedule.exam_code');
    }

    public function getApplicationNumber() {
        return $this->account_id;
    }

    public function getCountApplication() {
        return ExamApplication::model()->countByAttributes(array(
                    'exam_schedule_id' => $this->exam_schedule_id,
                    'office_user_id' => $this->account_id,
                    'is_applicable' => self::YES,
        ));
    }

    public function getCountApplicationConfirmed() {
        return ExamApplication::model()->countByAttributes(array(
                    'exam_schedule_id' => $this->exam_schedule_id,
                    'office_user_id' => $this->account_id,
                    'is_applicable' => self::YES,
                    'is_confirm' => self::YES,
        ));
    }

    public function getCountApplicationBeforeApply() {
        return ExamApplication::model()->countByAttributes(array(
                    'exam_schedule_id' => $this->exam_schedule_id,
                    'office_user_id' => $this->account_id,
                    'is_applicable' => self::YES,
                    'is_confirm' => self::NO,
        ));
    }

    public function getIsConfirm() {
        return $this->is_confirm === self::YES;
    }

    public function getIsQuotaExceeded() {
        return $this->countApplication >= $this->max_quota;
    }

    public function getIsPaid() {
        return $this->is_paid === self::YES;
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

    public function getHtmlPaymentStatus() {
        return self::getHtmlPaymentStatusOptions($this->is_paid);
    }

    public function validatePaymentAmount($amount) {
        return $this->getPaymentAmount() == $amount;
    }

    public function findByRef($ref1, $ref2) {
        if (substr($ref2, 0, 2) !== '99') {
            return ExamApplication::model()->findByRef($ref1, $ref2);
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
            $criteria->compare('t.office_tax', $idcard);
            $criteria->compare('examSchedule.exam_type_id', (int) substr($ref1, 13, 2));
            $criteria->compare('t.account_id', (int) substr($ref2, 2, 6));
            $due_date = DateTime::createFromFormat('dmy', substr($ref2, 8, 6));
            $criteria->compare('due_date', $due_date->format('Y-m-d'));
            return ExamScheduleAccount::model()->find($criteria);
        }
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

        /* ค้นหา หน่วยงาน */
        if (!empty($this->search['department'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'account' => array(
                    'together' => true,
                ),
                'account.accountProfile' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('accountProfile.department', $this->search['department'], true);
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

        return $dataProvider;
    }

    public function getTextObjective() {
        $model = ExamScheduleObjective::model()->findByAttributes(array(
            'exam_schedule_id' => $this->exam_schedule_id,
            'id' => $this->office_objective_id,
        ));
        return CHtml::value($model, Helper::t('name_en', 'name_th'), $this->office_objective);
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

}
