<?php

Yii::import('application.models._base.BaseExamScheduleItem');

/**
 * @property ExamSchedule $examSchedule
 */
class ExamScheduleItem extends BaseExamScheduleItem {

    public $pk;
    public $place_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function decodeStringId($id = array()) {
        return CJSON::decode($id);
    }

    public static function encodeStringId($exam_schedule_id, $exam_subject_id, $exam_set_id) {
        return CJSON::encode(array(
                    'exam_schedule_id' => $exam_schedule_id,
                    'exam_subject_id' => $exam_subject_id,
                    'exam_set_id' => $exam_set_id,
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_subject_id' => 'ประเภทการสอบ',
            'exam_set_id' => 'ชุดข้อสอบ',
            'db_date' => 'วันที่จัดสอบ',
            'time_start' => 'เวลาเริ่มต้น',
            'time_end' => 'เวลาสิ้นสุด',
            'code_place_id' => 'ชือสถานที่สอบ',
            'place_name' => 'ชือสถานที่สอบ',
            'place_remark' => 'ชั้น / ห้อง',
            'place_file' => Yii::t('model', 'BaseExamScheduleItem.attribute.place_file'),
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'placeFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'place_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/place',
                'prefix' => 'place_',
                'forceExt' => 'png',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                ),
                'defaultName' => 'default',
            ),
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ExamApplicationExamSet::model()->deleteAllByAttributes(array(
                'exam_schedule_id' => $this->exam_schedule_id,
                'exam_set_id' => $this->exam_set_id,
            ));
            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'codePlace' => array(self::BELONGS_TO, 'CodePlace', 'code_place_id'),
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
            'examSubject' => array(self::BELONGS_TO, 'ExamSubject', 'exam_subject_id'),
            'examSet' => array(self::BELONGS_TO, 'ExamSet', 'exam_set_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('db_date, time_start, time_end, code_place_id, place_remark', 'required'),
            array('place_file', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'png')),
            array('exam_set_id', 'checkExamSetUnique', 'on' => 'insert'),
        ));
    }

    public function checkExamSubjectUnique() {
        $model = ExamScheduleItem::model()->findByAttributes(array(
            'exam_schedule_id' => $this->exam_schedule_id,
            'exam_subject_id' => $this->exam_subject_id,
        ));
        if (isset($model)) {
            $this->addError('exam_subject_id', 'ไม่สามารถเพิ่มทักษะในการสอบซ้ำกัน');
        }
    }

    public function checkExamSetUnique() {
        $model = ExamScheduleItem::model()->findByAttributes(array(
            'exam_schedule_id' => $this->exam_schedule_id,
            'exam_subject_id' => $this->exam_subject_id,
            'exam_set_id' => $this->exam_set_id,
        ));
        if (isset($model)) {
            $this->addError('exam_set_id', 'ไม่สามารถเพิ่มชุดสอบซ้ำกัน');
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->order_no = CHtml::value($this, 'examSubject.order_no', 1);
            }
            $this->place_name = CHtml::value($this, 'codePlace', 'name');
            return true;
        }
    }

    public function afterSave() {
        parent::afterSave();
        $this->examSchedule->updateExamDate();

        // กรณีเพิ่มเข้าใหม่
        if ($this->isNewRecord) {
            $criteira = new CDbCriteria();
            $criteira->compare('exam_schedule_id', $this->exam_schedule_id);
            $criteira->compare('exam_subject_id', $this->exam_subject_id);
            $ids = CHtml::listData(ExamApplicationExamSet::model()->findAll($criteira), 'exam_application_id', 'exam_application_id');

            $criteria = new CDbCriteria();
            $criteria->compare('exam_schedule_id', $this->exam_schedule_id);
            $criteria->addNotInCondition('id', $ids);
            $applications = ExamApplication::model()->scopeValid()->findAll($criteria);
            foreach ($applications as $application) {
                $application->takeExamSet($this);
            }
        }
    }

    public function getStringId() {
        return self::encodeStringId($this->exam_schedule_id, $this->exam_subject_id, $this->exam_set_id);
    }

    public function getTextDateTime() {
        return Yii::app()->format->formatDateText($this->db_date) . ' ' . $this->getTimeRange();
    }

    public function getTextTime() {
       return  $this->getShortTimeRange();
    }
    /**
     * @deprecated since version 1.0
     * @return type
     */
    public function getTimeRange() {
       if ($this->time_start === $this->time_end) {
          return Yii::app()->format->formatTime($this->time_start);
       }
       return Yii::app()->format->formatTime($this->time_start) . '-' . Yii::app()->format->formatTime($this->time_end);
    }

    public function getShortTimeRange() {
        if ($this->time_start === $this->time_end) {
            return Yii::app()->format->formatTime($this->time_start);
        }
        $txt = str_replace( ' น.','',Yii::app()->format->formatTime($this->time_start));
        return $txt . '-' . Yii::app()->format->formatTime($this->time_end);
    }

    /**
     *
     * @return type
     */
    public function getTextTimeRange() {
        if ($this->time_start === $this->time_end) {
            return Yii::app()->format->formatTime($this->time_start);
        }
        return Yii::app()->format->formatTimeRange($this->time_start, $this->time_end);
    }

    public function getHtmlTimeRange() {
        if ($this->time_start === $this->time_end) {
            return Yii::app()->format->formatTime($this->time_start);
        }
        return Yii::app()->format->formatTimeRangeHtml($this->time_start, $this->time_end);
    }

}
