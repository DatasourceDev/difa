<?php

class WebContentSmsController extends AdministratorController {

    public function actionIndex() {
        $model = new WebSms;
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new WebSms;

        $data = Yii::app()->request->getPost('WebSms');
        if (isset($data)) {
            $model->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = WebSms::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebSms');
        if (isset($data)) {
            $model->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = WebSms::model()->findByPk($id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionView($id) {
        $model = WebSms::model()->findByPk($id);

        $item = new WebSmsItem('search');
        $item->unsetAttributes();
        $item->web_sms_id = $model->id;
        $dataProvider = $item->search();

        $this->render('view', array(
            'model' => $model,
            'item' => $item,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpload() {
        $path = Yii::getPathOfAlias('webroot.uploads.content');
        $file = CUploadedFile::getInstanceByName('file');
        if ($file) {
            $filename = md5(date('YmdHis')) . '.' . $file->extensionName;
            $file->saveAs($path . '/' . $filename);
            echo stripslashes(json_encode(array(
                'filelink' => Yii::app()->getBaseUrl(true) . '/uploads/content/' . $filename,
                'id' => time(),
            )));
        }
    }

    public function actionSend($id) {
        set_time_limit(0);
        $mail = WebSms::model()->findByPk($id);
        $items = WebSmsItem::model()->findAllByAttributes(array(
            'web_sms_id' => $mail->id,
        ));
        foreach ($items as $item) {
            $item->send();
        }
        $this->redirect(array('view', 'id' => $mail->id));
    }

}
