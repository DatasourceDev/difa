<?php

class ReportExportCertificateFromXlsForm extends CFormModel {

    public $test_date;
    public $excel_file;

    public function rules() {
        return array_merge(parent::rules(), array(
            array('test_date', 'required'),
            array('excel_file', 'file', 'allowEmpty' => true, 'types' => array('xls', 'xlsx')),
        ));
    }

    public function export() {
        if ($this->validate()) {
            require_once Yii::getPathOfAlias('application.vendors.PHPExcel.PHPExcel.Classes') . '/PHPExcel.php';
            $file = CUploadedFile::getInstance($this, 'excel_file');
            if ($file) {
                $objReader = PHPExcel_IOFactory::createReader($file->extensionName === 'xls' ? 'Excel5' : 'Excel2007');
                $objPHPExcel = $objReader->load($file->tempName);
                $sheet = $objPHPExcel->getActiveSheet();

                $rows = $sheet->getRowIterator(2);
                $ret = array();
                foreach ($rows as $row) {
                    /* @var $row PHPExcel_Worksheet_Row */
                    $ret[] = (object) array(
                                'account' => (object) array(
                                    'entryCode' => $sheet->getCellByColumnAndRow(0, $row->getRowIndex()),
                                    'profile' => (object) array(
                                        'fullnameEn' => $sheet->getCellByColumnAndRow(1, $row->getRowIndex()) . ' ' . $sheet->getCellByColumnAndRow(2, $row->getRowIndex()),
                                        'office_name' => $sheet->getCellByColumnAndRow(3, $row->getRowIndex()),
                                    ),
                                ),
                                'examSchedule' => (object) array(
                                    'examScheduleItems' => array(
                                        (object) array(
                                            'examSubject' => (object) array(
                                                'name_en' => 'Reading',
                                                'grade' => $sheet->getCellByColumnAndRow(4, $row->getRowIndex()),
                                            ),
                                        ),
                                        (object) array(
                                            'examSubject' => (object) array(
                                                'name_en' => 'Listening',
                                                'grade' => $sheet->getCellByColumnAndRow(5, $row->getRowIndex()),
                                            ),
                                        ),
                                    ),
                                    'db_date' => $this->test_date,
                                ),
                    );
                }
                $pdf = new PDFMaker();
                foreach ($ret as $page) {
                    $pdf->addPageTestResultReplyFront($page);
                    $pdf->addPageTestResultBackETRL($page);
                }
                $pdf->output();
            }
        }
    }

}
