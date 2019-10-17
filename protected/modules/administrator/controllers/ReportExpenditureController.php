<?php

class ReportExpenditureController extends AdministratorController {

    public function actionIndex() {
        $model = new Expenditure('search');
        $model->unsetAttributes();
        $model->search['date_range'] = date('Y-m-d', strtotime('first day of this month')) . ' - ' . date('Y-m-d');
        $model->attributes = Yii::app()->request->getQuery('Expenditure');
        $summary = $model->reportSummary()->find();

        if ($model->expenditure_type_id) {
            $expenditureTypes = array(
                ExpenditureType::model()->findByPk($model->expenditure_type_id),
            );
        } else {
            $expenditureTypes = ExpenditureType::model()->findAll();
        }

        $reportData = array();

        /* Summary By Categories */
        foreach ($expenditureTypes as $expenditureType) {
            $expenditure = new Expenditure;
            $expenditure->attributes = $model->attributes;
            $data = $model->sortBy('t.expenditure_date')->reportSummary()->findByAttributes(array(
                'expenditure_type_id' => $expenditureType->id,
            ));
            $reportData['categories'][$expenditureType->id] = $data;
        }

        /* Summary by Dates */
        $expenditure = new Expenditure;
        $expenditure->attributes = $model->attributes;
        $datas = $model->sortBy('t.expenditure_date')->reportSummary()->reportDaily()->findAll();
        foreach ($datas as $data) {
            $reportData[$data->expenditure_date]['summary'] = $data;
        }

        /* By Categories */
        foreach ($expenditureTypes as $expenditureType) {
            $expenditure = new Expenditure;
            $expenditure->attributes = $model->attributes;
            $datas = $model->sortBy('t.expenditure_date')->reportSummary()->reportDaily()->findAllByAttributes(array(
                'expenditure_type_id' => $expenditureType->id,
            ));
            foreach ($datas as $data) {
                $reportData[$data->expenditure_date][$expenditureType->id] = $data;
            }
        }

        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();

                $row = 1;
                $sheet->mergeCellsByColumnAndRow(0, $row, count($expenditureTypes) + 1, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'รายงานรายจ่าย');
                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, count($expenditureTypes) + 1, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'ตั้งแต่วันที่ ' . Yii::app()->format->formatDateText($model->date_start) . ' ถึง ' . Yii::app()->format->formatDateText($model->date_end));
                $sheet->getStyleByColumnAndRow(0, $row, count($expenditureTypes) + 1, $row)->applyFromArray(ExcelStyle::alignCenter());

                if ($model->expenditure_type_id) {
                    $row++;
                    $sheet->mergeCellsByColumnAndRow(0, $row, count($expenditureTypes) + 1, $row);
                    $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($model, 'expenditureType.name'));
                    $sheet->getStyleByColumnAndRow(0, $row, count($expenditureTypes) + 1, $row)->applyFromArray(ExcelStyle::alignCenter());
                }

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, 0, $row + 1);
                $sheet->setCellValueByColumnAndRow(0, $row, 'วันที่');
                $sheet->getStyleByColumnAndRow(0, $row, 0, $row + 1)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
                if (!$model->expenditure_type_id) {
                    $sheet->mergeCellsByColumnAndRow(1, $row, count($expenditureTypes), $row);
                    $sheet->setCellValueByColumnAndRow(1, $row, 'ประเภทรายจ่าย');
                    $sheet->getStyleByColumnAndRow(1, $row, count($expenditureTypes), $row)->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            ),
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
                }
                $sheet->mergeCellsByColumnAndRow(($model->expenditure_type_id) ? 1 : 1 + count($expenditureTypes), $row, ($model->expenditure_type_id) ? 1 : 1 + count($expenditureTypes), $row + 1);
                $sheet->setCellValueByColumnAndRow(($model->expenditure_type_id) ? 1 : 1 + count($expenditureTypes), $row, 'จำนวนเงินรวม');
                $sheet->getStyleByColumnAndRow(($model->expenditure_type_id) ? 1 : 1 + count($expenditureTypes), $row, ($model->expenditure_type_id) ? 1 : 1 + count($expenditureTypes), $row + 1)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
                $row++;
                if (!($model->expenditure_type_id)) {
                    foreach ($expenditureTypes as $col => $expenditureType) {
                        $sheet->setCellValueByColumnAndRow(1 + $col, $row, CHtml::value($expenditureType, 'name'));
                        $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                ),
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
                    }
                }

                $current_date = $model->date_start;
                while ($current_date <= $model->date_end) {
                    if (isset($reportData[$current_date])) {
                        $row++;
                        $sheet->setCellValueByColumnAndRow(0, $row, Yii::app()->format->formatDate($current_date));
                        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableCell());
                        if (!($model->expenditure_type_id)) {
                            foreach ($expenditureTypes as $col => $expenditureType) {
                                $sheet->setCellValueByColumnAndRow(1 + $col, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.' . $expenditureType->id . '.amount')));
                                $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                            }
                        }
                        $sheet->setCellValueByColumnAndRow(($model->expenditure_type_id) ? 1 : count($expenditureTypes) + 1, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.summary.amount')));
                        $sheet->getStyleByColumnAndRow(($model->expenditure_type_id) ? 1 : count($expenditureTypes) + 1, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                    }
                    $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
                }

                $row++;
                $sheet->setCellValueByColumnAndRow(0, $row, 'รวม');
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                if (!($model->expenditure_type_id)) {
                    foreach ($expenditureTypes as $col => $expenditureType) {
                        $sheet->setCellValueByColumnAndRow(1 + $col, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, 'categories.' . $expenditureType->id . '.amount')));
                        $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    }
                }
                $sheet->setCellValueByColumnAndRow(($model->expenditure_type_id) ? 1 : count($expenditureTypes) + 1, $row, Yii::app()->format->formatMoney(CHtml::value($summary, 'amount')));
                $sheet->getStyleByColumnAndRow(($model->expenditure_type_id) ? 1 : count($expenditureTypes) + 1, $row)->applyFromArray(ExcelStyle::tableHeaderCell());


                foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }

                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            case 'pdf':
                $pdf = new PDFMaker();
                $pdf->writeHTML($this->renderPartial($model->expenditure_type_id ? 'printType' : 'print', array(
                            'model' => $model,
                            'summary' => $summary,
                            'reportData' => $reportData,
                            'expenditureTypes' => $expenditureTypes,
                                ), true));
                $pdf->output();
                break;
            default:
                $this->render('index', array(
                    'model' => $model,
                    'summary' => $summary,
                    'reportData' => $reportData,
                    'expenditureTypes' => $expenditureTypes,
                ));
                break;
        }
    }

    public function actionView() {
        $model = new Expenditure;
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Expenditure');
        $dataProvider = $model->search();
        $dataProvider->pagination = false;

        $criteria = new CDbCriteria();
        $criteria->select = array(
            'SUM(amount) as amount',
        );
        $criteria->compare('expenditure_type_id', CHtml::value($model, 'expenditure_type_id'));
        $criteria->compare('expenditure_date', CHtml::value($model, 'expenditure_date'));
        $summaryModel = new Expenditure;
        $summaryModel->unsetAttributes();
        $summaryModel->attributes = Yii::app()->request->getQuery('Expenditure');
        $summaryModel->dbCriteria->mergeWith($criteria);
        $summary = $summaryModel->find();

        $this->renderPartial('view', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ));
    }

}
