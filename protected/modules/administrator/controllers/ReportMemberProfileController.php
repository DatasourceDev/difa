<?php

class ReportMemberProfileController extends AdministratorController {

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->scopeMember()->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $accounts = Account::model()->findAll($criteria);

        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());

                foreach ($accounts as $sheetCount => $account) {
                    $row = 1;

                    $sheet = $excel->createSheet($sheetCount);
                    $sheet->setCellValueByColumnAndRow(0, $row, 'ประวัติการสอบรายบุคคล');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 6, $row);
                    $row ++;
                    $sheet->setCellValueByColumnAndRow(0, $row, 'เลขบัตรประชาชน/ID');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
                    $sheet->setCellValueExplicitByColumnAndRow(2, $row, CHtml::value($account, 'username'));
                    $sheet->mergeCellsByColumnAndRow(2, $row, 6, $row);
                    $row ++;
                    $sheet->setCellValueByColumnAndRow(0, $row, 'Name');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($account, 'profile.fullnameEn'));
                    $sheet->mergeCellsByColumnAndRow(2, $row, 6, $row);
                    $row ++;
                    $sheet->setCellValueByColumnAndRow(0, $row, 'ชื่อ-นามสกุล');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($account, 'profile.fullnameTh'));
                    $sheet->mergeCellsByColumnAndRow(2, $row, 6, $row);
                    $row ++;
                    $sheet->setCellValueByColumnAndRow(0, $row, 'ประเภทสมาชิก');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($account, 'accountType.name_th'));
                    $sheet->mergeCellsByColumnAndRow(2, $row, 6, $row);
                    $row ++;
                    $sheet->setCellValueByColumnAndRow(0, $row, 'หน่วยงาน');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
                    $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($account, 'profile.textDepartment'));
                    $sheet->mergeCellsByColumnAndRow(2, $row, 6, $row);
                    $row ++;

                    $sheet->setCellValueByColumnAndRow(0, $row, 'วันที่สอบ');
                    $sheet->setCellValueByColumnAndRow(1, $row, 'ประเภทการสอบ');
                    $sheet->setCellValueByColumnAndRow(2, $row, 'หน่วยงาน');
                    $sheet->setCellValueByColumnAndRow(3, $row, 'ผลการสอบ');
                    $sheet->mergeCellsByColumnAndRow(0, $row, 0, $row + 1);
                    $sheet->mergeCellsByColumnAndRow(1, $row, 1, $row + 1);
                    $sheet->mergeCellsByColumnAndRow(2, $row, 2, $row + 1);
                    $sheet->mergeCellsByColumnAndRow(3, $row, 6, $row);
                    for ($i = 0; $i <= 2; $i++) {
                        $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    }
                    $sheet->getStyleByColumnAndRow(3, $row, 6, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    $row++;

                    $sheet->setCellValueByColumnAndRow(3, $row, 'R');
                    $sheet->setCellValueByColumnAndRow(4, $row, 'L');
                    $sheet->setCellValueByColumnAndRow(5, $row, 'W');
                    $sheet->setCellValueByColumnAndRow(6, $row, 'S');
                    for ($i = 3; $i <= 6; $i++) {
                        $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    }
                    $row++;
                    if (count($account->examApplications)) {
                        foreach ($account->examApplications as $application) {
                            $sheet->setCellValueByColumnAndRow(0, $row, Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date')));
                            $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($application, 'examSchedule.examType.name'));
                            $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($application, 'department'));
                            $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($application->getGradeBySubject('R'), 'grade'));
                            $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($application->getGradeBySubject('L'), 'grade'));
                            $sheet->setCellValueByColumnAndRow(5, $row, CHtml::value($application->getGradeBySubject('W'), 'grade'));
                            $sheet->setCellValueByColumnAndRow(6, $row, CHtml::value($application->getGradeBySubject('S'), 'grade'));
                            for ($i = 0; $i <= 6; $i++) {
                                $sheet->getStyleByColumnAndRow($i, $row)->applyFromArray(ExcelStyle::tableCell());
                            }
                            $row++;
                        }
                    } else {
                        $sheet->setCellValueByColumnAndRow(0, $row, '-- ยังไม่เคยสมัครสอบใดๆ --');
                        $sheet->mergeCellsByColumnAndRow(0, $row, 6, $row);
                        $sheet->getStyleByColumnAndRow(0, $row, 6, $row)->applyFromArray(ExcelStyle::tableCell());
                        $row++;
                    }

                    for ($i = 'A'; $i <= 'G'; $i++) {
                        $sheet->getColumnDimension($i)->setAutoSize(true);
                    }
                }

                $excel->setActiveSheetIndex(0);

                // Redirect output to a client’s web browser (Excel2007)
                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            default:
                $pdf = new PDFMaker;
                foreach ($accounts as $account) {
                    $pdf->pdf->AddPage();
                    $pdf->writeHTML($this->renderPartial('print', array(
                                'account' => $account,
                                    ), true));
                }
                $pdf->output();
                break;
        }
    }

}
