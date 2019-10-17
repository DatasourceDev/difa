<?php

/**
 * รายงาน : บัตรประจำตัวสอบ
 */
class ReportExamCardController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getParam('ExamApplication');
        $dataProvider = $model->with(array(
                    'examSchedule' => array(
                        'together' => true,
                    ),
                ))->sortBy('examSchedule.exam_code DESC, t.desk_no')->scopeValid()->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $pdf = new PDFMaker;
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $applications = ExamApplication::model()->scopeValid()->findAll($criteria);
        foreach ($applications as $application) {
            $pdf->addPage('examCard', array(
                'application' => $application,
            ));
        }
        $pdf->output();
    }

}
