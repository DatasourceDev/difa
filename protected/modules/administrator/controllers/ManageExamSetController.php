<?php

class ManageExamSetController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'จัดการชุดข้อสอบ';

    public function actionIndex() {
        $model = new ExamSet('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new ExamSet;
        $model->exam_year = date('Y');
        $data = Yii::app()->request->getParam('ExamSet');
        if (isset($data)) {
            $model->attributes = $data;
            if (Yii::app()->request->isPostRequest && $model->create()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = ExamSet::model()->findByPk($id);
        $data = Yii::app()->request->getParam('ExamSet');
        if (isset($data)) {
            $model->attributes = $data;
            if (Yii::app()->request->isPostRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = ExamSet::model()->findByPk($id);
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionViewGrade($id) {
        $model = ExamSet::model()->findByPk($id);

        $newGrade = new ExamSetGrade();
        $newGrade->exam_set_id = $model->id;
        $data = Yii::app()->request->getPost('ExamSetGrade');
        if (isset($data)) {
            $newGrade->attributes = $data;
            if ($newGrade->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('viewGrade', 'id' => $model->id));
            }
        }

        $examSetGrade = new ExamSetGrade('search');
        $examSetGrade->unsetAttributes();
        $examSetGrade->exam_set_id = $model->id;
        $dataProvider = $examSetGrade->sortBy('order_no')->search();
        $dataProvider->pagination = false;

        $this->render('viewGrade', array(
            'model' => $model,
            'examSetGrade' => $examSetGrade,
            'newGrade' => $newGrade,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdateGrade() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $model = ExamSetGrade::model()->findByPk($pk);
        $model->{$name} = $value;
        if (!$model->save()) {
            throw new CHttpException(500, Helper::errorSummary($model));
        }
    }

    public function actionViewTask($id) {
        $model = ExamSet::model()->findByPk($id);

        $newTask = new ExamSetTask;
        $newTask->exam_set_id = $model->id;
        $data = Yii::app()->request->getPost('ExamSetTask');
        if (isset($data)) {
            $newTask->attributes = $data;
            if ($newTask->create()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('viewTask', 'id' => $model->id));
            }
        }

        /* กรณีมีการบันทึกเฉลยข้อสอบ */
        $data = Yii::app()->request->getPost('answer');
        if (isset($data)) {
            if ($model->saveTaskAnswer($data)) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('viewTask', 'id' => $model->id));
            }
        }

        $tasks = ExamSetTask::model()->findAllByAttributes(array(
            'exam_set_id' => $model->id,
        ));

        $this->render('viewTask', array(
            'model' => $model,
            'newTask' => $newTask,
            'tasks' => $tasks,
        ));
    }

    public function actionTaskDelete($id, $task_no) {
        $model = ExamSetTask::model()->findByAttributes(array(
            'exam_set_id' => $id,
            'task_no' => $task_no,
        ));
        $model->delete();
        $this->redirect(array('viewTask', 'id' => $id));
    }

    public function actionGradeDelete() {
        $id = Yii::app()->request->getQuery('id');
        $model = ExamSetGrade::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('viewTask', 'id' => CHtml::value($id, 'exam_set_id')));
        }
    }

    public function actionDelete($id) {
        $model = ExamSet::model()->findByPk($id);
        $model->delete();
    }

}
