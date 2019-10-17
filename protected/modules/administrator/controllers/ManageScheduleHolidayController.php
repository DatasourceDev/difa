<?php

class ManageScheduleHolidayController extends AdministratorController {

    public $layout = '/manageSchedule/_layout';
    public $title = 'วันหยุดนักขัตฤกษ์ / วันหยุดประจำปี';

    public function actionIndex() {
        $model = new CodeHoliday('search');
        $model->unsetAttributes();
        $model->search['year'] = date('Y');
        $model->attributes = Yii::app()->request->getQuery('CodeHoliday');
        $dataProvider = $model->sortBy('id')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new CodeHoliday;
        $data = Yii::app()->request->getPost('CodeHoliday');
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
        $model = CodeHoliday::model()->findByPk($id);
        $data = Yii::app()->request->getPost('CodeHoliday');
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
        $model = CodeHoliday::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

}
