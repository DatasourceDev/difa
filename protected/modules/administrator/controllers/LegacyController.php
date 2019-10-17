<?php

Yii::import('application.models.mdb.*');

class LegacyController extends AdministratorController {

    public function actionIndex() {
        $model = new LegacySource('search');
        $model->unsetAttributes();
        $model->status = LegacySource::STATUS_DONE;
        $dataProvider = $model->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdate($id) {
        $model = LegacySource::model()->findByPk($id);
        $data = Yii::app()->request->getPost('LegacySource');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $model = new LegacySource;
        $data = Yii::app()->request->getPost('LegacySource');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->import()) {
                $this->redirect(array('process', 'id' => $model->id));
            }
        }
        $this->render('import', array(
            'model' => $model,
        ));
    }

    public function actionProcess($id) {
        $model = LegacySource::model()->findByPk($id);
        $this->render('process', array(
            'model' => $model,
        ));
    }

    public function actionCheckProgress($id) {
        $model = LegacySource::model()->findByPk($id);
        if ($model->status === LegacySource::STATUS_DONE) {
            echo 'OK';
        } else {
            echo 'PROCESSING';
        }
    }

    public function actionView($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();
        $path = Yii::getPathOfAlias('application.models.mdb');
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionViewApReport($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();

        $core = new MdbNameAPList('search');
        $core->unsetAttributes();
        $core->attributes = Yii::app()->request->getQuery('MdbNameAPList');
        $dataProvider = $core->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');

        $this->render('viewApReport', array(
            'model' => $model,
            'core' => $core,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionViewPtReport($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();

        $core = new MdbNamePTList('search');
        $core->unsetAttributes();
        $core->attributes = Yii::app()->request->getQuery('MdbNamePTList');
        $dataProvider = $core->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');

        $this->render('viewPtReport', array(
            'model' => $model,
            'core' => $core,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionViewTable($id, $table_name) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();

        $tb_name = 'Mdb' . $table_name;

        $tableModel = new $tb_name;
        $tableModel->scenario = 'search';
        $tableModel->unsetAttributes();
        $tableModel->attributes = Yii::app()->request->getQuery($tb_name);
        $dataProvider = $tableModel->search();
        $dataProvider->pagination->pageSize = 30;

        $this->render('viewTable', array(
            'model' => $model,
            'table_name' => $table_name,
            'tableModel' => $tableModel,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionViewRawTable($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();

        $path = Yii::getPathOfAlias('application.models.mdb');

        $tables = array();

        $files = scandir($path);
        foreach ($files as $file) {
            if (substr($file, 0, 3) === 'Mdb') {
                $tables[] = str_replace(array('Mdb', '.php'), array('', ''), $file);
            }
        }

        $this->render('viewRawTable', array(
            'model' => $model,
            'tables' => $tables,
        ));
    }

    public function actionViewSummary($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->loadSource();
    }

    public function actionDone($id) {
        $model = LegacySource::model()->findByPk($id);
        Yii::app()->user->setFlash('success', 'นำเข้าฐานข้อมูล "' . $model->name . '" เรียบร้อย');
        $this->redirect(array('index'));
    }

    public function actionDelete($id) {
        $model = LegacySource::model()->findByPk($id);
        $model->delete();
    }

}
