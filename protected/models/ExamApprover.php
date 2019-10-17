<?php

Yii::import('application.models._base.BaseExamApprover');

class ExamApprover extends BaseExamApprover {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'รหัสอาจารย์',
            'name' => 'ชื่ออาจารย์',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('id', 'unique', 'message' => 'มีการใช้รหัสนี้แล้วในระบบ'),
            array('name', 'required'),
            array('id', 'length', 'min' => 2, 'max' => 2),
            array('id', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 99),
        ));
    }

}
