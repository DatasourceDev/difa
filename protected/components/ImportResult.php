<?php

class ImportResult extends CComponent {

    public $exam_schedule_id;
    public $exam_subject_id;
    public $exam_set_id;
    public $account_id;
    public $exam_application_id;
    public $is_success;
    public $comment;
    public $score;
    public $grade;
    public $is_border_line;
    public $is_change_examset;
    public $prev_exam_set_id;

    public function getExamApplication() {
        return ExamApplication::model()->findByPk($this->exam_application_id);
    }

    public function getExamSchedule() {
        return ExamSchedule::model()->findByPk($this->exam_schedule_id);
    }

}
