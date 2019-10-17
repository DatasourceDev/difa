<?php

class WebConfigurationController extends AdministratorController {

    public $layout = '/web/_layout';
    public $title = 'ตั้งค่าเว็บไซต์';

    public function actionIndex() {
        $model = new WebConfigurationForm;
        $data = Yii::app()->request->getPost('WebConfigurationForm');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

}
