<?php

Yii::import('application.models._base.BaseExamScheduleObjective');

class ExamScheduleObjective extends BaseExamScheduleObjective {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getIsPrivateObtions($code = null) {
        $ret = array(
            self::NO => 'ทั่วไป',
            self::YES => 'เฉพาะกิจ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name_th' => 'วัตถุประสงค์',
            'name_en' => 'Objective',
            'is_private' => 'ประเภท',
            'period_start' => 'วันที่เริ่ม',
            'period_end' => 'วันที่สิ้นสุด',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examApplications' => array(self::HAS_MANY, 'ExamApplication', array('exam_schedule_id' => 'exam_schedule_id'))
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name_th, name_en, is_private', 'required'),
        ));
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord && empty($this->id)) {
                $criteria = new CDbCriteria();
                $criteria->select = 'COALESCE(MAX(id),0)+1 as id';
                $criteria->compare('exam_schedule_id', $this->exam_schedule_id);
                $nextModel = ExamScheduleObjective::model()->find($criteria);
                $this->id = CHtml::value($nextModel, 'id');
            }
            return true;
        }
    }

    public function getTextIsPrivate() {
        return self::getIsPrivateObtions($this->is_private);
    }

}
