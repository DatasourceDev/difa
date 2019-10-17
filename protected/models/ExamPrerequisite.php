<?php

Yii::import('application.models._base.BaseExamPrerequisite');

class ExamPrerequisite extends BaseExamPrerequisite {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_type_id' => 'ประเภทการสอบ',
            'exam_type_require_id' => 'ประเภทการสอบ',
            'exam_subject_require_id' => 'ทักษะในการสอบ',
            'minimum_grade' => 'ระดับขั้นต่ำ',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examType' => array(self::BELONGS_TO, 'ExamType', 'exam_type_id'),
            'examTypeRequire' => array(self::BELONGS_TO, 'ExamType', 'exam_type_require_id'),
            'examSubjectRequire' => array(self::BELONGS_TO, 'ExamSubject', 'exam_subject_require_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('exam_type_require_id, exam_subject_require_id', 'checkDuplicate', 'on' => 'insert'),
            array('minimum_grade', 'required'),
        ));
    }

    public function checkDuplicate($attribute) {
        $model = ExamPrerequisite::model()->findByAttributes(array(
            'exam_type_id' => $this->exam_type_id,
            'exam_subject_id' => $this->exam_subject_id,
            'exam_type_require_id' => $this->exam_type_require_id,
            'exam_subject_require_id' => $this->exam_subject_require_id,
        ));
        if (isset($model)) {
            $this->addError($attribute, 'ไม่สามารถบันทึกวิชาที่ซ้ำกัน');
        }
    }

    public function scopeDefaultOrder() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSubjectRequire' => array(
                'together' => true,
            ),
        );
        $criteria->order = 'examSubjectRequire.order_no';
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }
}
