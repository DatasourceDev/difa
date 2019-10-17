<?php

class IncomeController extends AdministratorController {

    public $title = 'ระบบบันทึกรายรับ';

    public function actionIndex() {
        $model = new Income('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Income');
        $dataProvider = $model->sortBy('income_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $newModel = new Income;
        $data = Yii::app()->request->getPost('Income');
        if (isset($data)) {
            $newModel->attributes = $data;
            if ($newModel->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'newModel' => $newModel,
        ));
    }

    public function actionUpdate($id) {
        $model = Income::model()->findByPk($id);
        $data = Yii::app()->request->getPost('Income');
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
        $model = Income::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
