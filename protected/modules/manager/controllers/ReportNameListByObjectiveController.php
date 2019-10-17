<?php

class ReportNameListByObjectiveController extends ManagerController {

    public function actionIndex() {
        $this->render('index', array(
        ));
    }

    public function actionPrint() {
        $pdf = new PDFMaker;
        $pdf->addPage('nameListByObjective', array(
            'examSchedule' => $this->examSchedule,
        ));
        $pdf->output();
    }

}
