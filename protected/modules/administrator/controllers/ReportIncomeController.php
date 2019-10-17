<?php

class ReportIncomeController extends AdministratorController {

    public function actionIndex() {
        $model = new Income('search');
        $model->unsetAttributes();
        $model->search['date_range'] = date('Y-m-d', strtotime('first day of this month')) . ' - ' . date('Y-m-d');
        $model->attributes = Yii::app()->request->getQuery('Income');
        $summary = $model->reportSummary()->find();

        if ($model->income_type_id) {
            $incomeTypes = array(
                IncomeType::model()->findByPk($model->income_type_id),
            );
        } else {
            $incomeTypes = IncomeType::model()->findAll();
        }

        $reportData = array();

        /* Summary By Categories */
        foreach ($incomeTypes as $incomeType) {
            $income = new Income;
            $income->attributes = $model->attributes;
            $data = $model->sortBy('t.income_date')->reportSummary()->findByAttributes(array(
                'income_type_id' => $incomeType->id,
            ));
            $reportData['categories'][$incomeType->id] = $data;
        }

        /* Summary by Dates */
        $income = new Income;
        $income->attributes = $model->attributes;
        $datas = $model->sortBy('t.income_date')->reportSummary()->reportDaily()->findAll();
        foreach ($datas as $data) {
            $reportData[$data->income_date]['summary'] = $data;
        }

        /* By Categories */
        foreach ($incomeTypes as $incomeType) {
            $income = new Income;
            $income->attributes = $model->attributes;
            $datas = $model->sortBy('t.income_date')->reportSummary()->reportDaily()->findAllByAttributes(array(
                'income_type_id' => $incomeType->id,
            ));
            foreach ($datas as $data) {
                $reportData[$data->income_date][$incomeType->id] = $data;
            }
        }

        switch (Yii::app()->request->getQuery('mode')) {
            case 'xls':
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();

                $row = 1;
                $sheet->mergeCellsByColumnAndRow(0, $row, count($incomeTypes) + 1, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'รายงานรายได้');
                $sheet->getStyleByColumnAndRow(0, $row, count($incomeTypes) + 1, $row)->applyFromArray(array_merge(ExcelStyle::fontBold(), ExcelStyle::alignCenter()));

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, count($incomeTypes) + 1, $row);
                $sheet->setCellValueByColumnAndRow(0, $row, 'ตั้งแต่วันที่ ' . Yii::app()->format->formatDateText($model->date_start) . ' ถึง ' . Yii::app()->format->formatDateText($model->date_end));
                $sheet->getStyleByColumnAndRow(0, $row, count($incomeTypes) + 1, $row)->applyFromArray(ExcelStyle::alignCenter());

                if (($model->income_type_id)) {
                    $row++;
                    $sheet->mergeCellsByColumnAndRow(0, $row, count($incomeTypes) + 1, $row);
                    $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($model, 'incomeType.name'));
                    $sheet->getStyleByColumnAndRow(0, $row, count($incomeTypes) + 1, $row)->applyFromArray(ExcelStyle::alignCenter());
                }

                $row++;
                $sheet->mergeCellsByColumnAndRow(0, $row, 0, $row + 1);
                $sheet->setCellValueByColumnAndRow(0, $row, 'วันที่');
                $sheet->getStyleByColumnAndRow(0, $row, 0, $row + 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                if (!($model->income_type_id)) {
                    $sheet->mergeCellsByColumnAndRow(1, $row, count($incomeTypes), $row);
                    $sheet->setCellValueByColumnAndRow(1, $row, 'ประเภทรายรับ');
                    $sheet->getStyleByColumnAndRow(1, $row, count($incomeTypes), $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                }
                $sheet->mergeCellsByColumnAndRow(($model->income_type_id) ? 1 : 1 + count($incomeTypes), $row, ($model->income_type_id) ? 1 : 1 + count($incomeTypes), $row + 1);
                $sheet->setCellValueByColumnAndRow(($model->income_type_id) ? 1 : 1 + count($incomeTypes), $row, 'จำนวนเงินรวม');
                $sheet->getStyleByColumnAndRow(($model->income_type_id) ? 1 : 1 + count($incomeTypes), $row, ($model->income_type_id) ? 1 : 1 + count($incomeTypes), $row + 1)->applyFromArray(ExcelStyle::tableHeaderCell());

                $row++;
                if (!($model->income_type_id)) {
                    foreach ($incomeTypes as $col => $incomeType) {
                        $sheet->setCellValueByColumnAndRow(1 + $col, $row, CHtml::value($incomeType, 'name'));
                        $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    }
                }

                $current_date = $model->date_start;
                while ($current_date <= $model->date_end) {
                    if (isset($reportData[$current_date])) {
                        $row++;
                        $sheet->setCellValueByColumnAndRow(0, $row, Yii::app()->format->formatDate($current_date));
                        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableCell());
                        if (!($model->income_type_id)) {
                            foreach ($incomeTypes as $col => $incomeType) {
                                $sheet->setCellValueByColumnAndRow(1 + $col, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.' . $incomeType->id . '.amount')));
                                $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                            }
                        }
                        $sheet->setCellValueByColumnAndRow(($model->income_type_id) ? 1 : count($incomeTypes) + 1, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.summary.amount')));
                        $sheet->getStyleByColumnAndRow(($model->income_type_id) ? 1 : count($incomeTypes) + 1, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                    }
                    $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
                }

                $row++;
                $sheet->setCellValueByColumnAndRow(0, $row, 'รวม');
                $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                if (!($model->income_type_id)) {
                    foreach ($incomeTypes as $col => $incomeType) {
                        $sheet->setCellValueByColumnAndRow(1 + $col, $row, Yii::app()->format->formatMoney(CHtml::value($reportData, 'categories.' . $incomeType->id . '.amount')));
                        $sheet->getStyleByColumnAndRow(1 + $col, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                    }
                }
                $sheet->setCellValueByColumnAndRow(($model->income_type_id) ? 1 : count($incomeTypes) + 1, $row, Yii::app()->format->formatMoney(CHtml::value($summary, 'amount')));
                $sheet->getStyleByColumnAndRow(($model->income_type_id) ? 1 : count($incomeTypes) + 1, $row)->applyFromArray(ExcelStyle::tableHeaderCell());


                foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }

                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            case 'pdf':
                $pdf = new PDFMaker();
                $pdf->writeHTML($this->renderPartial($model->income_type_id ? 'printType' : 'print', array(
                            'model' => $model,
                            'summary' => $summary,
                            'reportData' => $reportData,
                            'incomeTypes' => $incomeTypes,
                                ), true));
                $pdf->output();
                break;
            default:
                $this->render('index', array(
                    'model' => $model,
                    'summary' => $summary,
                    'reportData' => $reportData,
                    'incomeTypes' => $incomeTypes,
                ));
                break;
        }
    }

    public function actionView() {
        $model = new Income;
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Income');
        $dataProvider = $model->search();
        $dataProvider->pagination = false;

        $criteria = new CDbCriteria();
        $criteria->select = array(
            'SUM(amount) as amount',
        );
        $criteria->compare('income_type_id', CHtml::value($model, 'income_type_id'));
        $criteria->compare('income_date', CHtml::value($model, 'income_date'));
        $summaryModel = new Income;
        $summaryModel->unsetAttributes();
        $summaryModel->attributes = Yii::app()->request->getQuery('Income');
        $summaryModel->dbCriteria->mergeWith($criteria);
        $summary = $summaryModel->find();

        $this->renderPartial('view', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ));
    }

}
