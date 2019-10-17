<?php

class ManageSchedulePaymentController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->is_paid = ActiveRecord::YES;
        $dataProvider = $model->scopeValid()->sortBy('payment_date')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPay() {
        $model = new WebPaymentForm();
        $data = Yii::app()->request->getPost('WebPaymentForm');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->doPay()) {
                Yii::app()->user->setFlash('success', 'บันทึกรายการเรียบร้อย');
                $this->redirect(array('index'));
            }
        }
        $this->render('pay', array(
            'model' => $model,
        ));
    }

}
