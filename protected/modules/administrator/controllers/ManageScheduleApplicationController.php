<?php

class ManageScheduleApplicationController extends AdministratorController {

    public $layout = '/manageSchedule/_layout';
    public $title = 'ข้อมูลการสมัครสอบ';

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getParam('ExamApplication');
        $dataProvider = $model->with(array('examSchedule' => array('together' => true)))->scopeValid()->sortBy('examSchedule.db_date DESC, t.desk_no')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionSetPaid($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (!$model->doPaid()) {
            var_dump($model->errors);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionSetUnpaid($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (!$model->undoPaid()) {
            var_dump($model->errors);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionSetCancel($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (!$model->cancel()) {
            var_dump($model->errors);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionSendExamCard($id) {
        $application = ExamApplication::model()->findByPk($id);

        $pdf = new PDFMaker;
        if ($application->isPaid) {
            $pdf->addPagePaymentSlip($application);
        } else {
            $pdf->addPageExamCard($application);
        }

        $message = new YiiMailMessage;
        $message->view = 'sendExamCard';
        $message->setSubject('DIFA-TES : Your Examination Card / Payment Slip');
        $message->addTo(CHtml::value($application, 'account.profile.contact_email'));
        $message->from = Yii::app()->params['adminEmail'];
        $message->attach(Swift_Attachment::newInstance($pdf->outputAsString(), 'payment-slip.pdf', 'application/pdf'));
        if (!Yii::app()->mail->send($message)) {
            throw new CException('Mail server error');
        }
        Yii::app()->user->setFlash('success', 'ส่งข้อมูลเรียบร้อย');
        $this->redirect(array('index'));
    }

}
