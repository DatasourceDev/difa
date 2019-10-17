<?php

Yii::import('application.models._base.BaseExamQuestionMethod');

class ExamQuestionMethod extends BaseExamQuestionMethod {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getIsAutoCheckOptions($code = null) {
        $ret = array(
            self::YES => 'ตรวจคะแนนโดยระบบ',
            self::NO => 'ตรวจคะแนนโดยเจ้าหน้าที่',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getIsGradeSetOptions($code = null) {
        $ret = array(
            self::YES => 'กำหนดระดับโดยตรง',
            self::NO => 'คะนวณระดับตามคะแนน',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชนิดของข้อสอบ',
            'is_auto_check' => 'วิธีการตรวจคะแนน',
            'is_grade_set' => 'วิธีการให้ระดับ',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name, is_auto_check', 'required'),
        ));
    }

    public function getIsAutoCheck() {
        return $this->is_auto_check === self::YES;
    }

    public function getIsGradeSet() {
        return $this->is_grade_set === self::YES;
    }

}
