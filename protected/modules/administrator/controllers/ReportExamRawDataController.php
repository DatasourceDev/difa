<?php

class ReportExamRawDataController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamSchedule('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamSchedule');
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $id = CHtml::value(Yii::app()->request->getQuery('ExamSchedule'), 'id');
        if (!$id) {
            Yii::app()->user->setFlash('success', 'กรุณาเลือกรอบสอบ');
            $this->redirect(array('index'));
        }
        $schedule = ExamSchedule::model()->findByPk($id);
        $applications = ExamApplication::model()->scopeValid()->sortBy('desk_no')->findAllByAttributes(array(
            'exam_schedule_id' => $id,
        ));
        switch (Yii::app()->request->getQuery('mode')) {
            case 'pdf':
                $pdf = new PDFMaker;
                $pdf->pdf->AddPage('L', '', '', '', '', 5, 5, 5, '', 0, '', '', '', '', '', '', '', '', '', '', 'A4-L');
                $pdf->writeHTML($this->renderPartial('print', array(
                            'schedule' => $schedule,
                            'applications' => $applications,
                                ), true));
                $pdf->output();
                break;
            default:
                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());

                $styleTd = new ExcelStyleHelper();
                $styleTd->td()->textCenter();

                foreach ($schedule->examScheduleItems as $sheetId => $subject) {
                    $excel->addSheet(new PHPExcel_Worksheet($excel, $subject->examSubject->name), $sheetId);
                    $excel->setActiveSheetIndex($sheetId);
                    $sheet = $excel->getActiveSheet();
                    $sheet->setTitle(CHtml::value($subject, 'examSubject.name_en'));


                    $criteria = new CDbCriteria();
                    $criteria->compare('exam_schedule_id', $schedule->id);
                    $criteria->compare('exam_subject_id', $subject->exam_subject_id);
                    $criteria->group = 'exam_set_id';
                    $examSets = ExamApplicationExamSet::model()->findAll($criteria);
                    $currentRow = 1;
                    $row = 1;
                    foreach ($examSets as $coreExamSet) {
                        $sheet->setCellValue('A1', 'ข้อมูลการทำข้อสอบ ' . $schedule->exam_code);
                        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
                        $row++;
                        $row++;
                        $sheet->setCellValueByColumnAndRow(0, $row, 'ลำดับ');
                        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                        $sheet->setCellValueByColumnAndRow(1, $row, 'ชื่อ-นามสกุล');
                        $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                        $sheet->setCellValueByColumnAndRow(2, $row, 'เลขที่นั่งสอบ');
                        $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                        $countItem = 0;
                        $sheet->setCellValueByColumnAndRow(2, $row + 1, $coreExamSet->exam_set_id);
                        $sheet->getStyleByColumnAndRow(2, $row + 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                        foreach ($coreExamSet->examSet->examSetTasks as $task) {
                            switch ($task->exam_question_method_id) {
                                case 1:
                                case 2:
                                case 3:
                                case 4:
                                    $sheet->setCellValueByColumnAndRow($countItem + 3, $row, CHtml::value($task, 'task_no') . '.' . CHtml::value($task, 'examQuestionMethod.name'));
                                    $sheet->mergeCellsByColumnAndRow($countItem + 3, $row, $countItem + 3 + $task->task_num - 1, $row);
                                    $sheet->getStyleByColumnAndRow($countItem + 3, $row, $countItem + 3 + $task->task_num - 1, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                                    for ($i = 0; $i < $task->task_num; $i++) {
                                        $sheet->setCellValueByColumnAndRow($countItem + 3, $row + 1, $countItem + 1);
                                        $sheet->getStyleByColumnAndRow($countItem + 3, $row + 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                                        $countItem++;
                                    }
                                    break;
                                case 5:
                                case 6:
                                    $sheet->setCellValueByColumnAndRow($countItem + 3, $row, CHtml::value($task, 'task_no') . '.' . CHtml::value($task, 'examQuestionMethod.name'));
                                    $sheet->mergeCellsByColumnAndRow($countItem + 3, $row, $countItem + 3 + 1 - 1, $row);
                                    $sheet->getStyleByColumnAndRow($countItem + 3, $row, $countItem + 3 + 1 - 1, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
                                    $sheet->setCellValueByColumnAndRow($countItem + 3, $row + 1, $countItem + 1);
                                    $sheet->getStyleByColumnAndRow($countItem + 3, $row + 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                                    $countItem++;
                                    break;
                            }
                        }
                        $row++;
                        $appCount = 0;
                        foreach ($applications as $rowCount => $application) {
                            /* @var $sheet PHPExcel_Worksheet */

                            $examSet = ExamApplicationExamSet::model()->findByAttributes(array(
                                'exam_application_id' => $application->id,
                                'exam_schedule_id' => $schedule->id,
                                'exam_subject_id' => $subject->exam_subject_id,
                            ));

                            if ($examSet->exam_set_id <> $coreExamSet->exam_set_id) {
                                continue;
                            } else {
                                $appCount++;
                            }

                            $currentRow = ($appCount + $row);
                            $sheet->setCellValueByColumnAndRow(0, $currentRow, $appCount + 1);
                            $sheet->getStyleByColumnAndRow(0, $currentRow)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::tableCell()));
                            $sheet->setCellValueByColumnAndRow(1, $currentRow, CHtml::value($application, 'fullname_th'));
                            $sheet->getStyleByColumnAndRow(1, $currentRow)->applyFromArray(ExcelStyle::tableCell());
                            $sheet->setCellValueByColumnAndRow(2, $currentRow, CHtml::value($application, 'desk_no'));
                            $sheet->getStyleByColumnAndRow(2, $currentRow)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::tableCell()));

                            $countItem = 0;

                            $raw = $examSet->raw_data;
                            foreach ($coreExamSet->examSet->examSetTasks as $task) {

                                switch ($task->exam_question_method_id) {
                                    case 1:
                                    case 2:
                                    case 3:
                                    case 4:
                                        for ($i = 0; $i < $task->task_num; $i++) {
                                            if (strlen($raw) > ($i)) {
                                                $answer = $raw{$i};
                                            } else {
                                                $answer = '-';
                                            }
                                            $sheet->setCellValueByColumnAndRow($countItem + 3, $currentRow, $answer);
                                            $sheet->getStyleByColumnAndRow($countItem + 3, $currentRow)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::tableCell()));
                                            $countItem++;
                                        }
                                        $raw = substr($raw, ($task->task_num));
                                        break;
                                    case 5:
                                        $sheet->setCellValueByColumnAndRow($countItem + 3, $currentRow, (int) ($raw{0} . $raw{1}));
                                        $sheet->getStyleByColumnAndRow($countItem + 3, $currentRow)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::tableCell()));
                                        $countItem++;
                                        $raw = substr($raw, 2);
                                        break;
                                    case 6:
                                        $sheet->setCellValueByColumnAndRow($countItem + 3, $currentRow, $raw{0});
                                        $sheet->getStyleByColumnAndRow($countItem + 3, $currentRow)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::tableCell()));
                                        $countItem++;
                                        $raw = substr($raw, 1);
                                        break;
                                }
                            }
                        }
                        foreach (range('B', 'C') as $columnID) {
                            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                        }
                        $row = $currentRow + 2;
                    }
                }



                // Redirect output to a client’s web browser (Excel2007)
                Helper::sendFile(time() . '.xlsx');

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
        }
    }

}
