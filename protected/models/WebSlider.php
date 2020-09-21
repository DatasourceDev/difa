<?php
class WebSlider_index{
   public $name;
   public $index;
}

class WebSlider extends CFormModel {

   const YES = '1';
   const NO = '0';
   public $action;
   public $select_index;

   public $web_slider1;
   public $web_slider2;
   public $web_slider3;
   public $web_slider4;
   public $web_slider5;

   public $web_slider_index1;
   public $web_slider_index2;
   public $web_slider_index3;
   public $web_slider_index4;
   public $web_slider_index5;

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

      $this->web_slider_index1 = Configuration::getKey('web_slider_index1');
      $this->web_slider_index2 = Configuration::getKey('web_slider_index2');
      $this->web_slider_index3 = Configuration::getKey('web_slider_index3');
      $this->web_slider_index4 = Configuration::getKey('web_slider_index4');
      $this->web_slider_index5 = Configuration::getKey('web_slider_index5');

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
          'web_slider_index1' => 'ลำดับ',
          'web_slider_index2' => 'ลำดับ',
          'web_slider_index3' => 'ลำดับ',
          'web_slider_index4' => 'ลำดับ',
          'web_slider_index5' => 'ลำดับ',
          'web_slider1' => 'รูปภาพวีดีโอ',
          'web_slider2' => 'รูปภาพวีดีโอ',
          'web_slider3' => 'รูปภาพวีดีโอ',
          'web_slider4' => 'รูปภาพวีดีโอ',
          'web_slider5' => 'รูปภาพวีดีโอ',
          'web_slider_url1' => 'URL กำหนดเอง',
          'web_slider_url2' => 'URL กำหนดเอง',
          'web_slider_url3' => 'URL กำหนดเอง',
          'web_slider_url4' => 'URL กำหนดเอง',
          'web_slider_url5' => 'URL กำหนดเอง',
          'web_slider_is_visible1' => 'แสดงข่าวบนเว็บไซต์',
          'web_slider_is_visible2' => 'แสดงข่าวบนเว็บไซต์',
          'web_slider_is_visible3' => 'แสดงข่าวบนเว็บไซต์',
          'web_slider_is_visible4' => 'แสดงข่าวบนเว็บไซต์',
          'web_slider_is_visible5' => 'แสดงข่าวบนเว็บไซต์',
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


   public static function getSilderIndexArray() {
      $web_slider_index1 = Configuration::getKey('web_slider_index1');
      $web_slider_index2 = Configuration::getKey('web_slider_index2');
      $web_slider_index3 = Configuration::getKey('web_slider_index3');
      $web_slider_index4= Configuration::getKey('web_slider_index4');
      $web_slider_index5 = Configuration::getKey('web_slider_index5');
      $web_slider_index6 = Configuration::getKey('web_slider_index6');
      $web_slider_index7 = Configuration::getKey('web_slider_index7');
      $web_slider_index8 = Configuration::getKey('web_slider_index8');
      $web_slider_index9= Configuration::getKey('web_slider_index9');
      $web_slider_index10 = Configuration::getKey('web_slider_index10');
      $web_slider_index11 = Configuration::getKey('web_slider_index11');
      $web_slider_index12 = Configuration::getKey('web_slider_index12');
      $web_slider_index13 = Configuration::getKey('web_slider_index13');
      $web_slider_index14= Configuration::getKey('web_slider_index14');
      $web_slider_index15 = Configuration::getKey('web_slider_index15');
      $web_slider_index16 = Configuration::getKey('web_slider_index16');
      $web_slider_index17 = Configuration::getKey('web_slider_index17');
      $web_slider_index18 = Configuration::getKey('web_slider_index18');
      $web_slider_index19= Configuration::getKey('web_slider_index19');
      $web_slider_index20 = Configuration::getKey('web_slider_index20');
      $arr = array(
         '1'=>$web_slider_index1,
         '2'=> $web_slider_index2,
         '3'=>$web_slider_index3,
         '4'=> $web_slider_index4,
         '5'=> $web_slider_index5,
         '6'=>$web_slider_index6,
         '7'=> $web_slider_index7,
         '8'=>$web_slider_index8,
         '9'=> $web_slider_index9,
         '10'=> $web_slider_index10,
         '11'=>$web_slider_index11,
         '12'=> $web_slider_index12,
         '13'=>$web_slider_index13,
         '14'=> $web_slider_index14,
         '15'=> $web_slider_index15,
         '16'=>$web_slider_index16,
         '17'=> $web_slider_index17,
         '18'=>$web_slider_index18,
         '19'=> $web_slider_index19,
         '20'=> $web_slider_index20
      );
      asort($arr);
      $keys= array_keys($arr);
      return $keys;
   }

   public static function getIndex($index = 1) {
      return Configuration::getKey('web_slider_index' . $index);;
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
   public static function getHtmlIndex($index = 1){
      return CHtml::textField('web_slider_index' . $index, Configuration::getKey('web_slider_index' . $index), array('class' => 'form-control', 'onchange'=>'index_change('. $index .')'));
   }
   public static function getHtmlSource($index = 1){
      if(WebSlider::hasData($index)){
         if(WebSlider::isImage($index)){
            return CHtml::image(WebSlider::getAssetUrl($index) . '?_=' . time(), '', array('style' => 'height: 30px;'));
         }
         else{
            return CHtml::image(WebSlider::getAssetUrl($index) . '?_=' . time(), '', array('style' => 'height: 30px;'));
            //$html = ' <video width="768" height="150" controls><source src="" type="video/mp4"></video>';
            //$html = '<video  height="60" controls>';
            //$html = $html .'<source src="' . WebSlider::getAssetUrl($index) .'">';
            //$html = $html .  '</video>';
            return $html;
         }
      }
   }

   public static function getIsVisibleText($index = 1) {
      $status = Configuration::getKey('web_slider_is_visible' . $index);
      if($status ==  1){
         return 'แสดงบนหน้าเว็บไซต์';
      }
      else{
         return 'ซ่อนการแสดงผล';
      }
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
         Configuration::setKey('web_slider_index1', $this->web_slider_index1);
         Configuration::setKey('web_slider_index2', $this->web_slider_index2);
         Configuration::setKey('web_slider_index3', $this->web_slider_index3);
         Configuration::setKey('web_slider_index4', $this->web_slider_index4);
         Configuration::setKey('web_slider_index5', $this->web_slider_index5);
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
