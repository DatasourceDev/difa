<?php

class IncomeTypeController extends AdministratorController {

    public $title = 'ประเภทรายรับ';

    public function actionIndex() {
        $model = new IncomeType('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('id')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new IncomeType;
        $data = Yii::app()->request->getPost('IncomeType');
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
        $model = IncomeType::model()->findByPk($id);
        $data = Yii::app()->request->getPost('IncomeType');
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
        $model = IncomeType::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
