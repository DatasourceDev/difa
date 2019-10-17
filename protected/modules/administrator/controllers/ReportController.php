<?php

class ReportController extends AdministratorController {

    public function init() {
        parent::init();
    }

    public function actions() {
        return array_merge(parent::actions(), array(
            'ajaxExamScheduleSearch' => array(
                'class' => 'AjaxExamScheduleSearchAction',
            ),
            'ajaxExamScheduleGet' => array(
                'class' => 'AjaxExamScheduleGetAction',
            ),
        ));
    }

    protected function getPdf() {
       Yii::import('application.vendors.mpdf60.mpdf', true);
        return new mPDF;
    }

}
