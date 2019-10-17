<?php

require Yii::getPathOfAlias('application.vendors.mpdf60') . '/mpdf.php';
//require Yii::getPathOfAlias('application.vendors.mpdf60') . '/qrcode/qrcode.class.php';
require Yii::getPathOfAlias('application.vendors.phpqrcode') . '/qrlib.php';

class PDFHelper {

    public $pdf;

    public function __construct() {
        $this->pdf = new mPDF;
    }

    public function addPage() {
        $this->pdf->AddPage();
    }

    public function output() {
        $this->pdf->Output();
    }

    public function printCard($model) {
        $this->pdf->SetImportUse();
        $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip.pdf');
        $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 120));
        $this->pdf->SetFont('THSarabun', '', 14);

        /* ชื่อ - นามสกุล ไทย */
        $this->pdf->SetXY(75, 42.5);
        $this->pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameTh'), 0, 0, 'C', true);

        /* ชื่อ - นามสกุล อังกฤษ */
        $this->pdf->SetXY(75, 49);
        $this->pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameEn'), 0, 0, 'C', true);

        /* รหัสประจำตัว */
        $this->pdf->SetXY(110, 61);
        $this->pdf->WriteCell(90, 0, CHtml::value($model, 'account.entry_code'), 0, 0, 'C', true);

        /* วันที่สอบ */
        $this->pdf->SetXY(110, 72);
        $this->pdf->WriteCell(90, 0, date('dmy', strtotime(CHtml::value($model, 'examSchedule.db_date'))), 0, 0, 'C', true);

        /* จำนวนเงิน */
        $this->pdf->SetXY(53, 79);
        $this->pdf->WriteCell(100, 0, Yii::app()->format->formatNumber(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        /* จำนวนเงิน (คำอ่าน) */
        $this->pdf->SetXY(53, 86);
        $this->pdf->WriteCell(100, 0, Helper::number2Text(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        $this->pdf->Image(Yii::app()->createUrl('get/qr', array('code' => $model->desk_code)), 188, 40, 14, 14);
    }

    public static function printPayinSlip($model) {
        $pdf = new mPDF;
        $pdf->SetImportUse();
        $pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip.pdf');
        $pdf->UseTemplate($pdf->ImportPage(1, 0, 0, null, 270));
        $pdf->SetFont('THSarabun', '', 14);

        /* ชื่อ - นามสกุล ไทย */
        $pdf->SetXY(75, 42.5);
        $pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameTh'), 0, 0, 'C', true);

        /* ชื่อ - นามสกุล อังกฤษ */
        $pdf->SetXY(75, 49);
        $pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameEn'), 0, 0, 'C', true);

        /* รหัสประจำตัว */
        $pdf->SetXY(110, 61);
        $pdf->WriteCell(90, 0, CHtml::value($model, 'account.entry_code') . str_pad(CHtml::value($model, 'examSchedule.examType.id'), 2, '0', 0), 0, 0, 'C', true);

        /* วันที่สอบ */
        $pdf->SetXY(110, 72);
        $pdf->WriteCell(90, 0, str_pad(CHtml::value($this, 'id'), 8, '0', STR_PAD_LEFT) . date('dmy', strtotime('+14 days')), 0, 0, 'C', true);

        /* จำนวนเงิน */
        $pdf->SetXY(53, 79);
        $pdf->WriteCell(100, 0, Yii::app()->format->formatNumber(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        /* จำนวนเงิน (คำอ่าน) */
        $pdf->SetXY(53, 86);
        $pdf->WriteCell(100, 0, Helper::number2Text(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        //=============================
        $h = 110;
        /* ชื่อ - นามสกุล ไทย */
        $pdf->SetXY(75, 42.5 + $h);
        $pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameTh'), 0, 0, 'C', true);

        /* ชื่อ - นามสกุล อังกฤษ */
        $pdf->SetXY(75, 49 + $h);
        $pdf->WriteCell(120, 0, CHtml::value($model, 'account.profile.fullnameEn'), 0, 0, 'C', true);

        /* รหัสประจำตัว */
        $pdf->SetXY(110, 61 + $h);
        $pdf->WriteCell(90, 0, CHtml::value($model, 'account.entry_code') . str_pad(CHtml::value($model, 'examSchedule.examType.id'), 2, '0', 0), 0, 0, 'C', true);

        /* วันที่สอบ */
        $pdf->SetXY(110, 72 + $h);
        $pdf->WriteCell(90, 0, str_pad(CHtml::value($this, 'id'), 8, '0', STR_PAD_LEFT) . date('dmy', strtotime('+14 days')), 0, 0, 'C', true);

        /* จำนวนเงิน */
        $pdf->SetXY(53, 79 + $h);
        $pdf->WriteCell(100, 0, Yii::app()->format->formatNumber(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        /* จำนวนเงิน (คำอ่าน) */
        $pdf->SetXY(53, 86 + $h);
        $pdf->WriteCell(100, 0, Helper::number2Text(CHtml::value($model, 'examSchedule.register_fee')), 0, 0, 'C', true);

        /*
          $qr = new QRcode(CHtml::value($model, 'desk_no'));
          $qr->disableBorder();
          $qr->displayFPDF($pdf, 188, 40, 14);
          $qr->displayFPDF($pdf, 188, 40 + $h, 14); */

        $pdf->Image(Yii::app()->createUrl('get/qr', array('code' => $model->desk_code)), 188, 40, 14, 14);
        $pdf->Image(Yii::app()->createUrl('get/qr', array('code' => $model->desk_code)), 188, 40 + $h, 14, 14);
        $pdf->Image(Yii::app()->createUrl('get/barcode', array('code' => str_replace(' ', "\r", $model->payment_code))), 33, 105 + $h, 150, 15);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('THSarabun', '', 14);
        $pdf->SetXY(33, 115 + $h);
        $pdf->WriteCell(150, 6, $model->payment_code, 0, 0, 'C', true);

        $pdf->Output();
    }

}
