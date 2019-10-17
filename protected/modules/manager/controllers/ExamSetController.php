<?php

class ExamSetController extends ManagerController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->exam_schedule_id = $this->examSchedule->id;
        $dataProvider = $model->sortBy('desk_no')->search();
        $dataProvider->pagination = false;
        $skillsColumn = array();
        $skills = $this->examSchedule->examScheduleItems;
        foreach ($skills as $skill) {
            $skillsColumn[] = array(
                'header' => CHtml::value($skill, 'examSubject.name'),
                'value' => 'CHtml::value($data,"")',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            );
        }

        $examSet = new ExamSet;
        $examSet->exam_type_id = $this->examSchedule->exam_type_id;

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'skills' => $skills,
            'skillsColumn' => $skillsColumn,
            'examSet' => $examSet,
        ));
    }

    public function actionChangeExamSet() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $exam_subject_id = Yii::app()->request->getPost('exam_subject_id');

        $model = ExamApplicationExamSet::model()->findByAttributes(array(
            'exam_schedule_id' => $this->examSchedule->id,
            'exam_subject_id' => $exam_subject_id,
            'exam_application_id' => $pk,
        ));
        if (isset($model)) {
            $model->{$name} = $value;
            $model->save();
        }
    }

}
