<?php

class ReportPaymentStatusController extends ManagerController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionPrint() {
        $pdf = new PDFMaker;
        $pdf->addPage('paymentStatus', array(
            'examSchedule' => $this->examSchedule,
        ));
        $pdf->output();
    }

}
