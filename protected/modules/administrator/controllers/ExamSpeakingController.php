<?php

class ExamSpeakingController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamSpeaking('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('id')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new ExamSpeaking;
        $data = Yii::app()->request->getPost('ExamSpeaking');
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
        $model = ExamSpeaking::model()->findByPk($id);
        $data = Yii::app()->request->getPost('ExamSpeaking');
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
        $model = ExamSpeaking::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
