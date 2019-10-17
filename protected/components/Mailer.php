<?php

class Mailer {

   public static function sendAlertForgotUsername($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send('alertForgotUsername', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : User sent you a message about username recovery.'),
                  'to' => $to,
                  'matching' => array(
                      '{{topic}}' => CHtml::value($data, 'model.topic'),
                      '{{fullname}}' => CHtml::value($data, 'model.fullname'),
                      '{{email}}' => CHtml::value($data, 'model.email'),
                      '{{place_of_birth}}' => CHtml::value($data, 'model.place_of_birth'),
                      '{{link}}' => CHtml::link(Yii::app()->createAbsoluteUrl('/administrator/accountInquiry/view', array('id' => CHtml::value($data, 'model.id'))), Yii::app()->createAbsoluteUrl('/administrator/accountInquiry/view', array('id' => CHtml::value($data, 'model.id')))),
                  ),
      ));
   }

   public static function sendExamApplyConfirmation($to, $options = array()) {
      $attachments = array();
      $data = CHtml::value($options, 'data');
      $examApplication = CHtml::value($options, 'data.examApplication');
      if ($examApplication->apply_type !== ExamApplication::APPLY_OFFICE) {
         if ($examApplication->payment_amount) {
            if (CHtml::value($data, 'showPayment', true)) {
               $pdf = new PDFMaker();
               $pdf->addPagePaymentSlip($examApplication);
               $attachments[] = array($pdf->outputAsString(), 'payment-slip.pdf', 'application/pdf');
            }
         } else {
            $pdf = new PDFMaker();
            $pdf->addPageExamCard($examApplication);
            $attachments[] = array($pdf->outputAsString(), 'examcard.pdf', 'application/pdf');
         }
      }
      return self::send(CHtml::value($data, 'model.isForeign') ? 'examApplyConfirmationEn' : 'examApplyConfirmationTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Your Test Information.'),
                  'to' => $to,
                  'data' => array(
                      'model' => CHtml::value($options, 'data.model'),
                      'examApplication' => CHtml::value($options, 'data.examApplication'),
                  ),
                  'matching' => array(
                      '{{username}}' => CHtml::value($data, 'model.username'),
                      '{{fullname}}' => CHtml::value($data, 'model.profile.fullname'),
                  ),
                  'attachments' => $attachments,
      ));
   }

   public static function sendExamApplyInformation($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send(CHtml::value($data, 'model.isForeign') ? 'examApplyConfirmationEn' : 'examApplyConfirmationTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Your Test Information.'),
                  'to' => $to,
                  'data' => array(
                      'model' => CHtml::value($options, 'data.model'),
                      'examApplication' => CHtml::value($options, 'data.examApplication'),
                  ),
                  'matching' => array(
                      '{{username}}' => CHtml::value($data, 'model.username'),
                      '{{fullname}}' => CHtml::value($data, 'model.profile.fullname'),
                  ),
      ));
   }

   /**
    * แจ้งเตือนกรณีมีการสร้าง/แก้ไขบัญชีตัวแทนหน่วยงาน
    * @param string $to Recipient's e-mail address
    * @param mixed $options Mail Option
    * @return boolean True if successful. otherwise false
    */
   public static function sendAccountInfo($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send(CHtml::value($data, 'model.isForeign') ? 'accountInfoEn' : 'accountInfoTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Your Account Information.'),
                  'to' => $to,
                  'matching' => array(
                      '{{username}}' => CHtml::value($data, 'model.username'),
                      '{{fullname}}' => CHtml::value($data, 'model.profile.fullname'),
                  ),
      ));
   }

   /**
    * แจ้งเตือนกรณีมีการสร้าง/แก้ไขบัญชีตัวแทนหน่วยงาน
    * @param string $to Recipient's e-mail address
    * @param mixed $options Mail Option
    * @return boolean True if successful. otherwise false
    */
   public static function sendOfficeUserAccount($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send('officeUserAccount', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Your Official Account created.'),
                  'to' => $to,
                  'matching' => array(
                      '{{fullname}}' => CHtml::value($data, 'profile.fullname'),
                      '{{department}}' => CHtml::value($data, 'profile.textDepartment'),
                      '{{division}}' => CHtml::value($data, 'profile.work_department'),
                      '{{schedule}}' => CHtml::value($data, 'model.examScheduleAccount.examSchedule.exam_code'),
                      '{{quota}}' => CHtml::value($data, 'model.examScheduleAccount.preserved_quota'),
                      '{{username}}' => CHtml::value($data, 'model.username'),
                      '{{password}}' => CHtml::value($data, 'model.tmp_password'),
                      '{{contact_phone}}' => CHtml::value($data, 'profile.contact_phone'),
                      '{{contact_mobile}}' => CHtml::value($data, 'profile.contact_mobile'),
                      '{{contact_email}}' => CHtml::value($data, 'profile.contact_email'),
                  ),
      ));
   }

   public static function sendRequestResult($to, $options = array()) {
      $examApplicationResult = CHtml::value($options, 'data.model');
      $attachments = array();
      $pdf = new PDFMaker();
      $pdf->addRequestResltSlip($examApplicationResult);
      $attachments[] = array($pdf->outputAsString(), 'certificate_slip.pdf', 'application/pdf');

      $data = CHtml::value($options, 'data');
      $message = CHtml::value($options, 'message');
      return self::send(CHtml::value($data, 'model.isForeign') ? 'certificationEn' : 'certificationTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Certification Request'),
                  'data' => CHtml::value($options, 'data'),
                  'to' => $to,
                  'matching' => array(
                      '{{message}}' => CHtml::value($message, 'text'),
                  ),
                   'attachments' => $attachments,
      ));
   }

   public static function sendConfirmation($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send(CHtml::value($data, 'model.isForeign') ? 'confirmationEn' : 'confirmationTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES Member Registration Confirmation Mail'),
                  'data' => CHtml::value($options, 'data'),
                  'to' => $to,
                  'matching' => array(
                      '{{username}}' => CHtml::value($data, 'model.username'),
                      '{{fullname}}' => CHtml::value($data, 'model.profile.fullname'),
                      '{{confirm_link}}' => CHtml::link('[click here]', Yii::app()->controller->createAbsoluteUrl('/register/doConfirm', array('id' => CHtml::value($data, 'model.id'), 'c' => CHtml::value($data, 'model.confirmation_code')))),
                      '{{confirm_url}}' => CHtml::link(Yii::app()->controller->createAbsoluteUrl('/register/doConfirm', array('id' => CHtml::value($data, 'model.id'), 'c' => CHtml::value($data, 'model.confirmation_code'))), Yii::app()->controller->createAbsoluteUrl('/register/doConfirm', array('id' => CHtml::value($data, 'model.id'), 'c' => CHtml::value($data, 'model.confirmation_code'))))
                  ),
      ));
   }

   public static function sendPayment($to, $options = array()) {
      $data = CHtml::value($options, 'data');
      return self::send(CHtml::value($data, 'model.isForeign') ? 'paymentEn' : 'paymentTh', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Thank you for purchase.'),
                  'data' => CHtml::value($options, 'data'),
                  'to' => $to,
                  'matching' => array(
                      '{{fullname}}' => CHtml::value($data, 'model.profile.fullname'),
                  ),
      ));
   }

   public static function sendResetPassword($to, $options = array()) {
      return self::send('resetPassword', array(
                  'subject' => CHtml::value($options, 'subject', 'DIFA-TES : Reset Password Request'),
                  'data' => CHtml::value($options, 'data'),
                  'to' => $to,
      ));
   }

   public static function send($view, $options = array()) {
      switch ($_SERVER['HTTP_HOST']) {
         case 'demo.sukung.com':
            return true;
            break;
         default:
            try {
               $html = str_replace(array_keys(CHtml::value($options, 'matching', array())), CHtml::value($options, 'matching', array()), Yii::app()->controller->renderPartial('application.views.mail.' . $view, CHtml::value($options, 'data'), true));
               $message = new YiiMailMessage;
               $message->view = null;
               $message->setSubject(CHtml::value($options, 'subject'));
               $message->addTo(CHtml::value($options, 'to'));
               $message->setBody($html, 'text/html');
               $message->from = Configuration::getKey('sys_noreply_email');

               if (isset($options['attachments']) && is_array($options['attachments'])) {
                  foreach ($options['attachments'] as $attachment) {
                     $message->attach(Swift_Attachment::newInstance($attachment[0], $attachment[1], $attachment[2]));
                  }
               }

               $log = new MailLog;
               $log->title = CHtml::value($options, 'subject');
               $log->content = $html;
               $log->mail_header = 'text/html';
               $log->mail_to = CHtml::value($options, 'to');
               $log->mail_from = Configuration::getKey('sys_noreply_email');
               $log->is_sent = ActiveRecord::NO;
               $log->save();

               if (Yii::app()->mail->send($message)) {
                  $log->isNewRecord = false;
                  $log->is_sent = ActiveRecord::YES;
                  $log->save();
                  return true;
               }
               throw new CException('Mail server error');
            }
            catch (CException $e) {
               Yii::app()->user->setFlash('success', 'Can not send mail to recipients.');
               return false;
            }
            break;
      }
   }

}

