<?php

class ReportNameListByObjectiveController extends AdministratorController {

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
        $id = CHtml::value(Yii::app()->request->getQuery('ExamSchedule'), 'id');
        $model = ExamSchedule::model()->findByPk($id);
        switch (Yii::app()->request->getQuery('mode')) {
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

                foreach ($model->examScheduleObjectives as $object) {
                    $applications = ExamApplication::model()->scopeValid()->sortBy('desk_no')->findAllByAttributes(array(
                        'exam_schedule_objective_id' => $object->id,
                        'exam_schedule_id' => $model->id,
                    ));
                    if (count($applications)) {
                        $row++;
                        $sheet->mergeCellsByColumnAndRow(0, $row, 4, $row);
                        $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($object, 'name_th'));
                        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::fontBold()));

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
                        foreach ($applications as $data) {
                            $row++;
                            $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'deskNo'));
                            $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                            $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($data, 'title_th') . CHtml::value($data, 'firstname_th'));
                            $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray(ExcelStyle::tableCell());
                            $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($data, 'lastname_th'));
                            $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray(ExcelStyle::tableCell());
                            $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($data, 'department_th', '-'));
                            $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                            $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($data, 'office_th', '-'));
                            $sheet->getStyleByColumnAndRow(4, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
                        }
                        $row++;
                    }
                }

                foreach (range('B', $sheet->getHighestColumn()) as $columnID) {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }

                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            case 'doc':
                Yii::import('ext.php-word.vendor.PhpWord.PhpWord', true);
                Yii::setPathOfAlias('PhpOffice', Yii::getPathOfAlias('ext.php-word.vendor'));
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getPathOfAlias('application.data.template.docx') . '/name_objective.docx');
                $templateProcessor->setValue('examType', htmlspecialchars(CHtml::value($model, 'examType.name'), ENT_COMPAT, 'UTF-8'));
                $templateProcessor->setValue('examCode', htmlspecialchars(CHtml::value($model, 'exam_code'), ENT_COMPAT, 'UTF-8'));
                $templateProcessor->setValue('place', htmlspecialchars(CHtml::value($model, 'codePlace.name'), ENT_COMPAT, 'UTF-8'));
                $templateProcessor->setValue('skill', htmlspecialchars(CHtml::value($model, 'textSkillWithPrefix'), ENT_COMPAT, 'UTF-8'));

                $criteria = new CDbCriteria();
                $criteria->compare('t.exam_schedule_id', $model->id);
                $criteria->group = 'exam_schedule_objective_id';
                $objectives = ExamApplication::model()->findAll($criteria);

                if (count($objectives)) {
                    $templateProcessor->cloneBlock('block', 1);
/*
                    foreach ($objectives as $countObjective => $objective) {
                        $templateProcessor->setValue('objective#' . ($countObjective + 1), htmlspecialchars(CHtml::value($objective, 'textObjective'), ENT_COMPAT, 'UTF-8'));

                        
                        $criteria = new CDbCriteria();
                        $criteria->compare('t.exam_schedule_id', $model->id);
                        $criteria->compare('t.exam_schedule_objective_id', $objective->exam_schedule_objective_id);
                        $applications = ExamApplication::model()->scopeValid()->findAll($criteria);
                        foreach ($applications as $countApplication => $application) {
                            $templateProcessor->setValue('deskNo#' . ($countApplication + 1), htmlspecialchars(CHtml::value($application, 'deskNumber'), ENT_COMPAT, 'UTF-8'));
                            $templateProcessor->setValue('fullname#' . ($countApplication + 1), htmlspecialchars(CHtml::value($application, 'fullname_th'), ENT_COMPAT, 'UTF-8'));
                            $templateProcessor->setValue('department#' . ($countApplication + 1), htmlspecialchars(CHtml::value($application, 'department'), ENT_COMPAT, 'UTF-8'));
                        }
                        break;
                    }*/
                   
                }
                Yii::app()->request->sendFile(time() . '.docx', file_get_contents($templateProcessor->save()));
                break;
            default:
                $pdf = new PDFMaker;
                $pdf->addPage('nameListByObjective', array(
                    'examSchedule' => $model,
                ));
                $pdf->output();
                break;
        }
    }

}
