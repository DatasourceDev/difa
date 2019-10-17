<?php

class ManageExamSubjectController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'ข้อมูลทักษะในการสอบ';

    public function actionCreate($id) {
        $model = new ExamSubject;
        $model->exam_type_id = $id;
        $data = Yii::app()->request->getPost('ExamSubject');
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
        $model = ExamSubject::model()->findByPk($id);
        $data = Yii::app()->request->getPost('ExamSubject');
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
        $model = ExamSubject::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('manageExam/index'));
        }
    }

}
