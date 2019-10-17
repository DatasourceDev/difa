<?php

class LogSmsController extends AdministratorController {

    public function actionIndex() {
        $model = new SmsLog('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionClear() {
        Yii::app()->db->createCommand()->truncateTable(SmsLog::model()->tableSchema->name);
        Yii::app()->user > setFlash('success', 'ลบข้อมูลทั้งหมดเรียบร้อย');
        $this->redirect(array('index'));
    }

}
