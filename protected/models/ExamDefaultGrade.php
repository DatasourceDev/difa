<?php

Yii::import('application.models._base.BaseExamDefaultGrade');

class ExamDefaultGrade extends BaseExamDefaultGrade {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'grade' => 'ระดับ',
            'order_no' => 'ลำดับ',
            'description' => 'คำอธิบาย',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('description, order_no', 'required'),
        ));
    }

}
