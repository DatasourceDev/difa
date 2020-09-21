<?php

class WebSliderForm extends CFormModel {
   const YES = '1';
   const NO = '0';
   public $index;
   public $web_slider;
   public $web_slider_index;
   public $web_slider_url;
   public $web_slider_is_visible;

   private function uploadFile($index) {
      $file = CUploadedFile::getInstance($this, 'web_slider');
      if (isset($file)) {
         $filename = '/uploads/web/web_slider' . $index . '.' . strtolower($file->getExtensionName());
         if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
            Configuration::setKey('web_slider' . $index, $filename);
         }
      }
   }
   public function save($i) {
      if ($this->validate()) {
         $this->uploadFile($i);
         Configuration::setKey('web_slider_index' .$i, $this->web_slider_index);
         Configuration::setKey('web_slider_url' .$i, $this->web_slider_url);
         Configuration::setKey('web_slider_is_visible' .$i, $this->web_slider_is_visible);
         return true;
      }
   }
}


