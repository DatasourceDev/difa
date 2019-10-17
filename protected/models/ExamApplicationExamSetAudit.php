<?php

Yii::import('application.models._base.BaseExamApplicationExamSetAudit');

class ExamApplicationExamSetAudit extends BaseExamApplicationExamSetAudit {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'approve' => array(self::BELONGS_TO, 'User', 'approve_id'),
            'examSet' => array(self::BELONGS_TO, 'ExamSet', 'exam_set_id'),
        ));
    }

    public function getScoreBefore() {
        if ($this->is_update === self::NO) {
            return isset($this->score_update) ? $this->score_update : $this->score;
        } else {
            return $this->score;
        }
    }

    public function getGradeBefore() {
        if ($this->is_update === self::NO) {
            return isset($this->grade_update) ? $this->grade_update : $this->grade;
        } else {
            return $this->grade;
        }
    }

    public function getScoreAfter() {
        if ($this->is_update === self::NO) {
            return isset($this->score_update) ? $this->score : null;
        } else {
            return $this->score_update;
        }
    }

    public function getGradeAfter() {
        if ($this->is_update === self::NO) {
            return isset($this->grade_update) ? $this->grade : null;
        } else {
            return $this->grade_update;
        }
    }

}
