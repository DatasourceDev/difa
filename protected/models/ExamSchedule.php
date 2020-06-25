<?php

Yii::import('application.models._base.BaseExamSchedule');

/**
 * @property ExamScheduleItem $firstExamScheduleItem
 */
class ExamSchedule extends BaseExamSchedule {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getAccountTypes($id) {
        $ret = array();
        $model = ExamSchedule::model()->findByPk($id);
        if (isset($model)) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'account' => array(
                    'together' => true,
                ),
            );
            $criteria->group = 'account.account_type_id';
            $criteria->compare('exam_schedule_id', $model->id);
            $applications = ExamApplication::model()->scopeValid()->findAll($criteria);

            $xCriteria = new CDbCriteria();
            $xCriteria->addInCondition('id', CHtml::listData($applications, 'account.account_type_id', 'account.account_type_id'));
            $ret = AccountType::model()->findAll($xCriteria);
        }
        return $ret;
    }

    public static function getIsPrivateOptions($code = null) {
        $ret = array(
            self::NO => 'ทั่วไป',
            self::YES => 'เฉพาะกิจ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getIsCloseOptions($code = null) {
        $ret = array(
            self::NO => 'เปิด',
            self::YES => 'ปิดการสมัคร',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_code' => Yii::t('model', 'BaseExamSchedule.attribute.exam_code'),
            'exam_type_id' => Yii::t('model', 'BaseExamSchedule.attribute.exam_type_id'),
            'code_place_id' => Yii::t('model', 'BaseExamSchedule.attribute.place_name'),
            'place_name' => Yii::t('model', 'BaseExamSchedule.attribute.place_name'),
            'place_remark' => Yii::t('model', 'BaseExamSchedule.attribute.place_remark'),
            'max_quota' => Yii::t('model', 'BaseExamSchedule.attribute.max_quota'),
            'remark' => Helper::t('Information', 'ข้อมูลเพิ่มเติม'),
            'is_private' => Yii::t('model', 'BaseExamSchedule.attribute.is_private'),
            'register_fee' => Yii::t('model', 'BaseExamSchedule.attribute.register_fee'),
            'db_date' => Yii::t('model', 'BaseExamSchedule.attribute.db_date'),
            'is_close' => 'สถานะการสมัคร',
            'close_description' => 'ข้อความแจ้งเตือนกรณที่ปิด',
            'calendar_color' => 'สีที่แสดงในปฏิทิน',
            'exception_register_start_date' => 'วันที่เริ่มรับสมัคร',
            'exception_register_end_date' => 'วันที่ปิดรับสมัคร',

        ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->place_name = CHtml::value($this, 'codePlace', 'name');
            return true;
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ExamScheduleItem::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            ExamScheduleObjective::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            ExamScheduleAccount::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            ExamApplicationExamSetAudit::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            ExamApplicationExamSet::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            ExamApplication::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->id,
            ));
            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'codePlace' => array(self::BELONGS_TO, 'CodePlace', 'code_place_id'),
            'examApplications' => array(self::HAS_MANY, 'ExamApplication', 'exam_schedule_id', 'order' => 'examApplications.desk_no'),
            'examScheduleItems' => array(self::HAS_MANY, 'ExamScheduleItem', 'exam_schedule_id', 'order' => 'examScheduleItems.order_no'),
            'examScheduleDepartments' => array(self::HAS_MANY, 'ExamScheduleDepartment', 'exam_schedule_id'),
            'examScheduleUniqueItems' => array(self::HAS_MANY, 'ExamScheduleItem', 'exam_schedule_id', 'order' => 'examScheduleUniqueItems.order_no', 'group' => 'exam_subject_id'),
            'firstExamScheduleItem' => array(self::HAS_ONE, 'ExamScheduleItem', 'exam_schedule_id', 'order' => 'firstExamScheduleItem.order_no'),
            'countAttendee' => array(self::STAT, 'ExamApplication', 'exam_schedule_id'),
            'countAttendeePaid' => array(self::STAT, 'ExamApplication', 'exam_schedule_id', 'condition' => 'is_confirm = 1 AND is_paid = 1 AND is_applicable = 1'),
            'countAttendeeValidButNoPaid' => array(self::STAT, 'ExamApplication', 'exam_schedule_id', 'condition' => '(is_confirm = 1 AND is_paid = 0 AND is_applicable = 1) AND (CONCAT(due_date, " ' . Configuration::getKey('payment_due_time') . '") >= NOW() OR apply_type IN (2,3))'),
            'countAttendeeBySelf' => array(self::STAT, 'ExamApplication', 'exam_schedule_id', 'condition' => 'office_user_id IS NULL'),
            'countAttendeeByOffice' => array(self::STAT, 'ExamApplication', 'exam_schedule_id', 'condition' => 'apply_type = 1 AND is_confirm = 1'),
            'countExamScheduleItem' => array(self::STAT, 'ExamScheduleItem', 'exam_schedule_id'),
            'countExamScheduleAccount' => array(self::STAT, 'ExamScheduleAccount', 'exam_schedule_id'),
        ));
    }

    public function getValidExamApplications() {
       return ExamApplication::model()->sortBy('t.desk_no')->scopeValid()->findAllByAttributes(array(
                    'exam_schedule_id' => $this->id,
        ));
    }

    public function getCountValidAttendee() {
       return ExamApplication::model()->scopeValid()->countByAttributes(array(
                    'exam_schedule_id' => $this->id,
        ));
    }

    public function getCountValidAttendeeNotPresent() {
        return ExamApplication::model()->scopeValid()->countByAttributes(array(
                    'exam_schedule_id' => $this->id,
                    'is_present' => self::NO,
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('code_place_id, place_remark, max_quota, is_private, register_fee, is_close', 'required'),
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public function create() {
        if ($this->validate()) {
            $this->doGenerateExamCode();
            if ($this->save(false)) {
                $this->restoreObjective();
                return true;
            }
        }
    }

    public function getTextExamName() {
        return $this->exam_code;
    }

    public function getTextExamCode() {
        return $this->exam_code . ' (' . CHtml::value($this, 'examType.name') . ' : ' . CHtml::value($this, 'textSkillCode') . ')';
    }

    public function doGenerateExamCode() {
        $criteria = new CDbCriteria();
        $criteria->select = 'COALESCE(MAX(exam_num),0) + 1 as exam_num';
        $criteria->compare('db_date', $this->db_date);
        $model = ExamSchedule::model()->find($criteria);
        if (isset($model)) {
            $this->exam_num = $model->exam_num;
        } else {
            $this->exam_num = 1;
        }
        $this->exam_code = date('ymd', strtotime($this->db_date)) . '-' . $this->examType->id . str_pad($this->exam_num, 2, '0', STR_PAD_LEFT);
    }

    /**
     * คืนค่าข้อมูลวัตถุประสงค์ในการสอบ ให้เป็นค่าเริ่มต้น
     */
    public function restoreObjective() {

        ExamScheduleObjective::model()->deleteAllByAttributes(array(
            'exam_schedule_id' => $this->id,
        ));

        $criteria = new CDbCriteria();
        if ($this->is_private === self::NO) {
            $criteria->compare('is_private', self::NO);
        }
        $criteria->addCondition('IF(period_start IS NULL,1,period_start <= :db_date)');
        $criteria->addCondition('IF(period_end IS NULL,1,period_end >= :db_date)');
        $criteria->params[':db_date'] = $this->db_date;
        $objectives = CodeObjective::model()->findAll($criteria);
        foreach ($objectives as $count => $objective) {
            $model = new ExamScheduleObjective;
            $model->exam_schedule_id = $this->id;
            $model->id = ($count + 1);
            $model->name_th = $objective->name_th;
            $model->name_en = $objective->name_en;
            $model->description = $objective->description;
            $model->is_private = $objective->is_private;
            $model->period_start = $objective->period_start;
            $model->period_end = $objective->period_end;
            $model->save();
        }
    }

    public function loadDefaultFee() {
        if (empty($this->register_fee)) {
            if ($this->exam_type_id) {
                $type = ExamType::model()->findByPk($this->exam_type_id);
                if (isset($type)) {
                    $this->register_fee = $type->default_register_fee;
                }
            }
        }
    }

    public function loadDefaultColor() {
        /* @var $type ExamType */
        if ($this->exam_type_id) {
            $type = ExamType::model()->findByPk($this->exam_type_id);
            if (isset($type)) {
                $this->calendar_color = $type->badge_color;
            }
        }
    }

    public function getMonth() {
        return date('n', strtotime($this->db_date));
    }

    public function getYear() {
        return date('Y', strtotime($this->db_date));
    }

    public function getIsExamSetReady() {
        if ($this->countExamScheduleItem) {
            return true;
        }
    }

    public function getQuotaExceed() {
        return $this->getCountSeatAvailable() <= 0;
    }

    public function getCountSeatAvailable() {
        return $this->max_quota - $this->getCountCurrentSeatPreserved();
    }

    public function getCountSeatPreserved() {
        return $this->countAttendee + $this->getCountQuotaPreserved();
    }

    public function getCountCurrentSeatPreserved() {
        return $this->countAttendeePaid + $this->countAttendeeValidButNoPaid + ($this->db_date < date('Y-m-d') ? 0 : $this->getCountQuotaPreserved() - $this->countAttendeeByOffice);
    }

    public function getCountQuotaPreserved() {
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'SUM(max_quota) as max_quota',
        );
        $criteria->compare('exam_schedule_id', $this->id);
        $model = ExamScheduleAccount::model()->find($criteria);
        return CHtml::value($model, 'max_quota', 0);
    }

    public function getTextIsPrivate() {
        return self::getIsPrivateOptions($this->is_private);
    }

    /**
     * คำสั่งสำหรับปรับปรุงวันสอบ ให้ตรงกับชุดข้อสอบ
     */
    public function updateExamDate() {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_schedule_id', $this->id);
        $criteria->order = 'db_date';
        $model = ExamScheduleItem::model()->find($criteria);
        if (isset($model) && $model->db_date <> $this->db_date) {
            /* เลื่อนวันสอบ = ออกรหัสใหม่ */
            $this->db_date = $model->db_date;
            $this->doGenerateExamCode();
            return $this->save();
        }
    }

    /**
     * ค้นคืนรอบสอบรอบถัดไปจากวันที่
     * @param string $date Target date. default is today
     */
    public function next($date = null) {
        $date = $date ? $date : date('Y-m-d');
        $criteria = new CDbCriteria();
        $criteria->compare('db_date', '>=' . $date);
        $criteria->limit = 1;
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getIsFree() {
        return $this->register_fee > 0 ? false : true;
    }

    public function getIsApplicable() {

        if (Yii::app()->user->isGuest) {
            $this->addError('id', Helper::t('Please login first.', 'กรุณาเข้าสู่ระบบก่อนทำการสมัคร'));
        }
        if ($this->hasErrors()) {
            return false;
        }

        $this->checkCondition();
        if ($this->hasErrors()) {
            return false;
        }

        /* ตัวแทนหน่วยงาน */
        if (Yii::app()->user->getIsOfficeUser()) {
            $this->addError('id', Helper::t('Office account can not submit applications.', 'ตัวแทนหน่วยงานไม่สามารถสมัครสอบเองได้'));
        }
        if ($this->hasErrors()) {
            return false;
        }

        if (!CHtml::value(Yii::app()->user, 'account.isEnable', true)) {
            $this->addError('id', Helper::t('This account has been disabled.', 'บัญชีนี้ถูกระงับ ไม่สามารถใช้เพื่อสมัครสอบได้'));
            return false;
        }

        $this->checkDuplicateApply();
        if ($this->hasErrors()) {
            return false;
        }

        $this->checkPrerequisite();
        if ($this->hasErrors()) {
            return false;
        }

        return true;
    }

    public function checkDuplicateApply($id = null) {

        $account_id = isset($id) ? $id : Yii::app()->user->id;

        foreach ($this->examScheduleItems as $item) {
            /* เงื่อนไข ไม่สามารถสมัครทักษะซ้ำได้ภายใน 6 เดือน */
            $retryMonth = Configuration::getKey('exam_retry_month');
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
                'examApplication' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('examApplication.is_present', self::YES);
            $criteria->compare('examApplication.account_id', $account_id);
            $criteria->compare('t.exam_subject_id', $item->exam_subject_id);
            $criteria->compare('DATE(examSchedule.db_date)', '<=' . $item->examSchedule->db_date);
            $criteria->compare('t.exam_schedule_id', '<>' . $this->id);
            $criteria->order = 'examSchedule.exam_code DESC';
            $prev = ExamApplicationExamSet::model()->find($criteria);
            if ($prev) {
                $date = new DateTime($prev->examSchedule->db_date);
                $m = $date->format('n') + ($retryMonth % 12);
                $y = $date->format('Y') + floor($retryMonth / 12);
                if ($m > 12) {
                    $m = $m - 12;
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
                $subCriteria->order = 't.db_date';
                $nextSchedule = ExamSchedule::model()->find($subCriteria);

                if ($item->db_date <= $due) {
                    $txt = '';
                    if (isset($nextSchedule)) {
                        $txt = Helper::t(' (Next available test is ' . ($nextSchedule->exam_code) . ' on ' . Yii::app()->format->formatDateText($nextSchedule->db_date) . ')', ' (คุณจะสามารถสมัครสอบอีกครั้งในรอบสอบ ' . ($nextSchedule->exam_code) . ' วัน' . Yii::app()->format->formatDateText($nextSchedule->db_date) . ')');
                    }
                    $this->addError('id', Helper::t('Could not duplicate within ' . $retryMonth . ' months', 'การสอบซ้ำในทักษะเดียวกันต้องมีระยะห่างอย่างน้อย ' . $retryMonth . ' เดือน') . $txt);
                    break;
                }
            }
        }
    }

    public function checkPrerequisite($id = null) {

        $account_id = isset($id) ? $id : Yii::app()->user->id;

        foreach ($this->examScheduleItems as $item) {
            /* @var $item ExamScheduleItem */
            /* ผ่านบูรพวิชา */
            $prerequisites = ExamPrerequisite::model()->scopeDefaultOrder()->findAllByAttributes(array(
                'exam_type_id' => $this->exam_type_id,
                'exam_subject_id' => $item->exam_subject_id,
            ));
            if (isset($prerequisites)) {
                foreach ($prerequisites as $prerequisite) {
                    /* @var $prerequisite ExamPrerequisite */
                    $criteria = new CDbCriteria();
                    $criteria->with = array(
                        'examApplication' => array(
                            'together' => true,
                        ),
                        'examSchedule' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->compare('examSchedule.exam_type_id', $prerequisite->exam_type_require_id);
                    $criteria->compare('t.exam_subject_id', $prerequisite->exam_subject_require_id);
                    $criteria->compare('examApplication.account_id', $account_id);
                    $criteria->addCondition('DATE(t.grade_expire) >= CURDATE()');
                    $criteria->addCondition('grade IS NOT NULL');
                    $criteria->addCondition('LOWER(grade) NOT LIKE "%below%"');
                    $criteria->compare('t.grade', '>=' . $prerequisite->minimum_grade);
                    $examSet = ExamApplicationExamSet::model()->find($criteria);
                    if (!isset($examSet)) {
                        $tmpText = '';
                        foreach ($prerequisites as $count => $tmpModel) {
                            if ($tmpText !== '') {
                                if ($count + 1 === count($prerequisites)) {
                                    $tmpText .= Helper::t(' and ', 'และ') . Helper::t(CHtml::value($tmpModel, 'examSubjectRequire.name_en'), CHtml::value($tmpModel, 'examSubjectRequire.name'));
                                } else {
                                    $tmpText .= ', ' . Helper::t(CHtml::value($tmpModel, 'examSubjectRequire.name_en'), CHtml::value($tmpModel, 'examSubjectRequire.name'));
                                }
                            } else {
                                $tmpText = Helper::t(CHtml::value($tmpModel, 'examSubjectRequire.name_en'), CHtml::value($tmpModel, 'examSubjectRequire.name'));
                            }
                        }

                        $this->addError('id', Helper::t('You must pass ' . $tmpText . ' with <strong>' . CHtml::value($prerequisite, 'minimum_grade') . '</strong> grade or greater.', 'ต้องสอบผ่านทักษะ' . $tmpText . ' ได้ระดับ ' . CHtml::value($prerequisite, 'minimum_grade') . ' ขึ้นไปเท่านั้น'));
                        break;
                    }
                }
            }
        }
    }

    public function getIsAccountJoined($account_id = null) {
        $account_id = isset($account_id) ? $account_id : Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->compare('account_id', $account_id);
        $criteria->compare('exam_schedule_id', $this->id);
        $criteria->compare('is_applicable', self::YES);
        $criteria->addCondition('is_paid = 1 OR (is_paid = 0 AND CONCAT(due_date," ' . Configuration::getKey('payment_due_time') . '") >= NOW())');
        $examApplication  =ExamApplication::model()->find($criteria);
        return $examApplication;
    }

    public function getExamCodeText() {
        $ret = array();
        foreach ($this->examScheduleUniqueItems as $item) {
            $ret[] = $item->examSubject->code;
        }
        return implode('-', $ret) . ' ' . $this->id . '/' . date('Y', strtotime($this->db_date));
    }

    public function getAvailableSeat() {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_schedule_id', $this->id);
        $criteria->compare('is_applicable', self::YES);
        $criteria->compare('is_confirm', self::YES);
        $criteria->addCondition('desk_no IS NOT NULL');
        $criteria->addCondition('is_paid = 1 OR (is_paid = 0 AND CONCAT(due_date," ' . Configuration::getKey('payment_due_time') . '") >= NOW())');
        $criteria->order = 'desk_no';
        $applications = ExamApplication::model()->findAll($criteria);
        $seats = array();
        foreach ($applications as $app) {
            $seats[$app->desk_no] = $app;
        }
        for ($i = 1; $i <= $this->max_quota; $i++) {
            if (!isset($seats[$i])) {
                return $i;
            }
        }
        return false;
    }

    public function textExamCode() {
        return implode(', ', CHtml::listData($this->examScheduleUniqueItems, 'exam_subject_id', 'examSubject.textName'));
    }

    public function getTextSkillWithPrefix() {
        $text = '';
        $items = $this->examScheduleUniqueItems;
        foreach ($items as $count => $item) {
            $text .= 'ทักษะ' . CHtml::value($item, 'examSubject.textName');

            if ($count == count($items) - 2) {
                $text .= ' และ';
            } elseif ($count < count($items) - 2) {
                $text .= ', ';
            }
        }
        return $text;
    }

    public function getTextSkillCode() {
        return implode(' - ', array_unique(CHtml::listData($this->examScheduleUniqueItems, 'exam_subject_id', 'examSubject.code')));
    }

    public function getTextSkillWord() {
        return implode(' & ', array_unique(CHtml::listData($this->examScheduleUniqueItems, 'exam_subject_id', 'examSubject.name_en')));
    }

    public function getTextSkillTime() {
        $ret = array();
        foreach ($this->examScheduleUniqueItems as $item) {
            $ret[] = CHtml::value($item, 'examSubject.name') . ' (' . CHtml::value($item, 'timeRange') . ')';
        }
        return implode(' , ', $ret);
    }

    public function getTextTime() {
        foreach ($this->examScheduleUniqueItems as $item) {
            return CHtml::value($item, 'timeRange');
        }
    }

    public function getHtmlTime() {
        foreach ($this->examScheduleUniqueItems as $item) {
            return CHtml::value($item, 'htmlTimeRange');
        }
    }

    /**
     *
     * @return string all skills with test date in text formatted.
     */
    public function getTextSkillWithDate() {
        $timeArrays = array();
        foreach ($this->examScheduleUniqueItems as $item) {
            $timeArrays[$item->place_remark . '-' . $item->db_date . $item->time_start . $item->time_end][] = $item;
        }

        $ret = array();
        foreach ($timeArrays as $timeArray) {
            $ret[] = $this->_parseSkillSerial($timeArray, true, true);
        }
        return implode("\n", $ret);
    }

    private function _parseSkillSerial($timeArray = array(), $prefix = false, $room = false) {
        $ret = array();
        for ($i = 0; $i < count($timeArray); $i++) {
            if (count($timeArray) > 1 && $i == count($timeArray) - 1) {
                $ret[] = 'และ';
            }
            $ret[] = ($prefix ? 'ทักษะ' : '') . CHtml::value($timeArray[$i], 'examSet.examSubject.name');
        }
        $ret[] = ' : วัน' . Yii::app()->format->formatDateText(CHtml::value($timeArray[0], 'db_date')) . ' เวลา ' . Yii::app()->format->formatTimeRange(CHtml::value($timeArray[0], 'time_start'), CHtml::value($timeArray[0], 'time_end')) . ($room ? ' (ห้อง: ' . CHtml::value($timeArray[0], 'place_remark') . ')' : '');
        return implode(' ', $ret);
    }

    public function getSkillDetailArray() {
        $timeArrays = array();
        foreach ($this->examScheduleUniqueItems as $item) {
            $timeArrays[$item->db_date . $item->time_start . $item->time_end][] = $item;
        }

        $ret = array();
        foreach ($timeArrays as $timeArray) {
            $ret[] = array(
                'label' => Helper::t('Skill' . (count($timeArray) > 1 ? 's' : ''), 'ทักษะ'),
                'value' => Yii::app()->language === 'th' ? implode(', ', CHtml::listData($timeArray, 'examSet.examSubject.name', 'examSet.examSubject.name')) : implode(', ', CHtml::listData($timeArray, 'examSet.examSubject.name_en', 'examSet.examSubject.name_en')),
            );
            $ret[] = array(
                'label' => Helper::t('Test Date', 'วันที่สอบ'),
                'value' => '<span class="text-primary">' . Yii::app()->format->formatDateText(CHtml::value($timeArray[0], 'db_date')) . '</span>',
                'type' => 'html',
            );
            $ret[] = array(
                'label' => Helper::t('Time', 'เวลา'),
                'value' => '<span class="text-primary">' . CHtml::value($timeArray[0], 'timeRange') . '</span>',
                'type' => 'html',
            );
            $ret[] = array(
                'label' => Helper::t('Venue', 'สถานที่สอบ'),
                'value' => CHtml::value($timeArray[0], 'place_name'),
            );
            $ret[] = array(
                'label' => Helper::t('Map', 'แผนที่'),
                'value' => CHtml::link(Helper::t('[Click here for map]', '[คลิกเพื่อแสดงแผนที่]'), Yii::app()->createAbsoluteUrl('examScheduleItem/modalViewMap', array('pk' => $timeArray[0]->primaryKey, 'type' => Yii::app()->language)), array('class' => 'btn-ajax-modal')),
                'type' => 'raw',
            );
        }
        return $ret;
    }

    public function hasSkill($code) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSubject' => array(
                'together' => true,
            ),
        );
        $criteria->compare('t.exam_schedule_id', $this->id);
        $criteria->compare('examSubject.code', $code);
        return ExamScheduleItem::model()->count($criteria) ? true : false;
    }

    public function getExamSetOfSubject($code) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSubject' => array(
                'together' => true,
            ),
        );
        $criteria->compare('t.exam_schedule_id', $this->id);
        $criteria->compare('examSubject.code', $code);
        return ExamScheduleItem::model()->find($criteria);
    }

    public function scopeDateRange($start, $end) {
        if ($start && $end) {
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('DATE(t.db_date)', $start, $end);
            $this->dbCriteria->mergeWith($criteria);
        }
        return $this;
    }

    public function scopeExamType($exam_type_id) {
        if ($exam_type_id) {
            $criteria = new CDbCriteria();
            $criteria->compare('t.exam_type_id', $exam_type_id);
            $this->dbCriteria->mergeWith($criteria);
        }
        return $this;
    }

    public function scopeExamSubject($exam_subject_id) {
        if ($exam_subject_id) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examScheduleItems' => array(
                    'select' => false ,
                    'together' => true,
                ),
            );
            $criteria->compare('examScheduleItems.exam_subject_id', $exam_subject_id);
            $this->dbCriteria->mergeWith($criteria);
        }
        return $this;
    }



    public function findAllExamSetBySubject($code) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'exam' => array(
                'together' => true,
            ),
        );
        $criteria->compare('examSubject.code', $code);
        $criteria->compare('t.exam_type_id', $this->exam_type_id);
        return $this->findAll($criteria);
    }

    public function addApplication(Account $account, $is_present = '1') {
        $application = new ExamApplication;
        $application->exam_schedule_id = $this->id;
        $application->account_id = $account->id;
        $application->exam_schedule_objective_id = 1;
        $application->is_applicable = self::YES;
        $application->is_confirm = self::YES;
        $application->is_paid = self::YES;
        $application->is_present = $is_present;
        if (!$application->apply(false, false)) {
            throw new CException(CHtml::errorSummary($application));
        }
    }

    public function checkCondition() {
        if ($this->is_close === self::YES) {
            $this->addError('id', $this->close_description);
            return;
        }

        if (!$this->getIsRegistrableDate()) {
            $this->addError('id', str_replace(array(
                '{{dateRange}}'
                            ), array(
                Helper::prettyDateRange($this->getRegisterDateStart(), $this->getRegisterDateEnd()),
                            ), Helper::t('You could register between {{dateRange}}.', (date('Y-m-d') < $this->db_date ? '' : 'หมดเขตการสมัครสอบ') . ' สามารถสมัครสอบได้ตั้งแต่วันที่ {{dateRange}}')));
            return;
        }
    }

    public function getRegisterDateEnd() {
        if (isset($this->exception_register_end_date)) {
            return $this->exception_register_end_date;
        }
        return $this->getRegisterDateEndOriginal();
    }

    public function getRegisterDateEndOriginal() {
        return date('Y-m-d', strtotime('-' . (Configuration::getKey('register_before_day', '0') + 1) . ' days', strtotime($this->db_date)));
    }

    public function getRegisterDateStart() {
        if (isset($this->exception_register_start_date)) {
            return $this->exception_register_start_date;
        }
        return $this->getRegisterDateStartOriginal();
    }

    public function getRegisterDateStartOriginal() {
        return date('Y-m-d', strtotime('-' . Configuration::getKey('register_presubmit_day', '0') . ' days', strtotime($this->db_date)));
    }

    public function getIsRegistrableDate($today = null) {
        $today = $today ? $today : date('Y-m-d');
        if ($today >= $this->getRegisterDateStart() && $today <= $this->getRegisterDateEnd()) {
            return true;
        }
        return false;
    }

    public function getIsOverDate() {
        if ($this->db_date > date('Y-m-d', strtotime('+' . Configuration::getKey('register_presubmit_day', '0') . ' days'))) {
            return true;
        }
        return false;
    }

    public function getIsExpired($now = null) {
        if (isset($now)) {
            $time = strtotime($now);
        } else {
            $time = time();
        }
        if ($this->getRegisterDateEnd() < date('Y-m-d', $time)) {
            return true;
        }
        return false;
    }

    public function getIsClose() {
        /* รอบที่ปิด */
        if ($this->is_close === self::YES) {
            return true;
        }

        return false;
    }

    public function getBadgeColor() {
        if ($this->isClose) {
            return '#B7B7B7';
        }

        if ($this->db_date < date('Y-m-d')) {
            return '#B7B7B7';
        }

        return CHtml::value($this, 'examType.badge_color', '#00FF00');
    }

    /**
     * Get event CSS class
     * @return string CSS Class of the event.
     */
    public function getEventClass() {
        if ($this->isClose) {
            return 'event-expired';
        }
        return '';
    }

    public function inApplicableCondition() {
        $criteria = new CDbCriteria();
        $criteria->compare('is_close', self::NO);
        $criteria->addCondition('CURDATE() <=  DATE_SUB(t.db_date, INTERVAL :register_end_day DAY)');
        $criteria->addCondition('CURDATE() >=  DATE_SUB(t.db_date, INTERVAL :register_presubmit_day DAY)');
        if (in_array($this->id, array(155))) {
            $criteria->params[':register_end_day'] = 0;
        } elseif (in_array($this->id, array(197))) {
            $criteria->params[':register_end_day'] = 3;
        } else {
            $criteria->params[':register_end_day'] = Configuration::getKey('register_before_day', '0');
        }
        $criteria->params[':register_presubmit_day'] = Configuration::getKey('register_presubmit_day', '0');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getHtmlAdminStatus() {
        if ($this->isClose) {
            return '<span class="text-danger">ปิด</span> ' . (isset($this->close_description) ? ' - <small class="text-muted">' . CHtml::encode($this->close_description) . '</small>' : '');
        }

        if ($this->getIsExpired()) {
            return '<span class="text-danger">ปิดรับสมัคร</span> ';
        }

        return '<span class="text-success">เปิดรับสมัคร</span>';
    }

    public function getCountExamSetTaskItemByApplication() {
        $count = 0;
        foreach ($this->examApplications(array('scopes' => array('scopeValid'))) as $application) {
            /* @var $application ExamApplication */
            if ($application->is_present === self::YES) {
                foreach ($this->examScheduleUniqueItems as $subject) {
                    $examSet = $application->getExamSetBySubject($subject->examSubject->code);
                    if (isset($examSet->examSet)) {
                        $count += $examSet->examSet->countExamSetTaskItem;
                    }
                }
            }
        }
        return $count;
    }

}
