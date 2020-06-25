<?php

class ReportBarcodeController extends AdministratorController {

    public function actionIndex($id = null) {
        Yii::app()->qz->deploy();

        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->with(array(
                    'examSchedule' => array(
                        'together' => true,
                    ),
                ))->sortBy('examSchedule.db_date DESC, t.desk_no')->scopeValid()->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        if (Yii::app()->request->isAjaxRequest) {
            $qz = array();
            $options = array(
                'x' => Configuration::getKey('barcode_x', 200),
                'y' => Configuration::getKey('barcode_y', 50),
                'barcode_height' => Configuration::getKey('barcode_height', 60),
                'barcode_text_height' => Configuration::getKey('barcode_text_height', 40),
                'barcode_text_width' => Configuration::getKey('barcode_text_width', 40),
            );

            $ids = Yii::app()->request->getParam('ids', array());
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $application = ExamApplication::model()->findByPk($id);
                    $qz[] = $this->doPrint($application, $options);
                }
            }
            for ($i = 0; $i < Configuration::getKey('barcode_amount', 1); $i++) {
                echo implode("\n", $qz);
            }
        } else {
            $data = Yii::app()->request->getQuery('ExamApplication');
            $this->redirect(array('index', 'ExamApplication' => array(
                    'search' => array(
                    ),
                    'exam_schedule_id' => CHtml::value($data, 'exam_schedule_id'),
            )));
        }
    }

    public function doPrint($application, $options = array()) {
        $x = CHtml::value($options, 'x');
        $y = CHtml::value($options, 'y');
        $b = CHtml::value($options, 'barcode_height', 60);
        $h = CHtml::value($options, 'barcode_text_height', 40);
        $w = CHtml::value($options, 'barcode_text_width', 40);

        if (substr($application->desk_code, 0, 1) === 'F') {
            $x = $x - 22;
            $b = $b - 4;
            if ($x < 0) {
                $x = 0;
            }
        }

        $zpl = '^XA' . "\n";
        $zpl .= '^CW1,E:ANGSANA.FNT^CI28^FS' . "\n";
        $zpl .= '^FO' . $x . ',' . $y . '^BY2,3^BCN,' . $b . ',Y,N,,D^FD' . $application->desk_code . '^FS' . "\n";
        $zpl .= '^FO' . ($x - 20) . ',' . ($y + 100) . '^FB500,1,0,C,0^A0,N,' . $h . ',' . $w . '^FD' . strtoupper(CHtml::value($application, 'account.profile.fullnameEn')) . '^FS' . "\n";
        $zpl .= '^XZ';
        return $zpl;
    }

}
