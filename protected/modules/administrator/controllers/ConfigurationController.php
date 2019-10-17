<?php

class ConfigurationController extends AdministratorController {

    public function actionIndex() {
        $this->renderForm('index');
    }

    public function actionSms() {
        $this->renderForm('sms');
    }

    public function actionMail() {
        $this->renderForm('mail');
    }

    public function renderForm($view) {
        $model = new ConfigurationForm($view);
        $data = Yii::app()->request->getPost('ConfigurationForm');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array($view));
            }
        }
        $this->render($view, array(
            'model' => $model,
        ));
    }

}
