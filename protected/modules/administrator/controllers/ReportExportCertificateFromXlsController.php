<?php

class ReportExportCertificateFromXlsController extends AdministratorController {

    public function actionIndex() {
        $model = new ReportExportCertificateFromXlsForm;
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('ReportExportCertificateFromXlsForm');
            $model->export();
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionDownload() {
        Yii::app()->request->sendFile('certificate-import.xlsx', file_get_contents(Yii::getPathOfAlias('application.data.downloads') . '/certificate-import.xlsx'));
    }

}
