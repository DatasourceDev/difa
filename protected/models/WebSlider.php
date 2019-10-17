<?php

class WebSlider extends CFormModel {

   const YES = '1';
   const NO = '0';

   public $web_slider1;
   public $web_slider2;
   public $web_slider3;
   public $web_slider4;
   public $web_slider5;

   public $web_slider_url1;
   public $web_slider_url2;
   public $web_slider_url3;
   public $web_slider_url4;
   public $web_slider_url5;
   public $web_slider_is_visible1;
   public $web_slider_is_visible2;
   public $web_slider_is_visible3;
   public $web_slider_is_visible4;
   public $web_slider_is_visible5;

   public function init() {
      parent::init();
      $this->web_slider1 = Configuration::getKey('web_slider1');
      $this->web_slider2 = Configuration::getKey('web_slider2');
      $this->web_slider3 = Configuration::getKey('web_slider3');
      $this->web_slider4 = Configuration::getKey('web_slider4');
      $this->web_slider5 = Configuration::getKey('web_slider5');

      $this->web_slider_url1 = Configuration::getKey('web_slider_url1');
      $this->web_slider_url2 = Configuration::getKey('web_slider_url2');
      $this->web_slider_url3 = Configuration::getKey('web_slider_url3');
      $this->web_slider_url4 = Configuration::getKey('web_slider_url4');
      $this->web_slider_url5 = Configuration::getKey('web_slider_url5');

      $this->web_slider_is_visible1 = Configuration::getKey('web_slider_is_visible1');
      $this->web_slider_is_visible2 = Configuration::getKey('web_slider_is_visible2');
      $this->web_slider_is_visible3 = Configuration::getKey('web_slider_is_visible3');
      $this->web_slider_is_visible4 = Configuration::getKey('web_slider_is_visible4');
      $this->web_slider_is_visible5 = Configuration::getKey('web_slider_is_visible5');
      if(!isset( $this->web_slider_is_visible1)){
         $this->web_slider_is_visible1 = self::NO;
      }
      if(!isset( $this->web_slider_is_visible2)){
         $this->web_slider_is_visible2 = self::NO;
      }
      if(!isset( $this->web_slider_is_visible3)){
         $this->web_slider_is_visible3 = self::NO;
      }
      if(!isset( $this->web_slider_is_visible4)){
         $this->web_slider_is_visible4 = self::NO;
      }
      if(!isset( $this->web_slider_is_visible5)){
         $this->web_slider_is_visible5 = self::NO;
      }
   }

   public function attributeLabels() {
      return array(
          'web_slider1' => 'รูปภาพวีดีโอที่ 1',
          'web_slider2' => 'รูปภาพวีดีโอที่ 2',
          'web_slider3' => 'รูปภาพวีดีโอที่ 3',
          'web_slider4' => 'รูปภาพวีดีโอที่ 4',
          'web_slider5' => 'รูปภาพวีดีโอที่ 5',
          'web_slider_url1' => 'URL กำหนดเอง 1',
          'web_slider_url2' => 'URL กำหนดเอง 2',
          'web_slider_url3' => 'URL กำหนดเอง 3',
          'web_slider_url4' => 'URL กำหนดเอง 4',
          'web_slider_url5' => 'URL กำหนดเอง 5',
          'web_slider_is_visible1' => 'แสดงข่าวบนเว็บไซต์ 1',
          'web_slider_is_visible2' => 'แสดงข่าวบนเว็บไซต์ 2',
          'web_slider_is_visible3' => 'แสดงข่าวบนเว็บไซต์ 3',
          'web_slider_is_visible4' => 'แสดงข่าวบนเว็บไซต์ 4',
          'web_slider_is_visible5' => 'แสดงข่าวบนเว็บไซต์ 5',
      );
   }

   public function rules() {
      return array(
          array('web_slider1', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png', 'mp4', 'ogg', 'webm')),
          array('web_slider2', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png', 'mp4', 'ogg', 'webm')),
          array('web_slider3', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png', 'mp4', 'ogg', 'webm')),
          array('web_slider4', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png', 'mp4', 'ogg', 'webm')),
          array('web_slider5', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png', 'mp4', 'ogg', 'webm')),
      );
   }

   public static function getAssetUrl($index = 1) {
      return Yii::app()->baseUrl . Configuration::getKey('web_slider' . $index, '/images/card-placeholder.png');
   }

   public static function isImage($index = 1) {
      $isImage = true;
      $filename = WebSlider::getAssetUrl($index);
      $file_parts = pathinfo($filename);
      switch($file_parts['extension'])
      {
         case "mp4":
            $isImage = false;
            break;
         case "ogg":
            $isImage = false;
            break;
         case "webm":
            $isImage = false;
            break;
      }
      return $isImage;
   }

   public static function hasData($index = 1) {
      return Configuration::getKey('web_slider' . $index) !== null;
   }

   public static function hasDataurl($index = 1) {
      return Configuration::getKey('web_slider_url' . $index) !== null;
   }

   public static function showSlider($index = 1) {
      $is_visble = Configuration::getKey('web_slider_is_visible' . $index);
      if($is_visble !== null && $is_visble == true)
         return true;
      else
         return false;
   }


   private function uploadFile($index) {
      $file = CUploadedFile::getInstance($this, 'web_slider' . $index);
      if (isset($file)) {
         $filename = '/uploads/web/web_slider' . $index . '.' . strtolower($file->getExtensionName());
         if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
            Configuration::setKey('web_slider' . $index, $filename);
         }
      }
   }

   public function save() {
      if ($this->validate()) {
         $this->uploadFile(1);
         $this->uploadFile(2);
         $this->uploadFile(3);
         $this->uploadFile(4);
         $this->uploadFile(5);
         Configuration::setKey('web_slider_url1', $this->web_slider_url1);
         Configuration::setKey('web_slider_url2', $this->web_slider_url2);
         Configuration::setKey('web_slider_url3', $this->web_slider_url3);
         Configuration::setKey('web_slider_url4', $this->web_slider_url4);
         Configuration::setKey('web_slider_url5', $this->web_slider_url5);
         Configuration::setKey('web_slider_is_visible1', $this->web_slider_is_visible1);
         Configuration::setKey('web_slider_is_visible2', $this->web_slider_is_visible2);
         Configuration::setKey('web_slider_is_visible3', $this->web_slider_is_visible3);
         Configuration::setKey('web_slider_is_visible4', $this->web_slider_is_visible4);
         Configuration::setKey('web_slider_is_visible5', $this->web_slider_is_visible5);
         return true;
      }
   }

   public function remove($index) {
      $fileName = Configuration::getKey('web_slider' . $index);
      Configuration::setKey('web_slider' . $index, null);
      if (isset($fileName)) {
         unlink(Yii::getPathOfAlias('webroot')  .  $fileName);
      }
      return $fileName;
   }

   public function getHtmlIsVisible() {
      return self::getIsVisibleOptions($this->web_slider_is_visible1);
   }

   public function getIsVisible() {
      return $this->web_slider_is_visible1 === self::YES;
   }

   public static function getIsVisibleOptions($code = null) {
      $ret = array(
          self::YES => 'แสดงบนหน้าเว็บไซต์',
          self::NO => 'ซ่อนการแสดงผล',
      );
      return isset($code) ? $ret[$code] : $ret;
   }

}
