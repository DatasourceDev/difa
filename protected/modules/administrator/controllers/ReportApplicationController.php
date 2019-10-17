<?php

class ReportApplicationController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getParam('ExamApplication');
        $dataProvider = $model->with(array('examSchedule' => array('together' => true)))->sortBy('examSchedule.db_date DESC, t.desk_no')->scopeValid()->search();
        switch (Yii::app()->request->getQuery('mode')) {
            case 'print':
                $dataProvider->pagination->pageSize = 1000;
                $iterator = new CDataProviderIterator($dataProvider);

                Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);
                $excel = new PHPExcel;
                $sheet = $excel->getActiveSheet();

                $sheet->setCellValueByColumnAndRow(0, 1, 'วันที่สอบ');
                $sheet->setCellValueByColumnAndRow(1, 1, 'รอบสอบ');
                $sheet->setCellValueByColumnAndRow(2, 1, 'ประเภทการสอบ');
                $sheet->setCellValueByColumnAndRow(3, 1, 'ทักษะ');
                $sheet->setCellValueByColumnAndRow(4, 1, 'วัตถุประสงค์');
                $sheet->setCellValueByColumnAndRow(5, 1, 'ชื่อ-นามสกุล');
                $sheet->setCellValueByColumnAndRow(6, 1, 'หน่วยงาน');
                $sheet->setCellValueByColumnAndRow(7, 1, 'ค่าธรรมเนียม');
                $sheet->setCellValueByColumnAndRow(8, 1, 'สถานะการชำระเงิน');

                $styleTd = new ExcelStyleHelper();
                $styleTd->td()->textCenter();

                $currentRow = 2;
                foreach ($iterator as $data) {
                    $sheet->setCellValueByColumnAndRow(0, $currentRow, Yii::app()->format->formatDate(CHtml::value($data, "examSchedule.db_date")));
                    $sheet->setCellValueByColumnAndRow(1, $currentRow, CHtml::value($data, "examSchedule.exam_code"));
                    $sheet->setCellValueByColumnAndRow(2, $currentRow, CHtml::value($data, "examSchedule.examType.name"));
                    $sheet->setCellValueByColumnAndRow(3, $currentRow, CHtml::value($data, "examSchedule.textSkillCode"));
                    $sheet->setCellValueByColumnAndRow(4, $currentRow, CHtml::value($data, "examScheduleObjective.name_th"));
                    $sheet->setCellValueByColumnAndRow(5, $currentRow, CHtml::value($data, "account.profile.fullname"));
                    $sheet->setCellValueByColumnAndRow(6, $currentRow, CHtml::value($data, "account.profile.textDepartment"));
                    $sheet->setCellValueByColumnAndRow(7, $currentRow, CHtml::value($data, "examSchedule.register_fee"));
                    $sheet->setCellValueByColumnAndRow(8, $currentRow, $data->isPaid ? "ชำระเงินเรียบร้อย" : "ยังไม่ได้ชำระเงิน");
                    $currentRow++;
                }

                for ($i = 'A'; $i <= 'I'; $i++) {
                    $sheet->getColumnDimension($i)->setAutoSize(true);
                }

                // Redirect output to a client’s web browser (Excel2007)
                Helper::sendFile(time() . '.xlsx');
                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;
            default:
                $this->render('index', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                ));
        }
    }

}
