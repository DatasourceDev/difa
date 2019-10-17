<?php

class WebDownloadController extends AdministratorController {

    public function actionIndex() {
        $model = new WebDownload;
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('order_no')->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new WebDownload;

        $data = Yii::app()->request->getPost('WebDownload');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = WebDownload::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebDownload');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = WebDownload::model()->findByPk($id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionDownload($id) {
        $model = WebDownload::model()->findByPk($id);
        Yii::app()->request->sendFile(basename($model->docFile->fileUrl), file_get_contents($model->docFile->filePath));
    }

    public function actionMoveDown($id) {
        $model = WebDownload::model()->findByPk($id);
        $model->doMoveDown();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionMoveUp($id) {
        $model = WebDownload::model()->findByPk($id);
        $model->doMoveUp();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
