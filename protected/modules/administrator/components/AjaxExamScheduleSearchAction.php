<?php

class AjaxExamScheduleSearchAction extends CAction {

    public function run($q = null) {
        $ret = array();
        $criteria = new CDbCriteria();
        $criteria->limit = 10;
        $words = explode(' ', $q);
        foreach ($words as $word) {
            $wordCriteria = new CDbCriteria();
            $wordCriteria->compare('t.exam_code', $q, true, 'OR');
            $criteria->mergeWith($wordCriteria);
        }
        $criteria->order = 't.db_date DESC';
        $items = ExamSchedule::model()->findAll($criteria);
        foreach ($items as $item) {
            $ret['items'][] = array(
                'id' => $item->id,
                'text' => $item->exam_code . ' (' . CHtml::value($item, 'countAttendee', 0) . ')',
            );
        }
        echo CJSON::encode($ret);
    }

}
