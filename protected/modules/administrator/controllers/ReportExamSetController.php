<?php

class ReportExamSetController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplicationExamSet('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplicationExamSet');
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $exam_schedule_id = CHtml::value(Yii::app()->request->getQuery('ExamApplicationExamSet'), 'exam_schedule_id');
        $applications = ExamApplication::model()->scopeValid()->findAllByAttributes(array(
            'exam_schedule_id' => $exam_schedule_id,
        ));
        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();
                $row = 1;
                $sheet->setCellValueByColumnAndRow(0, $row, 'เลขที่นั่งสอบ');
                $sheet->setCellValueByColumnAndRow(1, $row, 'รหัสประจำตัว');
                $sheet->setCellValueByColumnAndRow(2, $row, 'ชื่อ-นามสกุล');
                $sheet->setCellValueByColumnAndRow(3, $row, 'ทักษะการอ่าน');
                $sheet->setCellValueByColumnAndRow(4, $row, 'ทักษะการฟัง');
                $sheet->setCellValueByColumnAndRow(5, $row, 'ทักษะการเขียน');
                $sheet->setCellValueByColumnAndRow(6, $row, 'ทักษะการพูด');
                for ($i = 0; $i <= 6; $i++) {
                    $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                }
                $row++;
                foreach ($applications as $application) {
                    $sheet->setCellValueByColumnAndRow(0, $row, str_pad($application->desk_no, 3, "0", STR_PAD_LEFT));
                    $sheet->setCellValueExplicitByColumnAndRow(1, $row, CHtml::value($application, 'account.entry_code'));
                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($application, 'fullnameTh'));
                    $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($application->getExamSetBySubject("R"), "exam_set_id", '-'));
                    $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($application->getExamSetBySubject("L"), "exam_set_id", '-'));
                    $sheet->setCellValueByColumnAndRow(5, $row, CHtml::value($application->getExamSetBySubject("W"), "exam_set_id", '-'));
                    $sheet->setCellValueByColumnAndRow(6, $row, CHtml::value($application->getExamSetBySubject("S"), "exam_set_id", '-'));
                    for ($i = 0; $i <= 6; $i++) {
                        $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(ExcelStyle::tableCell());
                    }
                    $row++;
                }

                // Redirect output to a client’s web browser (Excel2007)
                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            default:
                $pdf = new PDFMaker();
                $pdf->writeHTML($this->renderPartial('print', array(
                            'applications' => $applications,
                                ), true));
                $pdf->output();
                break;
        }
    }

}
