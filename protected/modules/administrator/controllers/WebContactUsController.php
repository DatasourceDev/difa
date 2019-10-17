<?php

class WebContactUsController extends AdministratorController {

    public function actionIndex() {
        $model = new WebContactUs;
        $data = Yii::app()->request->getPost('WebContactUs');
        if (isset($data)) {
            $model->attributes = $data;
            $model->googlemap = $data['googlemap'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionDeleteImage() {
        $model = new WebContactUs;
        $f = $model->removeImage();
        Yii::app()->user->setFlash('success', 'ลบรูป ' . $f . ' สำเร็จ');
    }

}
