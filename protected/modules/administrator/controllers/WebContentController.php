<?php

class WebContentController extends AdministratorController {

    public function actionIndex() {
        $model = new WebContent;
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('created DESC')->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new WebContent;

        $data = Yii::app()->request->getPost('WebContent');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
               $model->doUploadVDO();
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = WebContent::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebContent');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->doUpdateAndUploadVDO()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = WebContent::model()->findByPk($id);
        if ($model->delete()) {
            $model->doDeleteVDO();
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionView($id) {
        $model = WebContent::model()->findByPk($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionUpload() {
        $path = Yii::getPathOfAlias('webroot.uploads.content');
        $file = CUploadedFile::getInstanceByName('file');
        if ($file) {
            $filename = md5(date('YmdHis')) . '.' . $file->extensionName;
            $file->saveAs($path . '/' . $filename);
            echo stripslashes(json_encode(array(
                'filelink' => Yii::app()->baseUrl . '/uploads/content/' . $filename,
                'id' => time(),
            )));
        }
    }

    public function actionTogglePin($id) {
        $model = WebContent::model()->findByPk($id);
        $model->doTogglePin();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
