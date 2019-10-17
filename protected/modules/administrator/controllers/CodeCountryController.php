<?php

class CodeCountryController extends AdministratorController {

    public $title = 'จัดการข้อมูลประเทศ/สัญชาติ';

    public function actionIndex() {
        $model = new CodeCountry('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('id')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new CodeCountry;
        $data = Yii::app()->request->getPost('CodeCountry');
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
        $model = CodeCountry::model()->findByPk($id);
        $data = Yii::app()->request->getPost('CodeCountry');
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
        $model = CodeCountry::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionUpdateAjax() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $model = CodeCountry::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save();
    }

}
