<?php

class ReportBorderLineController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplicationExamSet('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplicationExamSet');
        $model->is_border_line = ExamApplicationExamSet::YES;
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        switch (Yii::app()->request->getQuery('mode')) {
            case 'print':
                $dataProvider->pagination->pageSize = 1000;

                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
                $sheet = $excel->getActiveSheet();

                $sheet->setCellValueByColumnAndRow(0, 1, 'รอบการสอบ');
                $sheet->setCellValueByColumnAndRow(1, 1, 'วันที่จัดสอบ');
                $sheet->setCellValueByColumnAndRow(2, 1, 'ชุดข้อสอบ');
                $sheet->setCellValueByColumnAndRow(3, 1, 'เลขที่นั่งสอบ');
                $sheet->setCellValueByColumnAndRow(4, 1, 'ชื่อ-นามสกุล');
                $sheet->setCellValueByColumnAndRow(5, 1, 'หน่วยงาน');
                $sheet->setCellValueByColumnAndRow(6, 1, 'คะแนนเดิม');
                $sheet->setCellValueByColumnAndRow(7, 1, 'ระดับเดิม');
                $sheet->setCellValueByColumnAndRow(8, 1, 'คะแนนใหม่');
                $sheet->setCellValueByColumnAndRow(9, 1, 'ระดับใหม่');
                $sheet->setCellValueByColumnAndRow(10, 1, 'ผู้บันทึกคะแนน');

                for ($i = 0; $i <= 10; $i++) {
                    $sheet->getStyleByColumnAndRow($i, 1)->applyFromArray(ExcelStyle::tableHeaderCell());
                }

                $iterator = new CDataProviderIterator($dataProvider);
                foreach ($iterator as $row => $data) {
                    $sheet->setCellValueByColumnAndRow(0, $row + 2, CHtml::value($data, 'examSchedule.exam_code'));
                    $sheet->setCellValueByColumnAndRow(1, $row + 2, Yii::app()->format->formatDate(CHtml::value($data, 'examSchedule.db_date')));
                    $sheet->setCellValueByColumnAndRow(2, $row + 2, CHtml::value($data, 'examSet.id'));
                    $sheet->setCellValueByColumnAndRow(3, $row + 2, CHtml::value($data, 'examApplication.desk_no'));
                    $sheet->setCellValueByColumnAndRow(4, $row + 2, CHtml::value($data, 'examApplication.account.profile.fullname'));
                    $sheet->setCellValueByColumnAndRow(5, $row + 2, CHtml::value($data, 'examApplication.account.profile.textDepartment'));
                    $sheet->setCellValueByColumnAndRow(6, $row + 2, CHtml::value($data, 'scoreBefore'));
                    $sheet->setCellValueByColumnAndRow(7, $row + 2, CHtml::value($data, 'gradeBefore'));
                    $sheet->setCellValueByColumnAndRow(8, $row + 2, CHtml::value($data, 'scoreAfter'));
                    $sheet->setCellValueByColumnAndRow(9, $row + 2, CHtml::value($data, 'gradeAfter'));
                    $sheet->setCellValueByColumnAndRow(10, $row + 2, CHtml::value($data, 'approver.username'));

                    for ($i = 0; $i <= 10; $i++) {
                        $sheet->getStyleByColumnAndRow($i, $row + 2)->applyFromArray(ExcelStyle::tableCell());
                    }
                }
                for ($col = 'A'; $col !== 'L'; $col++) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                $this->xlsOutput($excel);
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
