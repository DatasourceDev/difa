<?php

class ExamTypeController extends Controller {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array(
                    'ajaxViewSpecial',
                ),
                'users' => array('*'),
            ),
                ), parent::accessRules());
    }

    public function actionAjaxViewSpecial($id) {
        $model = ExamType::model()->findByPk($id);
        $this->renderPartial('ajaxViewSpecial', array(
            'model' => $model,
        ));
    }

}
