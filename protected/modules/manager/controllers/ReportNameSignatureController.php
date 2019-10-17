<?php

class ReportNameSignatureController extends ManagerController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionPrint() {
        $pdf = new PDFMaker;
        $pdf->addPage('nameSignature', array(
            'examSchedule' => $this->examSchedule,
        ));
        $pdf->output();
    }

}
