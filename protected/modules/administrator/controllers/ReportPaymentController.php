<?php

class ReportPaymentController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->search['payment_date_range'] = date('Y-m-d', strtotime('first day of this month')) . ' - ' . date('Y-m-d');
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $model->is_paid = ExamApplication::YES;
        $dataProvider = $model->scopeValid()->sortBy('payment_date')->search();

        switch (Yii::app()->request->getQuery('mode')) {
            case 'pdf':
                $pdf = new PDFMaker();
                $dataProvider->pagination = false;
                $pdf->writeHTML($this->renderPartial('pdf', array(
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                                ), true));
                $pdf->output();
                break;
            case 'xls':
                $dataProvider->pagination->pageSize = 1000;
                $iterator = new CDataProviderIterator($dataProvider);

                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();


                $sheet->setCellValueByColumnAndRow(0, 1, 'วันที่ชำระเงิน');
                $sheet->setCellValueByColumnAndRow(1, 1, 'วันที่สอบ');
                $sheet->setCellValueByColumnAndRow(2, 1, 'รอบสอบ');
                $sheet->setCellValueByColumnAndRow(3, 1, 'ประเภทการสอบ');
                $sheet->setCellValueByColumnAndRow(4, 1, 'ทักษะ');
                $sheet->setCellValueByColumnAndRow(5, 1, 'วัตถุประสงค์');
                $sheet->setCellValueByColumnAndRow(6, 1, 'เลขที่นั่งสอบ');
                $sheet->setCellValueByColumnAndRow(7, 1, 'ชื่อ-นามสกุล');
                $sheet->setCellValueByColumnAndRow(8, 1, 'หน่วยงาน');
                $sheet->setCellValueByColumnAndRow(9, 1, 'ค่าธรรมเนียม');
                $sheet->setCellValueByColumnAndRow(10, 1, 'เลขที่ใบเสร็จ');

                for ($i = 0; $i <= 10; $i++) {
                    $sheet->getStyleByColumnAndRow($i, 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                }

                $sheet->getStyleByColumnAndRow(6, 1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $styleTd = new ExcelStyleHelper();
                $styleTd->td()->textCenter();

                $currentRow = 2;
                foreach ($iterator as $data) {
                    $sheet->setCellValueByColumnAndRow(0, $currentRow, Yii::app()->format->formatDatetime(CHtml::value($data, "payment_date")));
                    $sheet->setCellValueByColumnAndRow(1, $currentRow, Yii::app()->format->formatDate(CHtml::value($data, "examSchedule.db_date")));
                    $sheet->setCellValueByColumnAndRow(2, $currentRow, CHtml::value($data, "examSchedule.exam_code"));
                    $sheet->setCellValueByColumnAndRow(3, $currentRow, CHtml::value($data, "examSchedule.examType.name"));
                    $sheet->setCellValueByColumnAndRow(4, $currentRow, CHtml::value($data, "examSchedule.textSkillCode"));
                    $sheet->setCellValueByColumnAndRow(5, $currentRow, CHtml::value($data, "examScheduleObjective.name_th"));
                    $sheet->setCellValueByColumnAndRow(6, $currentRow, CHtml::value($data, "deskNo"));
                    $sheet->setCellValueByColumnAndRow(7, $currentRow, CHtml::value($data, "title_th") . CHtml::value($data, "firstname_th") . ' ' . CHtml::value($data, "lastname_th"));
                    $sheet->setCellValueByColumnAndRow(8, $currentRow, CHtml::value($data, "department_th"));
                    $sheet->setCellValueByColumnAndRow(9, $currentRow, CHtml::value($data, "examSchedule.register_fee"));
                    $sheet->setCellValueByColumnAndRow(10, $currentRow, CHtml::value($data, "receipt.doc_name"));

                    for ($i = 0; $i <= 10; $i++) {
                        $sheet->getStyleByColumnAndRow($i, $currentRow)->applyFromArray(ExcelStyle::tableCell());
                    }

                    $sheet->getStyleByColumnAndRow(6, $currentRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $currentRow++;
                }

                for ($i = 'A'; $i <= 'K'; $i++) {
                    $sheet->getColumnDimension($i)->setAutoSize(true);
                }

                // Redirect output to a client’s web browser (Excel2007)
                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
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
