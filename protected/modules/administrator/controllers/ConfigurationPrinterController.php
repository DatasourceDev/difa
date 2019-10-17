<?php

class ConfigurationPrinterController extends AdministratorController {

    public function actionIndex() {
        $model = new ConfigurationPrinterForm;
        $data = Yii::app()->request->getPost('ConfigurationPrinterForm');
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
