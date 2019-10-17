<?php

class ApplicationController extends ManagerController {

    public function actionIndex() {
        $applicationData = array();
        $applications = ExamApplication::model()->findAllByAttributes(array(
            'exam_schedule_id' => $this->examSchedule->id,
        ));
        foreach ($applications as $application) {
            $applicationData[$application->desk_no] = $application;
        }

        $this->render('index', array(
            'applicationData' => $applicationData,
        ));
    }

}
