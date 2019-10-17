<?php

class WebTemplateController extends AdministratorController {

    public $layout = '/web/_layout';
    public $title = 'จัดการรูปแบบเว็บไซต์';

    public function actionIndex() {
        $model = new WebTemplateForm;
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionActive($id) {
        $model = new WebTemplateForm;
        if($model->active($id)) {
            Yii::app()->user->setFlash('success',Helper::MSG_TH_SAVED);
        }
        $this->redirect(array('index'));
    }

    public function actionDeleteImage($field, $theme) {
        $model = new WebTemplateForm;
        $model->theme_name = $theme;
        $f = $model->removeImage($field);
        Yii::app()->user->setFlash('success', 'ลบรูป ' . $f . ' สำเร็จ');
    }

    public function actionEdit($id) {
        $model = new WebTemplateForm;
        $model->theme_name = $id;
        $data = Yii::app()->request->getPost('WebTemplateForm');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save($id)) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

}
