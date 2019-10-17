<?php

Yii::import('application.models._base.BaseExamScheduleDepartment');

class ExamScheduleDepartment extends BaseExamScheduleDepartment {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'codeDepartment' => array(self::BELONGS_TO, 'CodeDepartment', 'code_department_id'),
        ));
    }

}
