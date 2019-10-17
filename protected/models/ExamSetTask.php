<?php

Yii::import('application.models._base.BaseExamSetTask');

class ExamSetTask extends BaseExamSetTask {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_question_method_id' => 'ชนิดของข้อสอบ',
            'task_num' => 'จำนวนข้อ',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examSetTaskItems' => array(self::HAS_MANY, 'ExamSetTaskItem', array(
                    'exam_set_id' => 'exam_set_id',
                    'task_no' => 'task_no',
                )),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('task_num', 'required'),
            array('task_num', 'numerical', 'min' => 1, 'max' => 20),
            array('exam_question_method_id', 'checkMaxTask'),
        ));
    }

    public function checkMaxTask($attribute) {
        if ($this->examSet->countExamSetTask >= 10) {
            $this->addError($attribute, 'ไม่สามารถเพิ่ม Task เกินกว่า 10 รายการ');
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ExamSetTaskItem::model()->deleteAllByAttributes(array(
                'exam_set_id' => $this->exam_set_id,
                'task_no' => $this->task_no,
            ));
            return true;
        }
    }

    public function create() {

        if (CHtml::value($this->examQuestionMethod, 'is_grade_set') === self::YES) {
            $this->task_num = 1;
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'COALESCE(MAX(task_no),0) + 1 as task_no';
        $criteria->compare('exam_set_id', $this->exam_set_id);
        $model = ExamSetTask::model()->find($criteria);
        $num = isset($model) ? $model->task_no : 1;
        $this->task_no = $num;
        $this->order_no = $num;
        $this->is_auto_check = CHtml::value(ExamQuestionMethod::model()->findByPk($this->exam_question_method_id), 'is_auto_check', self::NO);
        if ($this->save()) {
            // exam set task item
            if ($this->is_auto_check === self::YES) {
                for ($i = 1; $i <= $this->task_num; $i++) {
                    $item = new ExamSetTaskItem;
                    $item->exam_set_id = $this->exam_set_id;
                    $item->task_no = $this->task_no;
                    $item->order_no = $i;
                    $item->save();
                }
            }
            return true;
        }
    }

    public function getIsAutoCheck() {
        return $this->is_auto_check === self::YES;
    }

}
