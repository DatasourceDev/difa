<?php

Yii::import('application.models._base.BaseExamSetGrade');

class ExamSetGrade extends BaseExamSetGrade {

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
            array('order_no', 'checkExamSetGradeUnique', 'on' => 'insert'),
            array('description, order_no', 'required'),
        ));
    }

    public function checkExamSetGradeUnique($attribute) {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_set_id', $this->exam_set_id);
        $criteria->compare('order_no', $this->order_no);
        $model = ExamSetGrade::model()->find($criteria);
        if (isset($model)) {
            $this->addError($attribute, 'ไม่สามารถระบุเลขลำดับซ้ำได้');
        }
    }

    public function nextGrade() {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_set_id', $this->exam_set_id);
        $criteria->compare('min_score', '>' . $this->min_score);
        $criteria->order = 'ABS(min_score - :min_score)';
        $criteria->params[':min_score'] = $this->min_score;
        return ExamSetGrade::model()->find($criteria);
    }

    public function prevGrade() {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_set_id', $this->exam_set_id);
        $criteria->compare('min_score', '<' . $this->min_score);
        $criteria->order = 'ABS(min_score - :min_score)';
        $criteria->params[':min_score'] = $this->min_score;
        return ExamSetGrade::model()->find($criteria);
    }

}
