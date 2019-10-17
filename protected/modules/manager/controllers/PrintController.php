<?php

class PrintController extends ManagerController {

    public function actionExamCard($id) {
        $pdf = new PDFMaker;
        $application = ExamApplication::model()->findByPk($id);
        $pdf->addPage('examCard', array(
            'application' => $application,
        ));
        $pdf->output();
    }

    public function actionPaymentSlip($id) {
        $pdf = new PDFMaker;
        $application = ExamApplication::model()->findByPk($id);
        $pdf->addPage('paymentSlip', array(
            'application' => $application,
        ));
        $pdf->output();
    }

    public function actionProfile($id) {
        $pdf = new PDFMaker;
        $account = Account::model()->findByPk($id);
        $pdf->writeHTML($this->renderPartial('profile', array(
                    'account' => $account,
                        ), true));
        $pdf->output();
    }

}
