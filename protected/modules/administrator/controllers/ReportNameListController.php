<?php

class ReportNameListController extends AdministratorController {

    public function actions() {
        return array_merge(parent::actions(), array(
            'search' => array(
                'class' => 'SearchExamScheduleAction',
            ),
        ));
    }

    public function actionIndex() {
        $model = new ExamSchedule('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getParam('ExamSchedule');
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $model = ExamSchedule::model()->findByPk(CHtml::value(Yii::app()->request->getQuery('ExamSchedule'), 'id'));
        switch (Yii::app()->request->getQuery('mode')) {
            case 'pdf':
               //$app = $model->validExamApplications;
                $pdf = new PDFMaker;
                $pdf->addPage('nameList', array(
                    'examSchedule' => $model,
                ));
                $pdf->output();
                break;
            case 'xls':
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);

                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();

                $row = 1;
                $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'รายชื่อผู้เข้ารับการทดสอบวัดระดับความรู้ภาษาอังกฤษ');
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::fontBold()));

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'ประเภทการสอบ : ' . CHtml::value($model, 'examType.name'));
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::alignCenter());

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'รอบสอบ : ' . CHtml::value($model, 'exam_code'));
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::alignCenter());

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'สถานที่สอบ : ' . CHtml::value($model, 'place_name'));
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::alignCenter());

                if (count($model->examScheduleItems) <= 1) {
                    $row++;
                    $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                    $sheet->setCellValueByColumnAndRow(0, $row, 'ห้อง : ' . CHtml::value($model, 'place_remark'));
                    $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::alignCenter());
                }

                $lines = explode("\n", CHtml::value($model, 'textSkillWithDate'));
                foreach ($lines as $line) {
                    $row++;
                    $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                    $sheet->setCellValueByColumnAndRow(0, $row, $line);
                    $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::alignCenter());
                }
                $row++;

                $row++;
                $sheet->setCellValueByColumnAndRow(0, $row, 'เลขที่สอบ');
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                $sheet->mergeCellsByColumnAndRow(1, $row, 2, $row);
                $sheet->setCellValueByColumnAndRow(1, $row, 'ชื่อ-นามสกุล');
                $sheet->getStyleByColumnAndRow(1, $row, 2, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                $sheet->setCellValueByColumnAndRow(3, $row, 'กระทรวง');
                $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                $sheet->setCellValueByColumnAndRow(4, $row, 'หน่วยงาน');
                $sheet->getStyleByColumnAndRow(4, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                foreach ($model->examApplications(array('scopes' => array('scopeValid'))) as $data) {
                    $row++;
                    $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'deskNo'));
                    $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));

                    $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($data, 'title_th') . CHtml::value($data, 'firstname_th'));
                    $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray(ExcelStyle::tableCellNoneBorderRight());

                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($data, 'lastname_th'));
                    $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray(ExcelStyle::tableCellNoneBorderLeft());

                    $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($data, 'department_th', '-'));
                    $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(array_merge(ExcelStyle::tableCell()));

                    $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($data, 'office_th', '-'));
                    $sheet->getStyleByColumnAndRow(4, $row)->applyFromArray(array_merge(ExcelStyle::tableCell()));
                }
                foreach (range('B', $sheet->getHighestColumn()) as $columnID) {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }

                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
        }
    }

}
