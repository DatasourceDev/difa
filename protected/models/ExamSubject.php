<?php

Yii::import('application.models._base.BaseExamSubject');

class ExamSubject extends BaseExamSubject {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อทักษะ',
            'name_en' => 'ชื่อทักษะ (ภาษาอังกฤษ)',
            'code' => 'รหัสอักษร',
            'badge_color' => 'สี',
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {

            ExamDefaultGrade::model()->deleteAllByAttributes(array(
                'exam_subject_id' => $this->id,
            ));

            foreach ($this->examDefaultGrades as $item) {
                $item->delete();
            }

            foreach ($this->examPrerequisites as $item) {
                $item->delete();
            }

            foreach ($this->examPrerequisites1 as $item) {
                $item->delete();
            }

            foreach ($this->examScheduleItems as $item) {
                $item->delete();
            }

            foreach ($this->examSets as $item) {
                $item->delete();
            }

            foreach ($this->examSubjectTopics as $item) {
                $item->delete();
            }

            foreach ($this->examTopics as $item) {
                $item->delete();
            }

            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examDefaultGrades' => array(self::HAS_MANY, 'ExamDefaultGrade', 'exam_subject_id', 'order' => 'order_no'),
            'examType' => array(self::BELONGS_TO, 'ExamType', 'exam_type_id'),           
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name, name_en, code', 'required'),
        ));
    }

    public function getTextName() {
        if (Yii::app()->language === 'th') {
            return CHtml::encode($this->name) . ' (' . CHtml::encode($this->name_en) . ')';
        } else {
            return CHtml::encode($this->name_en);
        }
    }

    public function getTextNameWithType() {
        if (Yii::app()->language === 'th') {
            return CHtml::encode($this->examType->name . ': ' . $this->name) . ' (' . CHtml::encode($this->name_en) . ')';
        } else {
            return CHtml::encode($this->examType->name . ': ' . $this->name_en);
        }
    }

    public function scopeExamType($exam_type_id) {
        if ($exam_type_id) {
            $criteria = new CDbCriteria();
            $criteria->compare('exam_type_id', $exam_type_id);
            $this->dbCriteria->mergeWith($criteria);
        }
        return $this;
    }    

    public function getSkillName() {
        return CHtml::encode($this->examType->code . ' ' . $this->name);
    }

    public function sortByDefault() {
        $criteria = new CDbCriteria();
        $criteria->order = '
            (CASE 
                WHEN t.code = "R" THEN -100
                WHEN t.code = "L" THEN -90
                WHEN t.code = "W" THEN -80
                WHEN t.code = "S" THEN -70
            END)
            ';
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

}
