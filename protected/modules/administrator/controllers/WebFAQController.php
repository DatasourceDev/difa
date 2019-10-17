<?php

class WebFAQController extends AdministratorController {

    public function actionIndex() {
        $model = new WebFAQ;
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('order_no')->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new WebFAQ;

        $data = Yii::app()->request->getPost('WebFAQ');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = WebFAQ::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebFAQ');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = WebFAQ::model()->findByPk($id);
        if ($model->delete()) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionMoveDown($id) {
        $model = WebFAQ::model()->findByPk($id);
        $model->doMoveDown();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionMoveUp($id) {
        $model = WebFAQ::model()->findByPk($id);
        $model->doMoveUp();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
