<?php

class OmrStorageController extends AdministratorController {

    public $layout = '/omrStorage/_layout';

    public function actionIndex() {
        $model = new OmrStorageData('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('OmrStorageData');
        $model->with(array(
            'examSet' => array(
                'together' => true,
            ),
            'examSet.examSubject' => array(
                'together' => true,
            ),
        ));
        $dataProvider = $model->sortBy('examSubject.order_no, t.import_date DESC, t.exam_num')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');

        $criteria = new CDbCriteria();
        $criteria->compare('t.exam_num', '<>0');
        $dataProvider->criteria->mergeWith($criteria);

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionImport() {
        $model = new OmrStorageDataImport('import');
        if (Yii::app()->request->isPostRequest) {
            set_time_limit(0);
            $data = Yii::app()->request->getPost('OmrStorageDataImport');
            $model->attributes = $data;
            if ($model->import()) {
                Yii::app()->user->setFlash('importResult', $model->getResult());
                $this->redirect(array('importComplete', 'ExamApplicationExamSet' => array(
                        'search' => array(
                            'exam_code' => $model->exam_code,
                            'exam_set_id' => $model->exam_set,
                ))));
            }
        }
        $this->render('import', array(
            'model' => $model,
        ));
    }

    public function actionImportComplete() {
        $result = Yii::app()->user->getFlash('importResult', array(), false);
        if (!count($result)) {
            Yii::app()->user->setFlash('success', 'ไม่พบรายการใดๆ จากไฟล์ที่นำเข้า');
            $this->redirect(array('import'));
        }
        $this->render('/omrStorage/importComplete', array(
            'result' => $result,
        ));
    }

    public function actionView() {
        $id = Yii::app()->request->getQuery('id');
        $model = OmrStorageData::model()->findByAttributes(array(
            'exam_set' => CHtml::value($id, 'exam_set'),
            'dvifa_code' => CHtml::value($id, 'dvifa_code'),
            'exam_schedule' => CHtml::value($id, 'exam_schedule'),
            'desk_no' => CHtml::value($id, 'desk_no'),
        ));
        $this->renderPartial('view', array(
            'model' => $model,
        ));
    }

    public function actionDelete() {
        $id = Yii::app()->request->getQuery('id');
        $model = OmrStorageData::model()->findByPk($id);
        $model->delete();
    }

}
