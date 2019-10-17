<?php

class ExamScheduleItemController extends Controller {

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

    public function actionModalViewMap($type = 'th') {
        $model = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('pk'));
        $this->renderPartial('modalViewMap', array(
            'model' => $model,
            'type' => $type,
        ));
    }

}
