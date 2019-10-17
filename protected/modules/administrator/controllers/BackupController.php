<?php

Yii::import('application.models.core.CoreBackup');

class BackupController extends AdministratorController {

    public $title = 'สำรองข้อมูล';

    public function actionIndex() {
        $model = new CoreBackup('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionDelete($id) {
        $model = CoreBackup::model()->findByPk($id);
        if (isset($model)) {
            $model->delete();
        }
    }

    public function actionDownload($id) {
        $model = CoreBackup::model()->findByPk($id);
        if (isset($model)) {
            Yii::app()->request->sendFile($model->filename, file_get_contents(Configuration::getKey('backup_file_path', Yii::getPathOfAlias('application.uploads.backup')) . '/' . $model->filename));
        }
    }

    public function actionBackup() {
        $backup = new CoreBackup;
        $backup->doBackup();
        Yii::app()->user->setFlash('success', 'สำรองข้อมูลเรียบร้อย');
        $this->redirect(array('index'));
    }

    public function actionRestore($id) {
        $restore = CoreBackup::model()->findByPk($id);

        $backup = new CoreBackup;
        $backup->doBackup(date('Y-m-d H:i:s') . '- สำรองข้อมูลอัตโนมัติ ก่อนที่จะมีการนำเข้าข้อมูล วันที่ ' . date('Y-m-d H:i:s', $restore->created), 1);

        $restore->doRestore();
        Yii::app()->user->setFlash('success', 'นำเข้าข้อมูลเรียบร้อย');
        $this->redirect(array('index'));
    }

}
