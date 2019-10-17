<?php

class ExpenditureController extends AdministratorController {

    public $title = 'ระบบบันทึกรายจ่าย';

    public function actionIndex() {
        $model = new Expenditure('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Expenditure');
        $dataProvider = $model->sortBy('expenditure_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $newModel = new Expenditure;
        $data = Yii::app()->request->getPost('Expenditure');
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
        $model = Expenditure::model()->findByPk($id);
        $data = Yii::app()->request->getPost('Expenditure');
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
        $model = Expenditure::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
