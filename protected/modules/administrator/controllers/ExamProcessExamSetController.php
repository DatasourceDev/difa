<?php

class ExamProcessExamSetController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplicationExamSet('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplicationExamSet');

        $dataProvider = $model->with(array(
                    'examSubject' => array(
                        'together' => true,
                    ),
                ))->sortBy('examSubject.order_no')->search();

        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');

        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examApplication' => array(
                'together' => true,
            ),
        );
        $criteria->compare('examApplication.is_confirm', ExamApplication::YES);
        $criteria->addCondition('score IS NOT NULL');
        $dataProvider->criteria->mergeWith($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function doApprove($id, $exam_set_id) {
        $model = ExamApplicationExamSet::model()->findByAttributes(array(
            'exam_application_id' => $id,
            'exam_set_id' => $id,
        ));
        $model->doApprove();
    }

    public function actionBulkApprove() {
        $items = Yii::app()->request->getPost('items');
        foreach ($items as $pk) {
            $key = explode(',', $pk);
            $model = ExamApplicationExamSet::model()->findByPk(array(
                'exam_application_id' => $key[0],
                'exam_schedule_id' => $key[1],
                'exam_set_id' => $key[2],
            ));
            $model->doApprove();
        }
    }

    public function actionBulkDisapprove() {
        $items = Yii::app()->request->getPost('items');
        foreach ($items as $pk) {
            $key = explode(',', $pk);
            $model = ExamApplicationExamSet::model()->findByPk(array(
                'exam_application_id' => $key[0],
                'exam_schedule_id' => $key[1],
                'exam_set_id' => $key[2],
            ));
            $model->doDisapprove();
        }
    }

}
