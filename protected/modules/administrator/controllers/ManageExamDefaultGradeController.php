<?php

class ManageExamDefaultGradeController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'ตั้งค่าการตัดคะแนน';

    /**
     * Display default grade of subjects.
     * @param int $id ExamSubject ID
     */
    public function actionIndex($id) {
        /* @var $examSubject ExamSubject */
        $examSubject = ExamSubject::model()->findByPk($id);

        $newGrade = new ExamDefaultGrade();
        $newGrade->exam_subject_id = $examSubject->id;
        $newGrade->exam_type_id = $examSubject->exam_type_id;
        $data = Yii::app()->request->getPost('ExamDefaultGrade');
        if (isset($data)) {
            $newGrade->attributes = $data;
            if ($newGrade->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index', 'id' => $examSubject->id));
            }
        }

        $model = new ExamDefaultGrade('search');
        $model->unsetAttributes();
        $model->exam_subject_id = $examSubject->id;
        $model->exam_type_id = $examSubject->exam_type_id;
        $dataProvider = $model->sortBy('order_no')->search();
        $dataProvider->pagination = false;

        $this->render('index', array(
            'examSubject' => $examSubject,
            'dataProvider' => $dataProvider,
            'newGrade' => $newGrade,
            'model' => $model,
        ));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        $model = ExamDefaultGrade::model()->findByPk($id);
        $model->delete();
    }

    public function actionUpdate() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $model = ExamDefaultGrade::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save();
    }

}
