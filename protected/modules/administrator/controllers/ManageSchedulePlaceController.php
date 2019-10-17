<?php

class ManageSchedulePlaceController extends AdministratorController {

    public $layout = '/manageSchedule/_layout';
    public $title = 'ข้อมูลสถานที่จัดสอบ';

    public function actionIndex() {
        $model = new CodePlace('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new CodePlace;
        $data = Yii::app()->request->getPost('CodePlace');
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
        $model = CodePlace::model()->findByPk($id);
        $data = Yii::app()->request->getPost('CodePlace');
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
        $model = CodePlace::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionView($id, $type = 'th') {
        $model = CodePlace::model()->findByPk($id);
        $this->renderPartial('view', array(
            'model' => $model,
            'map' => $type === 'en' ? $model->placeEnFile->fileUrl : $model->placeFile->fileUrl,
        ));
    }

}
