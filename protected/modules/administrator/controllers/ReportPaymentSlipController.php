<?php

class ReportPaymentSlipController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->with(array('examSchedule' => array('together' => true)))->scopeSelfRegister()->scopeNonFree()->scopeValidWithAnyPayment()->sortBy('examSchedule.exam_code DESC, desk_no')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionOffice() {
        $model = new ExamScheduleAccount('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamScheduleAccount');
        $dataProvider = $model->search();
        $this->render('office', array(
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
            $pdf->addPage('paymentSlip', array(
                'application' => $application,
            ));
        }
        $pdf->output();
    }

    public function actionPrintOffice() {
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $pdf = new PDFMaker;

        $criteria = new CDbCriteria();
        $criteria->addInCondition('account_id', $items);
        $applications = ExamScheduleAccount::model()->findAll($criteria);

        foreach ($applications as $application) {
            $pdf->addPage('paymentOffice', array(
                'schedule' => $application->examSchedule,
                'scheduleAccount' => $application,
            ));
        }
        $pdf->output();
    }

}
