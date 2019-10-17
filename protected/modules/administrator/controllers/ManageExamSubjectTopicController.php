<?php

class ManageExamSubjectTopicController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'ข้อมูลหัวข้อในการสอบ';

    public function actionCreate($exam_subject_id) {
        $model = new ExamSubjectTopic;
        $model->exam_subject_id = $exam_subject_id;
        $data = Yii::app()->request->getPost('ExamSubjectTopic');
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

    public function actionUpdate($exam_subject_id, $exam_topic_code) {
        $model = ExamSubjectTopic::model()->findByAttributes(array(
            'exam_subject_id' => $exam_subject_id,
            'exam_topic_code' => $exam_topic_code,
        ));
        $data = Yii::app()->request->getPost('ExamSubjectTopic');
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

    public function actionDelete($exam_subject_id, $exam_topic_code) {
        $model = ExamSubjectTopic::model()->findByAttributes(array(
            'exam_subject_id' => $exam_subject_id,
            'exam_topic_code' => $exam_topic_code,
        ));
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('manageExam/index'));
        }
    }

}
