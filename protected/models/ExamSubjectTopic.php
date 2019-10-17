<?php

Yii::import('application.models._base.BaseExamSubjectTopic');

class ExamSubjectTopic extends BaseExamSubjectTopic {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_topic_code' => 'รหัสหัวข้อในการสอบ',
            'name' => 'หัวข้อในการสอบ',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name', 'required'),
        ));
    }

    public function getTextName() {
        return CHtml::encode($this->exam_topic_code) . ' - ' . $this->name;
    }

}
