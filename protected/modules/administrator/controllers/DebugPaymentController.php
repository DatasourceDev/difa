<?php

class DebugPaymentController extends AdministratorController {

    public function actionIndex() {
        $model = new ApplicationPayment('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('created DESC')->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate($status = 1) {
        $app = new ApplicationPayment;
        $app->createTestCase($status);
        Yii::app()->user->setFlash('success', 'สร้างใบชำระเงินเรียบร้อย');
        $this->redirect(array('index'));
    }

    public function actionDelete($id) {
        $model = ApplicationPayment::model()->findByPk($id);
        $model->delete();
    }

    public function actionPrint($id) {
        $model = ApplicationPayment::model()->findByPk($id);
        $pdf = new PDFMaker;
        $pdf->addPagePaymentSlipTest($model);
        $pdf->output();
    }

}
