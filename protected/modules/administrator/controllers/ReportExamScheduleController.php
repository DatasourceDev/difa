<?php

Yii::import('administrator.controllers.ReportController');

class ReportExamScheduleController extends ReportController {

    public function actionPrintNameList() {
        $model = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('id'));

        $applications = ExamApplication::model()->scopeValid()->findAllByAttributes(array(
            'exam_schedule_id' => $model->exam_schedule_id,
        ));

        $pdf = $this->getPdf();
        if (Yii::app()->request->getQuery('lang') === 'th') {
            Helper::setLaguage('th');
            $pdf->WriteHTML($this->renderPartial('printNameListTh', array(
                        'model' => $model,
                        'applications' => $applications,
                            ), true));
        } else {
            Helper::setLaguage('en');
            $pdf->WriteHTML($this->renderPartial('printNameListEn', array(
                        'model' => $model,
                        'applications' => $applications,
                            ), true));
        }
        $pdf->Output();
    }

    public function actionPrintNameSign() {
        $model = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('id'));

        $applications = ExamApplication::model()->sortBy('t.desk_no')->scopeValid()->findAllByAttributes(array(
            'exam_schedule_id' => $model->exam_schedule_id,
        ));

        $pdf = $this->getPdf();
        if (Yii::app()->request->getQuery('lang') === 'th') {
            Helper::setLaguage('th');
            $pdf->WriteHTML($this->renderPartial('printNameSignTh', array(
                        'model' => $model,
                        'applications' => $applications,
                            ), true));
        } else {
            Helper::setLaguage('en');
            $pdf->WriteHTML($this->renderPartial('printNameSignEn', array(
                        'model' => $model,
                        'applications' => $applications,
                            ), true));
        }
        $pdf->Output();
    }

    public function actionExportNameList() {
        $examScheduleItem = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('id'));
        $model = $examScheduleItem->examSchedule;
        $applications = ExamApplication::model()->scopeValid()->findAllByAttributes(array(
            'exam_schedule_id' => $examScheduleItem->exam_schedule_id,
        ));
        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);

        $excel = new PHPExcel;
        $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
        $sheet = $excel->getActiveSheet();

        $row = 1;
        $sheet->mergeCellsByColumnAndRow(0, $row, 6, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ใบรายชื่อผู้สมัครสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::fontBold()));

        $row++;
        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'รหัสรอบสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($model, 'exam_code'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'วันที่สอบ');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 6, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')));

        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ประเภทการสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($model, 'examType.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'เวลาสอบ');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 6, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, Yii::app()->format->formatTime(CHtml::value($model, 'time_start')) . ' - ' . Yii::app()->format->formatTime(CHtml::value($model, 'time_end')));

        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ทักษะที่สอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($examScheduleItem, 'examSubject.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'สถานที่');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 6, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($model, 'place_name'));

        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'หัวข้อ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($examScheduleItem, 'examSet.examSubjectTopic.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'ชั้นห้อง');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 6, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($model, 'place_remark'));

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
        $sheet->setCellValueByColumnAndRow(5, $row, 'เบอร์โทรศัพท์');
        $sheet->getStyleByColumnAndRow(5, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(6, $row, 'หมายเหตุ');
        $sheet->getStyleByColumnAndRow(6, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        foreach ($model->examApplications(array('scopes' => array('scopeValid'))) as $data) {
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
            $sheet->setCellValueByColumnAndRow(5, $row, CHtml::value($data, 'account.profile.textContactMobile'));
            $sheet->getStyleByColumnAndRow(5, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->getStyleByColumnAndRow(6, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
        }
        foreach (range('B', $sheet->getHighestColumn()) as $columnID) {
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        Helper::sendFile(time() . '.xlsx');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function actionExportNameSign() {
        $examScheduleItem = ExamScheduleItem::model()->findByPk(Yii::app()->request->getQuery('id'));
        $model = $examScheduleItem->examSchedule;
        $applications = ExamApplication::model()->scopeValid()->findAllByAttributes(array(
            'exam_schedule_id' => $examScheduleItem->exam_schedule_id,
        ));

        Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);

        $excel = new PHPExcel;
        $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
        $sheet = $excel->getActiveSheet();

        $row = 1;
        $sheet->mergeCellsByColumnAndRow(0, $row, 8, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ใบเซ็นชื่อผู้สมัครสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::alignCenter(), ExcelStyle::fontBold()));

        $row++;
        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'รหัสรอบสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($model, 'exam_code'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'วันที่สอบ');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 8, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')));


        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ประเภทการสอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($model, 'examType.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'เวลาสอบ');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 8, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, Yii::app()->format->formatTime(CHtml::value($examScheduleItem, 'time_start')) . ' - ' . Yii::app()->format->formatTime(CHtml::value($examScheduleItem, 'time_end')));

        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'ทักษะที่สอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($examScheduleItem, 'examSubject.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'สถานที่');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 8, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($model, 'place_name'));

        $row++;
        $sheet->mergeCellsByColumnAndRow(0, $row, 1, $row);
        $sheet->setCellValueByColumnAndRow(0, $row, 'หัวข้อ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($examScheduleItem, 'examSet.examSubjectTopic.name'));
        $sheet->setCellValueByColumnAndRow(3, $row, 'ชั้นห้อง');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::fontBold());
        $sheet->mergeCellsByColumnAndRow(4, $row, 8, $row);
        $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($model, 'place_remark'));

        $row++;
        $row++;
        $sheet->setCellValueByColumnAndRow(0, $row, 'เลขที่สอบ');
        $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->mergeCellsByColumnAndRow(1, $row, 2, $row);
        $sheet->setCellValueByColumnAndRow(1, $row, 'ชื่อ-นามสกุล');
        $sheet->getStyleByColumnAndRow(1, $row, 2, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(3, $row, 'Ministry');
        $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(4, $row, 'กระทรวง');
        $sheet->getStyleByColumnAndRow(4, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(5, $row, 'Department');
        $sheet->getStyleByColumnAndRow(5, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(6, $row, 'หน่วยงาน');
        $sheet->getStyleByColumnAndRow(6, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(7, $row, 'เบอร์โทรศัพท์');
        $sheet->getStyleByColumnAndRow(7, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        $sheet->setCellValueByColumnAndRow(8, $row, 'ลายมือชื่อ');
        $sheet->getStyleByColumnAndRow(8, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
        foreach ($model->examApplications(array('scopes' => array('scopeValid'))) as $data) {
            $row++;
            $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'deskNo'));
            $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($data, 'title_th') . CHtml::value($data, 'firstname_th'));
            $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray(ExcelStyle::tableCell());
            $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($data, 'lastname_th'));
            $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray(ExcelStyle::tableCell());
            $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($data, 'department', '-'));
            $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(4, $row, CHtml::value($data, 'department_th', '-'));
            $sheet->getStyleByColumnAndRow(4, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(5, $row, CHtml::value($data, 'office', '-'));
            $sheet->getStyleByColumnAndRow(5, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(6, $row, CHtml::value($data, 'office_th', '-'));
            $sheet->getStyleByColumnAndRow(6, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(7, $row, CHtml::value($data, 'account.profile.textContactMobile'));
            $sheet->getStyleByColumnAndRow(7, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->getStyleByColumnAndRow(8, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
        }
        foreach (range('B', $sheet->getHighestColumn()) as $columnID) {
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        Helper::sendFile(time() . '.xlsx');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
    }

}
