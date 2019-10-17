<?php

class OfficeController extends ManagerController {

    public function actionIndex() {
        $model = new ExamScheduleAccount('search');
        $model->unsetAttributes();
        $model->exam_schedule_id = $this->examSchedule->id;
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

}
