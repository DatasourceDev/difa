<?php

class ManageExamQuestionMethodController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'จัดการชนิดของข้อสอบ';

    public function actionIndex() {
        $model = new ExamQuestionMethod('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new ExamQuestionMethod;
        $data = Yii::app()->request->getPost('ExamQuestionMethod');
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
        $model = ExamQuestionMethod::model()->findByPk($id);
        $data = Yii::app()->request->getPost('ExamQuestionMethod');
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
        $model = ExamQuestionMethod::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
