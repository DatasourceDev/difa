<?php

class ExamProcessBorderLineController extends AdministratorController {

    public $layout = '/examProcess/_layout';
    public $title = 'รายชื่อผู้ที่มีเกณฑ์คะแนนเท่ากับ Border Line';

    public function actionIndex() {
        $model = new ExamApplicationExamSet('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplicationExamSet');
        $model->is_border_line = ActiveRecord::YES;
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdate() {
        /* @var $model ExamApplicationExamSet */
        $model = ExamApplicationExamSet::model()->findByPk(Yii::app()->request->getQuery('id'));
        if ($model->is_update === ActiveRecord::NO) {
            $model->scenario = 'updateScore';
            $model->score_update = $model->score;
            $model->grade_update = $model->grade;
            $model->update_user_id = Yii::app()->user->id;
        } else {
            $mode = Yii::app()->request->getPost('mode');
            if (isset($mode)) {
                switch ($mode) {
                    case 'approve':
                        if ($model->scoreApprove()) {
                            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                            $this->redirect(array('update', 'id' => $model->primaryKey));
                        }
                        break;
                    case 'disapprove':
                        if ($model->scoreDisapprove()) {
                            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                            $this->redirect(array('update', 'id' => $model->primaryKey));
                        }
                        break;
                }
            }
        }
        $data = Yii::app()->request->getPost('ExamApplicationExamSet');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->markAsUpdate()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('update', 'id' => $model->primaryKey));
            }
        }

        $audit = new ExamApplicationExamSetAudit('search');
        $audit->unsetAttributes();
        $audit->exam_application_id = $model->exam_application_id;
        $audit->exam_schedule_id = $model->exam_schedule_id;
        $audit->exam_set_id = $model->exam_set_id;
        $auditProvider = $audit->sortBy('id DESC')->search();

        $this->render('form', array(
            'model' => $model,
            'auditProvider' => $auditProvider,
        ));
    }

    public function actionDeleteLog() {
        $model = ExamApplicationExamSetAudit::model()->findByPk(Yii::app()->request->getQuery('id'));
        $model->delete();
    }

}
