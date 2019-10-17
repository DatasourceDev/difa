<?php

class ManageScheduleObjectiveController extends AdministratorController {

    /**
     * 
     * @param int $id ExamSchedule ID
     */
    public function actionCreate($id) {
        $examSchedule = ExamSchedule::model()->findByPk($id);

        $model = new ExamScheduleObjective();
        $model->exam_schedule_id = $examSchedule->id;
        $data = Yii::app()->request->getPost('ExamScheduleObjective');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array('manageSchedule/viewObjective', 'id' => $examSchedule->id));
            }
        }
        $this->render('form', array(
            'examSchedule' => $examSchedule,
            'model' => $model,
        ));
    }

    /**
     * แก้ไขวัตถุประสงค์
     */
    public function actionUpdate() {
        $model = ExamScheduleObjective::model()->findByPk(Yii::app()->request->getQuery('id'));
        $examSchedule = $model->examSchedule;

        $data = Yii::app()->request->getPost('ExamScheduleObjective');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array('manageSchedule/viewObjective', 'id' => $examSchedule->id));
            }
        }
        $this->render('form', array(
            'examSchedule' => $examSchedule,
            'model' => $model,
        ));
    }

    /**
     * ลบวัตถุประสงค์
     */
    public function actionDelete() {
        $model = ExamScheduleObjective::model()->findByPk(Yii::app()->request->getQuery('id'));
        if (isset($model)) {
            $model->delete();
            if (!Yii::app()->request->isAjaxRequest) {
                $this->redirect(array('manageSchedule/viewObjective', 'id' => $model->exam_schedule_id));
            }
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('manageSchedule/index'));
        }
    }

    /**
     * คืนค่าวัตถุประสงค์ของการสอบ เป็นค่าเริ่มต้น
     * @param int $id ExamSchedule ID
     */
    public function actionRestore($id) {
        $model = ExamSchedule::model()->findByPk($id);
        $model->restoreObjective();
        $this->redirect(array('manageSchedule/viewObjective', 'id' => $model->id));
    }

}
