<?php

class ReportPaymentStatusController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->with(array('examSchedule' => array('together' => true)))->scopeValid()->sortBy('t.apply_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                $dataProvider->pagination->pageSize = 1000;

                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();


                $sheet->setCellValueByColumnAndRow(0, 1, 'วันสอบ');
                $sheet->setCellValueByColumnAndRow(1, 1, 'เวลาสอบ');
                $sheet->setCellValueByColumnAndRow(2, 1, 'ประเภทการสอบ');
                $sheet->setCellValueByColumnAndRow(3, 1, 'ทักษะ');
                $sheet->setCellValueByColumnAndRow(4, 1, 'เลขที่สอบ');
                $sheet->setCellValueByColumnAndRow(5, 1, 'ชื่อ');
                $sheet->setCellValueByColumnAndRow(6, 1, 'นามสกุล');
                $sheet->setCellValueByColumnAndRow(7, 1, 'บัตรประชาชน/รหัสประจำตัว');
                $sheet->setCellValueByColumnAndRow(8, 1, 'ประเภทการสมัคร');
                $sheet->setCellValueByColumnAndRow(9, 1, 'สถานะการชำระเงิน');

                for ($i = 0; $i <= 9; $i++) {
                    $sheet->getStyleByColumnAndRow($i, 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                }

                $iterator = new CDataProviderIterator($dataProvider);
                foreach ($iterator as $row => $data) {
                    $sheet->setCellValueByColumnAndRow(0, $row + 2, Yii::app()->format->formatDate($data->examSchedule->db_date));
                    $sheet->setCellValueByColumnAndRow(1, $row + 2, CHtml::value($data, 'examSchedule.firstExamScheduleItem.textTimeRange'));
                    $sheet->setCellValueByColumnAndRow(2, $row + 2, CHtml::value($data, 'examSchedule.examType.name'));
                    $sheet->setCellValueByColumnAndRow(3, $row + 2, CHtml::value($data, 'examSchedule.textSkillCode'));
                    $sheet->setCellValueExplicitByColumnAndRow(4, $row + 2, CHtml::value($data, 'deskNo'), PHPExcel_Cell_DataType::TYPE_STRING);
                    $sheet->setCellValueByColumnAndRow(5, $row + 2, CHtml::value($data, 'title_th') . CHtml::value($data, 'firstname_th'));
                    $sheet->setCellValueByColumnAndRow(6, $row + 2, CHtml::value($data, 'lastname_th'));
                    $sheet->setCellValueExplicitByColumnAndRow(7, $row + 2, CHtml::value($data, 'account.entry_code'), PHPExcel_Cell_DataType::TYPE_STRING);
                    $sheet->setCellValueByColumnAndRow(8, $row + 2, CHtml::value($data, 'htmlApplyType'));
                    $sheet->setCellValueByColumnAndRow(9, $row + 2, CHtml::value($data, 'textPaymentStatus'));


                    for ($i = 0; $i <= 9; $i++) {
                        if (!in_array($i, array(5, 6))) {
                            $sheet->getStyleByColumnAndRow($i, $row + 2)->applyFromArray(ExcelStyle::alignCenter());
                        }
                        $sheet->getStyleByColumnAndRow($i, $row + 2)->applyFromArray(ExcelStyle::tableCell());
                    }
                }
                foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }

                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            case 'pdf':
                set_time_limit(0);
                ini_set("memory_limit", "1G");
                $dataProvider->pagination = false;
                $pdf = new PDFMaker;
                $pdf->writeHTML($this->renderPartial('print', array(
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                                ), true));
                $pdf->output();
                break;
            default:
                $this->render('index', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                ));
                break;
        }
    }

}
