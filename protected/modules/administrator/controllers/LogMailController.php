<?php

class LogMailController extends AdministratorController {

    public function actionIndex() {
        $model = new MailLog('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getPost('MailLog');
        $dataProvider = $model->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionResend($id) {
        $model = MailLog::model()->findByPk($id);
        $model->send();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionAjaxView($id) {
        $model = MailLog::model()->findByPk($id);
        $this->renderPartial('ajaxView', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = MailLog::model()->findByPk($id);
        $model->delete();
    }

    public function actionDeleteAll() {
        MailLog::model()->deleteAll();
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', 'ลบข้อมูลการส่งจดหมายอิเล็กทรอนิกส์ทั้งหมดเรียบร้อย');
            $this->redirect(array('index'));
        }
    }

}
