<?php

class ManageExamDefaultPrerequisiteSubjectController extends AdministratorController {

    public $layout = '/manageExam/_layout';
    public $title = 'ตั้งค่าผลการสอบที่ต้องผ่านมาก่อน';

    /**
     * Display default prerequisites of subjects.
     * @param int $id ExamSubject ID
     */
    public function actionIndex($id) {
        /* @var $examSubject ExamSubject */
        $examSubject = ExamSubject::model()->findByPk($id);

        $newPrerequisite = new ExamPrerequisite();
        $newPrerequisite->exam_type_id = $examSubject->exam_type_id;
        $newPrerequisite->exam_subject_id = $examSubject->id;
        $data = Yii::app()->request->getPost('ExamPrerequisite');
        if (isset($data)) {
            $newPrerequisite->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $newPrerequisite->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index', 'id' => $examSubject->id));
            }
        }

        $model = new ExamPrerequisite('search');
        $model->unsetAttributes();
        $model->exam_type_id = $examSubject->exam_type_id;
        $model->exam_subject_id = $examSubject->id;
        $dataProvider = $model->search();
        $dataProvider->pagination = false;

        $this->render('index', array(
            'examSubject' => $examSubject,
            'dataProvider' => $dataProvider,
            'newPrerequisite' => $newPrerequisite,
            'model' => $model,
        ));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        $model = ExamPrerequisite::model()->findByPk($id);
        if ($model->delete()) {
            
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
