<?php

class ManageScheduleItemController extends AdministratorController {

    /**
     * 
     * @param int $id ExamSchedule ID
     */
    public function actionCreate($id) {
        $examSchedule = ExamSchedule::model()->findByPk($id);

        $model = new ExamScheduleItem();
        $model->exam_schedule_id = $examSchedule->id;
        $model->db_date = $examSchedule->db_date;
        $model->time_start = '09:00';
        $model->time_end = '12:00';
        $model->code_place_id = $examSchedule->code_place_id;
        $model->place_name = $examSchedule->place_name;
        $model->place_remark = $examSchedule->place_remark;
        $data = Yii::app()->request->getPost('ExamScheduleItem');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array('manageSchedule/viewExamset', 'id' => $examSchedule->id));
            }
        }
        $this->render('form', array(
            'examSchedule' => $examSchedule,
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        $model = ExamScheduleItem::model()->findByAttributes(Yii::app()->request->getQuery('id'));
        $examSchedule = $model->examSchedule;

        $data = Yii::app()->request->getPost('ExamScheduleItem');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array('manageSchedule/viewExamSet', 'id' => $examSchedule->id));
            }
        }
        $this->render('form', array(
            'examSchedule' => $examSchedule,
            'model' => $model,
        ));
    }

    public function actionDelete() {
        $model = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('id'));
        if (isset($model)) {
            $model->delete();
            if (!Yii::app()->request->isAjaxRequest) {
                $this->redirect(array('manageSchedule/viewExamSet', 'id' => $model->exam_schedule_id));
            }
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('manageSchedule/index'));
        }
    }

    public function actionRefresh($id) {
        
    }

}
