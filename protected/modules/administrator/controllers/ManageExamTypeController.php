<?php

class ManageExamTypeController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'ข้อมูลประเภทการสอบ';

    public function actionCreate() {
        $model = new ExamType;
        $data = Yii::app()->request->getPost('ExamType');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('manageExam/index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = ExamType::model()->findByPk($id);
        $data = Yii::app()->request->getPost('ExamType');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('manageExam/index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = ExamType::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
            $this->redirect(array('manageExam/index'));
        }
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

}
