<?php

class WebContentController extends Controller {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array(
                    'index',
                    'view',
                ),
            ),
                ), parent::accessRules());
    }

    public function actionIndex() {
        $model = new WebContent;
        $model->unsetAttributes();
        $dataProvider = $model->current()->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($id) {
        $content = WebContent::model()->findByPk($id);
        $this->render('view', array(
            'content' => $content,
        ));
    }

}
