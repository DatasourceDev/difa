<?php

class AjaxExamScheduleGetAction extends CAction {

    public function run($id) {
        $ret = array();
        $model = ExamSchedule::model()->findByPk($id);
        if (isset($model)) {
            $ret = array(
                'id' => $model->id,
                'text' => $model->exam_code . ' (' . CHtml::value($model, 'countAttendee', 0) . ')',
            );
        }
        echo CJSON::encode($ret);
    }

}
