<?php

Yii::import('application.models._base.BaseExamSpeaking');

class ExamSpeaking extends BaseExamSpeaking {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'รหัส',
            'name' => 'ชุดสอบ',
            'description' => 'คำอธิบาย',
        ));
    }

}
