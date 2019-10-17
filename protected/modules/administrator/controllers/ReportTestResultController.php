<?php

class ReportTestResultController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->scopeValid()->with(array('examSchedule' => array('together' => true)))->sortBy('examSchedule.exam_code DESC, t.desk_no')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        Yii::app()->language = 'en';
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $pdf = new PDFMaker;

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $applications = ExamApplication::model()->scopeValid()->findAll($criteria);
        foreach ($applications as $application) {
            $pdf->addPage('testResultReplyFront', array(
                'application' => $application,
            ));
            $pdf->addPage('testResultReplyBack', array(
                'application' => $application,
            ));
        }
        $pdf->output();
    }

}
