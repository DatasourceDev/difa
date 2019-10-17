<?php

class ExamProcessController extends AdministratorController {

    public $layout = '/examProcess/_layout';

    public function actionIndex() {
        $model = new OmrStorageDataImport('import');
        if (Yii::app()->request->isPostRequest) {
            $data = Yii::app()->request->getPost('OmrStorageDataImport');
            $model->attributes = $data;
            if ($model->import()) {
                Yii::app()->user->setFlash('success', 'นำเข้าข้อมูลเรียบร้อย');
                Yii::app()->user->setFlash('importResult', $model->getResult());
                $this->redirect(array('importComplete', 'ExamApplicationExamSet' => array(
                        'search' => array(
                            'exam_code' => $model->exam_code,
                            'exam_set_id' => $model->exam_set,
                ))));
                /*
                  $this->redirect(array('examProcessExamSet/index', 'ExamApplicationExamSet' => array(
                  'search' => array(
                  'exam_code' => $model->exam_code,
                  'exam_set_id' => $model->exam_set,
                  ),
                  ))); */
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionImport() {
        $this->redirect(array('index'));
    }

    public function actionImportComplete() {
        $result = Yii::app()->user->getFlash('importResult', array(), false);
        if (!count($result)) {
            Yii::app()->user->setFlash('success', 'ไม่พบรายการใดๆ จากไฟล์ที่นำเข้า');
            $this->redirect(array('index'));
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
            'exam_num' => CHtml::value($id, 'exam_num'),
        ));
        $this->renderPartial('view', array(
            'model' => $model,
        ));
    }

    public function actionCheckFileName() {
        $name = pathinfo(Yii::app()->request->getPost('name'), PATHINFO_FILENAME);
        $model = ExamSet::model()->findByPk($name);
        if (isset($model)) {
            echo CJSON::encode(array(
                'result' => true,
                'comment' => '<span class="text-success text-bold"><span class="glyphicon glyphicon-exclamation-sign"></span>  พบชุดข้อสอบที่มีชื่อตรงกัน</span>',
            ));
        } else {
            echo CJSON::encode(array(
                'result' => false,
                'comment' => '<span class="text-danger text-bold"><span class="glyphicon glyphicon-exclamation-sign"></span>  ไม่พบชุดข้อสอบที่มีชื่อตรงกัน</span>',
            ));
        }
    }

}
