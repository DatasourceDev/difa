<?php

class ExamScheduleItemController extends AdministratorController {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array(
                    'modalViewMap',
                ),
            ),
                ), parent::accessRules());
    }

    public function actionModalViewMap() {
        $model = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('pk'));
        $this->renderPartial('modalViewMap', array(
            'model' => $model,
        ));
    }

}
