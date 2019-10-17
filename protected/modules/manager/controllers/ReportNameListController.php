<?php

class ReportNameListController extends ManagerController {

    public function actionIndex() {
        $this->render('index', array(
        ));
    }

    public function actionPrint() {
        $pdf = new PDFMaker;
        $pdf->addPage('nameList', array(
            'examSchedule' => $this->examSchedule,
        ));
        $pdf->output();
    }

}
