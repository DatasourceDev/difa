<?php

class ReportTestRequestByOfficeController extends AdministratorController {

    public function actionIndex() {
        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->attributes = Yii::app()->request->getParam('ExamApplication');
        $dataProvider = $application->scopeValid()->sortBy('department, office')->search();
        $dataProvider->pagination = false;

        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                if (!empty($application->search['account_type']) && !empty($application->exam_schedule_id)) {
                    Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                    $excel = new PHPExcel;
                    $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                    $sheet = $excel->getActiveSheet();
                    $sheet->setCellValue('A1', 'ผลการทดสอบวัดระดับความสามารถทางภาษาอังกฤษ สำหรับ ' . CHtml::value(AccountType::model()->findByPk($application->search['account_type']), 'name_th') . ' รอบสอบ ' . CHtml::value($application, 'examSchedule.exam_code'));
                    $sheet->mergeCells('A1:H1');
                    $sheet->mergeCells('A2:A3');
                    $sheet->mergeCells('B2:B3');
                    $sheet->mergeCells('C2:C3');
                    $sheet->mergeCells('D2:D3');
                    $sheet->mergeCells('E2:H2');

                    $sheet->setCellValue('A2', 'เลขที่สอบ');
                    $sheet->setCellValue('B2', 'ชื่อ-สกุล');
                    $sheet->setCellValue('C2', 'ตำแหน่ง');
                    $sheet->setCellValue('D2', 'ปีที่บรรจุ');
                    $sheet->setCellValue('E2', 'ผลการสอบ');

                    $sheet->setCellValue('E3', 'ทักษะการอ่าน');
                    $sheet->setCellValue('F3', 'ทักษะการฟัง');
                    $sheet->setCellValue('G3', 'ทักษะการเขียน');
                    $sheet->setCellValue('H3', 'ทักษะการพูด');

                    $department = null;
                    $office = null;

                    $sheet->getStyleByColumnAndRow(0, 1, 7, 1)->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            ),
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '674073')
                        ),
                        'font' => array(
                            'bold' => true,
                            'color' => array('rgb' => 'FFFFFF'),
                        ),
                    ));
                    for ($i = 0; $i <= 7; $i++) {
                        foreach (array(2, 3) as $r) {
                            $sheet->getStyleByColumnAndRow($i, $r)->applyFromArray(array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    ),
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '428bca')
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                ),
                                'font' => array(
                                    'bold' => true,
                                    'color' => array('rgb' => 'FFFFFF'),
                                ),
                            ));
                        }
                    }
                    $row = 4;
                    foreach ($dataProvider->data as $data) {
                        if (CHtml::value($data, 'department') !== $department) {
                            $sheet->mergeCellsByColumnAndRow(0, $row, 7, $row);
                            $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'department', '(ไม่ระบุหน่วยงาน)'));
                            $sheet->getStyleByColumnAndRow(0, $row, 7, $row)->applyFromArray(array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    ),
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'd9edf7')
                                ),
                                'font' => array(
                                    'bold' => true,
                                ),
                            ));
                            $department = CHtml::value($data, 'department');
                            $row++;
                        }
                        if (CHtml::value($data, 'office') !== $office) {
                            $sheet->mergeCellsByColumnAndRow(0, $row, 7, $row);
                            $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'office', '(ไม่ระบุหน่วยงาน)'));
                            $sheet->getStyleByColumnAndRow(0, $row, 7, $row)->applyFromArray(array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    ),
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'dff0d8')
                                ),
                            ));
                            $office = CHtml::value($data, 'office');
                            $row++;
                        }
                        $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'deskNumber'));
                        $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($data, 'fullname_th'));
                        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($data, 'position'));
                        $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($data, 'work_year'));
                        $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($data->getExamSetBySubject('R'), 'textGradeConfirmed', '-'));
                        $sheet->setCellValueByColumnAndRow(5, $row, CHtml::value($data->getExamSetBySubject('L'), 'textGradeConfirmed', '-'));
                        $sheet->setCellValueByColumnAndRow(6, $row, CHtml::value($data->getExamSetBySubject('W'), 'textGradeConfirmed', '-'));
                        $sheet->setCellValueByColumnAndRow(7, $row, CHtml::value($data->getExamSetBySubject('S'), 'textGradeConfirmed', '-'));

                        for ($i = 0; $i <= 7; $i++) {
                            $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(array(
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    ),
                                ),
                            ));
                            if ($i != 1) {
                                $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(array(
                                    'alignment' => array(
                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                    ),
                                ));
                            }
                        }
                        $row++;
                    }
                    foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                        $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                    }

                    Helper::sendFile(time() . '.xlsx');
                    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                    $objWriter->save('php://output');
                } else {
                    Yii::app()->user->setFlash('success', 'กรุณาเลือกเงื่อนไขการออกรายงานให้ถูกต้อง');
                    $this->redirect(array('index'));
                }
                break;
            default:
                $this->render('index', array(
                    'application' => $application,
                    'dataProvider' => $dataProvider,
                    'showTable' => !empty($application->search['account_type']) && !empty($application->exam_schedule_id),
                ));
                break;
        }
    }

}
