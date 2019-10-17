<?php

Yii::import('application.models._base.BaseExamApplicationResult');

class ExamApplicationResult extends BaseExamApplicationResult {


   const DELIVERY_TYPE_PICKUP = '0';
   const DELIVERY_TYPE_POST = '1';
   const DELIVERY_TYPE_EMS = '2';



   public static function model($className = __CLASS__) {
      return parent::model($className);
   }


   public function attributeLabels() {
      return array_merge(parent::attributeLabels(), array(
          'name' => 'ชื่อ – นามสกุลผู้ขอ',
          'id_card' => 'เลขบัตรประจำตัวประชาชน 13 หลัก',
          'tel' => 'เบอร์โทรศัพท์ผู้ขอ',
          'request_number' => 'จำนวนใบรับรองที่ต้องการขอใหม่',
          'request_delivery_type' => 'การรับใบรับรอง',
      ));
   }


   public static function getDeliveryType($code = null) {
      $ret = array(
          self::DELIVERY_TYPE_POST => 'ไปรษณีย์',
          self::DELIVERY_TYPE_EMS => 'ไปรษณีย์ด่วน (EMS)',
          self::DELIVERY_TYPE_PICKUP => 'มารับด้วยตนเอง/ผู้แทนที่สถาบันการต่างประเทศฯ',
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public static function getStatusDeliveryType($tstatus="")
   {
      if($tstatus==self::DELIVERY_TYPE_POST)
         return "ไปรษณีย์";
      else if($tstatus==self::DELIVERY_TYPE_EMS)
         return "ไปรษณีย์ด่วน (EMS)";
      else
      return "มารับด้วยตนเอง/ผู้แทนที่สถาบันการต่างประเทศฯ";
   }

   public static function getAddress($tstatus="", $address)
   {
      if($tstatus==self::DELIVERY_TYPE_POST)
         return $address;
      else if($tstatus==self::DELIVERY_TYPE_EMS)
         return $address;
      else
         return "";
   }

   public function doPrintRequestResult() {
      $this->is_request = self::NO;
      return $this->save();
   }
}
