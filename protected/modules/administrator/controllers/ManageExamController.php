<?php

class ManageExamController extends AdministratorController {

    public $layout = '/manageExam/_layout';

    public function actionIndex() {
        $examTypes = ExamType::model()->findAll();
        $this->render('index', array(
            'examTypes' => $examTypes,
        ));
    }

    public function actionAjaxUpdateSubject() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');

        $model = ExamSubject::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save();
    }

}
