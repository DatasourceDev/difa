<?php



require Yii::getPathOfAlias('application.vendors.mpdf60') . '/mpdf.php';

require Yii::getPathOfAlias('application.vendors.phpqrcode') . '/qrlib.php';



class PDFMaker {



   public $pdf;



   public function __construct($page = null) {

      if ($page) {

         $this->pdf = new mPDF('', 'A4-L');

      } else {

         $this->pdf = new mPDF();

      }

   }



   public function writeHTML($html) {

      $this->pdf->WriteHTML($html);

   }



   public function addPage($view, $params = array()) {

      call_user_func_array(array($this, 'addPage' . ucfirst($view)), $params);

   }



   private function _pageReceipt($receipt) {

      $this->pdf->AddPage('L', '', '', '', '', 5, 5, 5, '', 0, '', '', '', '', '', '', '', '', '', '', 'A5-L');

      $this->pdf->SetImportUse();

      $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/receipt.pdf');

      $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, $this->pdf->h));



      $this->pdf->SetFont('THSarabun', '', 12);

      $this->pdf->SetXY(148, 38);

      $this->pdf->WriteCell(30, 0, '(ค่าทดสอบภาษา)', 0, 0, 'C', true);



      $this->pdf->SetFont('THSarabun', '', 18);



      $this->pdf->SetXY(150, 25);

      $this->pdf->WriteCell(30, 0, CHtml::value($receipt, 'doc_name', ''), 0, 0, 'C', true);



      $this->pdf->SetXY(80, 52);

      $this->pdf->WriteCell(30, 0, date('j', strtotime(CHtml::value($receipt, 'payment_date'))), 0, 0, 'C', true);



      $this->pdf->SetX(122);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->textMonth(date('n', strtotime(CHtml::value($receipt, 'payment_date')))), 0, 0, 'C', true);



      $this->pdf->SetX(167);

      $this->pdf->WriteCell(20, 0, (string) (date('Y', strtotime(CHtml::value($receipt, 'payment_date'))) + 543), 0, 0, 'C', true);



      $this->pdf->SetXY(30, 69);

      $this->pdf->WriteCell(100, 0, CHtml::value($receipt, 'payer_name', '') . ' - ' . CHtml::value($receipt, 'payer_code', ''), 0, 0, 'C', true);



      $this->pdf->SetXY(30, 76);

      $this->pdf->WriteCell(150, 0, 'ค่าธรรมเนียมการสอบภาษาอังกฤษ วันที่ ' . Yii::app()->format->formatDateThai(CHtml::value($receipt, 'examSchedule.db_date')), 0, 0, 'C', true);



      $this->pdf->SetXY(25, 93);

      $this->pdf->WriteCell(40, 0, number_format(CHtml::value($receipt, 'amount', 0)), 0, 0, 'C', true);



      $this->pdf->SetXY(75, 93);

      $this->pdf->WriteCell(20, 0, '-', 0, 0, 'C', true);



      $this->pdf->SetXY(120, 93);

      $this->pdf->WriteCell(70, 0, Helper::number2Text(CHtml::value($receipt, 'amount', 0)) . 'บาทถ้วน', 0, 0, 'C', true);



      $this->pdf->SetXY(119, 116.5);

      $this->pdf->WriteCell(100, 0, CHtml::value($receipt, 'approve_name', ''), 0, 0, 'C', true);

   }



   public function addPageReceipt($receipt) {

      $this->_pageReceipt($receipt);

      $this->pdf->SetXY(170, 15);

      $this->pdf->SetFont('THSarabun', 'B', 22);

      $this->pdf->WriteCell(30, 0, 'ต้นฉบับ', 0, 0, 'C', true);

   }



   public function addPageReceiptCopy($receipt) {

      $this->_pageReceipt($receipt);

      $this->pdf->SetXY(170, 15);

      $this->pdf->SetFont('THSarabun', 'B', 22);

      $this->pdf->WriteCell(30, 0, 'สำเนา', 0, 0, 'C', true);

   }



   public function addPageTestResultBackETRL() {

      $this->pdf->AddPage('L', '', '', '', '', 5, 5, 5, '', 0, '', '', '', '', '', '', '', '', '', '', 'A5-L');

      $this->pdf->SetImportUse();

      $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/CER_ET_R&L.pdf');

      $this->pdf->UseTemplate($this->pdf->ImportPage(2, 0, 0, null, $this->pdf->h));

   }



   public function addPageTestResultReplyFront($application) {

      $this->pdf->AddPage('L', '', '', '', '', 10, 10, 10, '', '', '', '', '', '', '', '', '', '', '', '', 'A5-L');

      //$this->pdf->SetImportUse();

      //$this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/certificate.pdf');

      //$this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, $this->pdf->h));

      $this->pdf->SetFont('THSarabun', '', 18);

      $this->pdf->setY(35);

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/testResultReplyFront', array(

                  'application' => $application,

                      ), true));

   }



   public function addPageTestResultReplyBack($application) {

      if (count($application->currentExamSets) > 2) {

         $this->pdf->AddPage('L', '', '', '', '', 8, 8, 6, 0, 0, '', '', '', '', '', '', '', '', '', '', 'A5-L');

      } else {

         $this->pdf->AddPage('L', '', '', '', '', 8, 8, 8, '', 0, '', '', '', '', '', '', '', '', '', '', 'A5-L');

      }

      //$this->pdf->SetImportUse();

      //$this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/certificate.pdf');

      //$this->pdf->UseTemplate($this->pdf->ImportPage(2, 0, 0, null, $this->pdf->h));

      $this->pdf->SetFont('arial', '', 18);

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/testResultReplyBack', array(

                  'application' => $application,

                      ), true));

   }



   public function addPageExamCard($application) {

      $fill = false;

      if ($application->office_user_id || $application->payment_amount <= 0) {

         $this->pdf->AddPage('L', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A5-L');

         $this->pdf->SetImportUse();

         if (CHtml::value($application, 'examSchedule.examType.code') === "IH") {

            if (CHtml::value($application, 'account.accountType.getIsForeigner')) {

               $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/examcard-ih-en.pdf');

            } else {

               $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/examcard-ih-th.pdf');

            }

         } else {

            $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/examcard-office.pdf');

         }

         $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 80), -10, 0, 220, 80);



         if (CHtml::value($application, 'examSchedule.examType.code') === "IH") {

            $this->pdf->watermarkImg(Yii::getPathOfAlias('webroot.images') . '/logo-watermark.png');

         }



         $this->pdf->SetFont('THSarabun', 'B', 16);



         if (CHtml::value($application, 'examSchedule.examType.code') === "IH") {

            /* Ref 1 */

            $this->pdf->SetXY(30, 34);

            $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', $fill);



            /* Ref 2  */

            $this->pdf->SetXY(115, 34);

            $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', $fill);



            /* ชื่อ - นามสกุล ไทย */

            if (!CHtml::value($application, 'account.isForeign')) {

               $this->pdf->SetXY(50, 49);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_th', ''), 0, 0, 'C', $fill);

               /* ชื่อ - นามสกุล อังกฤษ */

               $this->pdf->SetXY(50, 57);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);

            } else {

               /* ชื่อ - นามสกุล อังกฤษ */

               $this->pdf->SetXY(50, 49);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);

            }



            /* หน่วยงาน */

            $this->pdf->SetXY(40, 64);

            if (CHtml::value($application, 'account.accountType.isDiplomat')) {

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'office', ''), 0, 0, 'L', $fill);

            } else {

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'department', ''), 0, 0, 'L', $fill);

            }

            $this->pdf->SetY(72);

            $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/pageExamCard', array(

                        'application' => $application,

                            ), true));

            $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $application->getDeskCode())), 170, 45, 18, 18);

         } else {

            /* Ref 1 */

            $this->pdf->SetXY(35, 41.5);

            $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', $fill);



            /* Ref 2  */

            $this->pdf->SetXY(135, 41.5);

            $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', $fill);



            /* ชื่อ - นามสกุล ไทย */

            if (!CHtml::value($application, 'account.isForeign')) {

               $this->pdf->SetXY(50, 59);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_th', ''), 0, 0, 'C', $fill);

               /* ชื่อ - นามสกุล อังกฤษ */

               $this->pdf->SetXY(50, 67);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);

            } else {

               /* ชื่อ - นามสกุล อังกฤษ */

               $this->pdf->SetXY(50, 67);

               $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);

            }



            $this->pdf->SetY(82);

            $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/pageExamCard', array(

                        'application' => $application,

                            ), true));

            $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $application->getDeskCode())), 170, 45, 18, 18);

         }

      } else {

         $this->pdf->AddPage('L', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'A5-L');

         $this->pdf->SetImportUse();

         $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip-v2.pdf');

         $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 145));



         $this->pdf->SetFont('THSarabun', 'B', 16);

         $this->pdf->SetXY(50, 29.5);

         $this->pdf->WriteCell(20, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', $fill);



         /* ชื่อ - นามสกุล ไทย */

         $this->pdf->SetXY(75, 56);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'account.profile.fullnameTh', ''), 0, 0, 'C', $fill);



         /* ชื่อ - นามสกุล อังกฤษ */

         $this->pdf->SetXY(75, 64);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'account.profile.fullnameEn', ''), 0, 0, 'C', $fill);



         /* รหัสประจำตัว */

         $this->pdf->SetXY(115, 83);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', $fill);



         /* Ref 2  */

         $this->pdf->SetXY(90, 97);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', $fill);




         $this->pdf->SetFont('THSarabun', 'B', 12);

         /* วันที่สอบ  */

         $this->pdf->SetXY(145, 97.4);
         $this->pdf->WriteCell(30, 0, Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date', '')), 0, 0, 'C', $fill);


         $textTime ='';
         foreach ($application->examSchedule->examScheduleItems as $item) {
            $textTime = $item->textTime;
            break;
         }

         /* เวลาสอบ  */
         $this->pdf->SetXY(171, 97.4);
         $this->pdf->WriteCell(30, 0, ' (' . $textTime . ')', 0, 0, 'C', $fill);


         $this->pdf->SetFont('THSarabun', 'B', 16);




         /* จำนวนเงิน */

         $this->pdf->SetXY(155, 107.5);

         $this->pdf->WriteCell(30, 0, Yii::app()->format->formatMoney(CHtml::value($application, 'payment_amount')), 0, 0, 'C', $fill);



         /* จำนวนเงิน (คำอ่าน) */

         $this->pdf->SetXY(42, 107.5);

         $this->pdf->WriteCell(80, 0, Helper::number2Text(CHtml::value($application, 'payment_amount')) . 'บาทถ้วน', 0, 0, 'C', $fill);



         $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $application->getDeskCode())), 178, 50, 18, 18);



         if (CHtml::value($application, 'account.profile.photoUrl')) {

            $this->pdf->Image(CHtml::value($application, 'account.profile.photoUrl'), 15.5, 41, 43.5, 34);

         }

      }

   }

   public function addRequestResltSlip($application) {
      if ($application->id > 0) {

         $fill = false;

         $this->pdf->AddPage();
         $this->pdf->SetImportUse();
         $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/certificate_slip.pdf');
         $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 290));

         $this->pdf->SetFont('THSarabun', 'B', 16);

         $this->pdf->SetXY(52, 53.5);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'name', ''), 0, 0, 'L', $fill);


         $chars = str_split(CHtml::value($application, 'id_card', ''));
         $idcard = "";
         foreach ($chars as $c) {
            $idcard = $idcard . $c . '   ';
         }

         $this->pdf->SetXY(104, 63.6);
         $this->pdf->WriteCell(0, 0, $idcard, 0, 0, 'L', $fill);

         $this->pdf->SetXY(65, 82);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'request_number', ''), 0, 0, 'L', $fill);

         $amount = CHtml::value($application, 'request_number', '') * 100;

         $this->pdf->SetXY(52, 93);
         $this->pdf->WriteCell(0, 0, strval(number_format($amount,2)), 0, 0, 'L', $fill);

         $bathtext = $this->ThaiBahtConversion($amount);

         $this->pdf->SetXY(52, 103);
         $this->pdf->WriteCell(0, 0, $bathtext, 0, 0, 'L', $fill);

         $this->pdf->SetXY(96, 116.5);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'tel', ''), 0, 0, 'L', $fill);

         /* Section 2 */


         $this->pdf->SetXY(52, 194.6);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'name', ''), 0, 0, 'L', $fill);

         $this->pdf->SetXY(104, 204.5);
         $this->pdf->WriteCell(0, 0, $idcard, 0, 0, 'L', $fill);

         $this->pdf->SetXY(65, 223);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'request_number', ''), 0, 0, 'L', $fill);

         $amount = CHtml::value($application, 'request_number', '') * 100;

         $this->pdf->SetXY(52, 234);
         $this->pdf->WriteCell(0, 0, strval(number_format($amount,2)), 0, 0, 'L', $fill);

         $bathtext = $this->ThaiBahtConversion($amount);

         $this->pdf->SetXY(52, 244);
         $this->pdf->WriteCell(0, 0, $bathtext, 0, 0, 'L', $fill);

         $this->pdf->SetXY(96, 257.6);
         $this->pdf->WriteCell(0, 0, CHtml::value($application, 'tel', ''), 0, 0, 'L', $fill);

      }

   }

   public function addRequestResltTmpSlip() {

      $fill = false;

      $this->pdf->AddPage();
      $this->pdf->SetImportUse();
      $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/certificate_slip.pdf');
      $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 290));

   }

   public function addPagePaymentSlip($application) {



      if ($application->payment_amount > 0) {

         $fill = false;
         $this->pdf->AddPage();

         $this->pdf->SetImportUse();

         $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip-v2.pdf');

         $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 290));



         $this->pdf->SetFont('THSarabun', 'B', 16);

         $this->pdf->SetXY(50, 29.5);

         $this->pdf->WriteCell(20, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', $fill);



         /* ชื่อ - นามสกุล ไทย */

         $this->pdf->SetXY(75, 56);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_th', ''), 0, 0, 'C', $fill);



         /* ชื่อ - นามสกุล อังกฤษ */

         $this->pdf->SetXY(75, 64);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);



         /* รหัสประจำตัว */

         $this->pdf->SetXY(115, 84.5);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', $fill);



         /* Ref 2  */

         $this->pdf->SetXY(90, 97);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', $fill);



         $this->pdf->SetFont('THSarabun', 'B', 12);


         /* วันที่สอบ  */
          $textDate =Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date', ''));
          $textTime ='';
           foreach ($application->examSchedule->examScheduleItems as $item) {
            $textTime = $item->textTime;
            break;
         }

         $textTime =  ' (' .  $textTime . ')';


         $this->pdf->SetXY(160, 97.4);
         $this->pdf->WriteCell(30, 0, $textDate  . $textTime, 0, 0, 'C', $fill);
        
        
         ///* เวลาสอบ  */
         //$this->pdf->SetXY(171, 97.4);
         //$this->pdf->WriteCell(30, 0, ' (' .  $textTime . ')', 0, 0, 'C', $fill);


         $this->pdf->SetFont('THSarabun', 'B', 16);





         /* จำนวนเงิน */

         $this->pdf->SetXY(155, 107.5);

         $this->pdf->WriteCell(30, 0, Yii::app()->format->formatMoney(CHtml::value($application, 'payment_amount')), 0, 0, 'C', $fill);



         /* จำนวนเงิน (คำอ่าน) */

         $this->pdf->SetXY(42, 107.5);

         $this->pdf->WriteCell(80, 0, Helper::number2Text(CHtml::value($application, 'payment_amount')) . 'บาทถ้วน', 0, 0, 'C', $fill);



         //=============================

         $h = 136;



         $this->pdf->SetXY(50, 29.5 + $h);
         $this->pdf->WriteCell(20, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', $fill);


         /* ชื่อ - นามสกุล ไทย */

         $this->pdf->SetXY(75, 47 + $h);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_th', ''), 0, 0, 'C', $fill);



         /* ชื่อ - นามสกุล อังกฤษ */

         $this->pdf->SetXY(75, 55 + $h);

         $this->pdf->WriteCell(120, 0, CHtml::value($application, 'fullname_en', ''), 0, 0, 'C', $fill);



         /* รหัสประจำตัว */

         $this->pdf->SetXY(115, 75 + $h);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', $fill);



         /* Ref2 */

         $this->pdf->SetXY(90, 88.2 + $h);

         $this->pdf->WriteCell(40, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', $fill);



         /* วันที่สอบ  */
         $this->pdf->SetFont('THSarabun', 'B', 12);

          $textDate =Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date', ''));
          $textTime ='';
           foreach ($application->examSchedule->examScheduleItems as $item) {
            $textTime = $item->textTime;
            break;
         }

         $textTime =  ' (' .  $textTime . ')';


         $this->pdf->SetXY(160, 88.7+ $h);
         $this->pdf->WriteCell(30, 0, $textDate  . $textTime, 0, 0, 'C', $fill);

         ///* เวลาสอบ  */
         //$this->pdf->SetXY(171, 88.7+ $h);
         //$this->pdf->WriteCell(30, 0, ' (' .  $textTime . ')', 0, 0, 'C', $fill);


         $this->pdf->SetFont('THSarabun', 'B', 16);

         /* จำนวนเงิน */

         $this->pdf->SetXY(155, 99.5 + $h);

         $this->pdf->WriteCell(30, 0, Yii::app()->format->formatMoney(CHtml::value($application, 'payment_amount')), 0, 0, 'C', $fill);



         /* จำนวนเงิน (คำอ่าน) */

         $this->pdf->SetXY(42, 99.5 + $h);

         $this->pdf->WriteCell(80, 0, Helper::number2Text(CHtml::value($application, 'payment_amount')) . 'บาทถ้วน', 0, 0, 'C', $fill);



         /* วันที่สอบ  */

         $this->pdf->SetFont('THSarabun', 'B', 14);

         $this->pdf->SetXY(71, 127 + $h);

         $this->pdf->WriteCell(30, 0, Yii::app()->format->formatDate(CHtml::value($application, 'due_date', '')), 0, 0, 'L', $fill);



         $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $application->getDeskCode())), 178, 50, 18, 18);

         $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $application->getDeskCode())), 178, 41 + $h, 18, 18);



         $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getBarcode', array('code' => str_replace(' ', "\r", $application->getPaymentCode()))), 100, 126.5 + $h, 100, 15);



         $this->pdf->SetFillColor(255, 255, 255);

         $this->pdf->SetFont('THSarabun', '', 14);

         $this->pdf->SetXY(100, 136.5 + $h);

         $this->pdf->WriteCell(100, 6, $application->getPaymentCode(), 0, 0, 'C', true);



         if (CHtml::value($application, 'account.profile.photoUrl')) {

            $this->pdf->Image(CHtml::value($application, 'account.profile.photoUrl'), 15.5, 41, 43.5, 34);

         }

      } else {

         $this->addPageExamCard($application);

      }

   }



   public function addPagePaymentOffice($schedule, $scheduleAccount) {

      $fill = false;

      $this->pdf->AddPage();

      $this->pdf->SetImportUse();

      $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip-v2-office.pdf');

      $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 290));

      //        $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 145, null, 270));

      $h = 13;

      $this->pdf->SetXY(0, 0);

      $this->pdf->SetFillColor(255, 255, 255);

      $this->pdf->WriteCell(270, 5, '', 0, 0, 'C', true);

      $this->pdf->SetFont('THSarabun', 'B', 18);



      $this->pdf->SetXY(50, 29.5);

      $this->pdf->WriteCell(20, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', $fill);


      $this->pdf->SetFont('THSarabun', 'B', 14);
      /* ชื่อ - นามสกุล ไทย */

      $this->pdf->SetXY(75, 56);

      $this->pdf->WriteCell(120, 0, CHtml::value($scheduleAccount, 'officeDepartment.name_th', CHtml::value($scheduleAccount, 'office_department_name', '')), 0, 0, 'C', $fill);



      /* ชื่อ - นามสกุล อังกฤษ */

      $this->pdf->SetXY(75, 64);

      $this->pdf->WriteCell(120, 0, CHtml::value($scheduleAccount, 'officeDepartment.name_en', CHtml::value($scheduleAccount, 'office_department_name', '')), 0, 0, 'C', $fill);


      $this->pdf->SetFont('THSarabun', 'B', 18);
      /* Ref1 */

      $this->pdf->SetXY(115, 70 + $h);

      $this->pdf->WriteCell(40, 0, CHtml::value($scheduleAccount, 'ref1', ''), 0, 0, 'C', $fill);



      /* Ref2 */

      $this->pdf->SetXY(90, 97);

      $this->pdf->WriteCell(40, 0, CHtml::value($scheduleAccount, 'ref2', ''), 0, 0, 'C', $fill);



      /* วันที่สอบ  */

      $this->pdf->SetXY(155, 97);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->formatDate(CHtml::value($schedule, 'db_date', '')), 0, 0, 'C', $fill);



      /* จำนวนเงิน */

      $this->pdf->SetXY(155, 107.5);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->formatMoney(CHtml::value($scheduleAccount, 'paymentAmount')), 0, 0, 'C', $fill);



      /* จำนวนเงิน (คำอ่าน) */

      $this->pdf->SetXY(42, 107.5);

      $this->pdf->WriteCell(80, 0, Helper::number2Text(CHtml::value($scheduleAccount, 'paymentAmount')) . 'บาทถ้วน', 0, 0, 'C', $fill);



      $h = 136;

      $this->pdf->SetXY(0, 0);

      $this->pdf->SetFillColor(255, 255, 255);

      $this->pdf->WriteCell(270, 5, '', 0, 0, 'C', true);

      $this->pdf->SetFont('THSarabun', 'B', 18);



      $this->pdf->SetXY(50, 29.5 + $h);

      $this->pdf->WriteCell(20, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', $fill);

      $this->pdf->SetFont('THSarabun', 'B', 14);

      /* ชื่อ - นามสกุล ไทย */

      $this->pdf->SetXY(75, 47 + $h);

      $this->pdf->WriteCell(120, 0, CHtml::value($scheduleAccount, 'officeDepartment.name_th', CHtml::value($scheduleAccount, 'office_department_name', '')), 0, 0, 'C', $fill);



      /* ชื่อ - นามสกุล อังกฤษ */

      $this->pdf->SetXY(75, 55 + $h);

      $this->pdf->WriteCell(120, 0, CHtml::value($scheduleAccount, 'officeDepartment.name_en', CHtml::value($scheduleAccount, 'office_department_name', '')), 0, 0, 'C', $fill);

      $this->pdf->SetFont('THSarabun', 'B', 18);

      /* Ref1 */

      $this->pdf->SetXY(115, 75 + $h);

      $this->pdf->WriteCell(40, 0, CHtml::value($scheduleAccount, 'ref1', ''), 0, 0, 'C', $fill);



      /* Ref2 */

      $this->pdf->SetXY(90, 88.2 + $h);

      $this->pdf->WriteCell(40, 0, CHtml::value($scheduleAccount, 'ref2', ''), 0, 0, 'C', $fill);



      /* วันที่สอบ  */

      $this->pdf->SetXY(155, 88.2 + $h);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->formatDate(CHtml::value($schedule, 'db_date', '')), 0, 0, 'C', $fill);



      /* จำนวนเงิน */

      $this->pdf->SetXY(155, 99.5 + $h);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->formatMoney(CHtml::value($scheduleAccount, 'paymentAmount')), 0, 0, 'C', $fill);



      /* จำนวนเงิน (คำอ่าน) */

      $this->pdf->SetXY(42, 99.5 + $h);

      $this->pdf->WriteCell(80, 0, Helper::number2Text(CHtml::value($scheduleAccount, 'paymentAmount')) . 'บาทถ้วน', 0, 0, 'C', $fill);



      /* วันที่สอบ  */

      $this->pdf->SetFont('THSarabun', 'B', 14);

      $this->pdf->SetXY(71, 127 + $h);

      $this->pdf->WriteCell(30, 0, Yii::app()->format->formatDate(CHtml::value($scheduleAccount, 'due_date', '')), 0, 0, 'L', $fill);



      //$this->pdf->Image(Yii::app()->createAbsoluteUrl('/getQr', array('code' => $scheduleAccount->getDeskCode())), 178, 40 + $h, 18, 18);

      $this->pdf->Image(Yii::app()->createAbsoluteUrl('/getBarcode', array('code' => str_replace(' ', "\r", $scheduleAccount->getPaymentCode()))), 100, 126.5 + $h, 100, 15);



      $this->pdf->SetFillColor(255, 255, 255);

      $this->pdf->SetFont('THSarabun', '', 14);

      $this->pdf->SetXY(100, 136.5 + $h);



      $this->pdf->WriteCell(100, 6, $scheduleAccount->getPaymentCode(), 0, 0, 'C', true);



      $this->pdf->SetXY(0, 0);

      $this->pdf->Rect(160, 13, 40, 7, 'F');

   }



   public function addPagePaymentSlipTest($application) {

      $this->pdf->AddPage();

      $this->pdf->SetImportUse();

      $this->pdf->SetSourceFile(Yii::getPathOfAlias('application.data.template.pdf') . '/payin-slip.pdf');

      $this->pdf->UseTemplate($this->pdf->ImportPage(1, 0, 0, null, 270));

      $this->pdf->SetFont('THSarabun', '', 14);



      $this->pdf->SetXY(185, 27.5);

      $this->pdf->WriteCell(15, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', true);



      /* ชื่อ - นามสกุล ไทย */

      $this->pdf->SetXY(75, 42.5);

      $this->pdf->WriteCell(120, 0, 'รายการทดสอบ #' . CHtml::value($application, 'id', 0), 0, 0, 'C', true);



      /* ชื่อ - นามสกุล อังกฤษ */

      $this->pdf->SetXY(75, 49);

      $this->pdf->WriteCell(120, 0, 'Test Case #' . CHtml::value($application, 'id', 0), 0, 0, 'C', true);



      /* รหัสประจำตัว */

      $this->pdf->SetXY(110, 61);

      $this->pdf->WriteCell(90, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', true);



      /* วันที่สอบ */

      $this->pdf->SetXY(110, 72);

      $this->pdf->WriteCell(90, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', true);



      /* จำนวนเงิน */

      $this->pdf->SetXY(53, 79);

      $this->pdf->WriteCell(100, 0, Yii::app()->format->formatMoney(CHtml::value($application, 'amount', 0)), 0, 0, 'C', true);



      /* จำนวนเงิน (คำอ่าน) */

      $this->pdf->SetXY(53, 86);

      $this->pdf->WriteCell(100, 0, Helper::number2Text(CHtml::value($application, 'amount', 0)) . 'บาทถ้วน', 0, 0, 'C', true);



      //=============================

      $h = 110;



      $this->pdf->SetXY(45, 35 + $h);

      $this->pdf->WriteCell(15, 0, Configuration::getKey('payment_compcode', ''), 0, 0, 'C', true);



      /* ชื่อ - นามสกุล ไทย */

      $this->pdf->SetXY(75, 42.5 + $h);

      $this->pdf->WriteCell(120, 0, 'รายการทดสอบ #' . CHtml::value($application, 'id', 0), 0, 0, 'C', true);



      /* ชื่อ - นามสกุล อังกฤษ */

      $this->pdf->SetXY(75, 49 + $h);

      $this->pdf->WriteCell(120, 0, 'Test Case #' . CHtml::value($application, 'id', 0), 0, 0, 'C', true);



      /* รหัสประจำตัว */

      $this->pdf->SetXY(110, 61 + $h);

      $this->pdf->WriteCell(90, 0, CHtml::value($application, 'ref1', ''), 0, 0, 'C', true);



      /* วันที่สอบ */

      $this->pdf->SetXY(110, 72 + $h);

      $this->pdf->WriteCell(90, 0, CHtml::value($application, 'ref2', ''), 0, 0, 'C', true);



      /* จำนวนเงิน */

      $this->pdf->SetXY(53, 79 + $h);

      $this->pdf->WriteCell(100, 0, Yii::app()->format->formatMoney(CHtml::value($application, 'amount', 0)), 0, 0, 'C', true);



      /* จำนวนเงิน (คำอ่าน) */

      $this->pdf->SetXY(53, 86 + $h);

      $this->pdf->WriteCell(100, 0, Helper::number2Text(CHtml::value($application, 'amount', 0)) . 'บาทถ้วน', 0, 0, 'C', true);



      $this->pdf->Image(Yii::app()->createUrl('get/qr', array('code' => $application->getDeskCode())), 188, 40, 14, 14);

      $this->pdf->Image(Yii::app()->createUrl('get/qr', array('code' => $application->getDeskCode())), 188, 40 + $h, 14, 14);

      $this->pdf->Image(Yii::app()->createUrl('get/barcode', array('code' => str_replace(' ', "\r", $application->getPaymentCode(false)))), 33, 105 + $h, 150, 15);



      $this->pdf->SetFillColor(255, 255, 255);

      $this->pdf->SetFont('THSarabun', '', 14);

      $this->pdf->SetXY(33, 115 + $h);

      $this->pdf->WriteCell(150, 6, $application->getPaymentCode(), 0, 0, 'C', true);

   }



   public function addPageNameList($examSchedule) {

      $this->pdf->AddPage();

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/nameList', array(

                  'examSchedule' => $examSchedule,

                      ), true));

   }



   public function addPageNameListByObjective($examSchedule) {

      $this->pdf->AddPage();

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/nameListByObjective', array(

                  'examSchedule' => $examSchedule,

                      ), true));

   }



   public function addPageNameSignature($examSchedule) {

      $this->pdf->AddPage();

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/nameSignature', array(

                  'examSchedule' => $examSchedule,

                      ), true));

   }



   public function addPagePaymentStatus($examSchedule) {

      $this->pdf->AddPage();

      $this->pdf->WriteHTML(Yii::app()->controller->renderPartial('//pdfMaker/paymentStatus', array(

                  'examSchedule' => $examSchedule,

                      ), true));

   }



   public function output() {

      $this->pdf->Output();

   }



   public function outputAsString() {

      return $this->pdf->Output('', 'S');

   }



   public function ThaiBahtConversion($num)

   {

      $amount_number = number_format($num, 2, ".","");

      //echo "<br/>amount = " . $amount_number . "<br/>";

      $pt = strpos($amount_number , ".");

      $number = $fraction = "";

      if ($pt === false)

         $number = $amount_number;

      else

      {

         $number = substr($amount_number, 0, $pt);

         $fraction = substr($amount_number, $pt + 1);

      }



      //list($number, $fraction) = explode(".", $number);

      $ret = "";

      $baht = $this->ReadNumber ($number);

      if ($baht != "")

         $ret .= $baht . "บาท";



      $satang = $this->ReadNumber($fraction);

      if ($satang != "")

         $ret .=  $satang . "สตางค์";

      else

         $ret .= "ถ้วน";

      //return iconv("UTF-8", "TIS-620", $ret);

      return $ret;

   }



   public function ReadNumber($number)

   {

      $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");

      $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");

      $number = $number + 0;

      $ret = "";

      if ($number == 0) return $ret;

      if ($number > 1000000)

      {

         $ret .= $this->ReadNumber(intval($number / 1000000)) . "ล้าน";

         $number = intval(fmod($number, 1000000));

      }



      $divider = 100000;

      $pos = 0;

      while($number > 0)

      {

         $d = intval($number / $divider);

         $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :

             ((($divider == 10) && ($d == 1)) ? "" :

             ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));

         $ret .= ($d ? $position_call[$pos] : "");

         $number = $number % $divider;

         $divider = $divider / 10;

         $pos++;

      }

      return $ret;

   }



}

