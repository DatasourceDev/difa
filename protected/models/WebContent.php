<?php

Yii::import('application.models._base.BaseWebContent');

class WebContent extends BaseWebContent {

   const LANG_TH = 'th';
   const LANG_EN = 'en';

   public $cover_file;
   public $vdo_file;

   public static function model($className = __CLASS__) {
      return parent::model($className);
   }

   public static function getLanguageOptions($code = null) {
      $ret = array(
          self::LANG_TH => 'ภาษาไทย',
          self::LANG_EN => 'ภาษาอังกฤษ',
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public static function getIsVisibleOptions($code = null) {
      $ret = array(
          self::YES => 'แสดงบนหน้าเว็บไซต์',
          self::NO => 'ซ่อนการแสดงผล',
      );
      return isset($code) ? $ret[$code] : $ret;
   }

   public function attributeLabels() {
      return array_merge(parent::attributeLabels(), array(
          'name' => 'หัวเรื่อง',
          'content' => 'เนื้อหา',
          'date_start' => 'วันที่เริ่ม',
          'date_end' => 'วันที่สิ้นสุด',
          'is_visible' => 'แสดงข่าวบนเว็บไซต์',
          'lang' => 'ภาษา',
          'cover_file' => 'ภาพหน้าปก',
          'brief' => 'เนื้อหาโดยย่อ',
          'brief_color' => 'สีตัวอักษรของเนื้อหาโดยย่อ',
          'vdo_file' => 'วีดีโอหน้าปก',
          'custom_link'=> 'URL กำหนดเอง'
      ));
   }

   public function behaviors() {
      return array_merge(parent::behaviors(), array(
          'CTimestampBehavior' => array(
              'class' => 'zii.behaviors.CTimestampBehavior',
              'createAttribute' => 'created',
              'updateAttribute' => 'modified',
              'setUpdateOnCreate' => true,
          ),
          'coverFile' => array(
              'class' => 'ImageARBehavior',
              'attribute' => 'cover_file',
              'extension' => implode(',', Helper::getAllowedImageExtension()),
              'relativeWebRootFolder' => 'uploads/content',
              'prefix' => 'cover_',
              'forceExt' => 'png',
              'formats' => array(
                  'normal' => array(
                      'suffix' => '',
                  ),
                  'thumbnail' => array(
                      'suffix' => '_thumbnail',
                      'process' => array(
                          'resize' => array(300, 150),
                      ),
                  ),
              ),
              'defaultName' => 'default',
          ),
      ));
   }

   public function rules() {
      return array_merge(parent::rules(), array(
          array('name, content', 'required'),
          array('vdo_file', 'file', 'allowEmpty' => true, 'types' => array('mp4', 'ogg', 'webm')),
      ));
   }

   public function getHtmlIsVisible() {
      return self::getIsVisibleOptions($this->is_visible);
   }

   public function getIsVisible() {
      return $this->is_visible === self::YES;
   }

   public function current() {
      $criteria = new CDbCriteria();
      $criteria->compare('t.is_visible', self::YES);
      $criteria->addCondition('DATE(COALESCE(date_start,NOW())) <= :today');
      $criteria->addCondition('DATE(COALESCE(date_end,NOW())) >= :today');
      $criteria->params[':today'] = date('Y-m-d');
      $criteria->order = 'IF(is_pin,0,1),created DESC';
      $this->dbCriteria->mergeWith($criteria);
      return $this;
   }

   public static function getContent($id) {
      $items = WebContent::model()->findByAttributes(array(
          'id' => $id,
      ));
      return $items;
   }
   public static function getContentList($limit = 3) {
      $criteria = new CDbCriteria();
      $criteria->compare('t.is_visible', self::YES);
      $criteria->addCondition('DATE(COALESCE(date_start,NOW())) <= :today');
      $criteria->addCondition('DATE(COALESCE(date_end,NOW())) >= :today');
      $criteria->params[':today'] = date('Y-m-d');
      $criteria->order = 'created DESC';
      $criteria->limit = $limit;
      $items = WebContent::model()->findAll($criteria);
      return $items;
   }

   public function getIsPin() {
      return $this->is_pin === self::YES;
   }

   public function getVDOFile() {
      return Yii::app()->baseUrl . $this->vdo;
   }

   public function doTogglePin() {
      $this->is_pin = $this->is_pin === self::YES ? self::NO : self::YES;
      return $this->save();
   }

   public function doUploadVDO() {
      $file = CUploadedFile::getInstance($this, 'vdo_file');
      if (isset($file)) {
         $filename = '/uploads/content/vdo_' . $this->id . '.' . strtolower($file->getExtensionName());
         if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
            $this->vdo = $filename;
            $this->save();
         }
      }
   }

   public function doUpdateAndUploadVDO() {
      $file = CUploadedFile::getInstance($this, 'vdo_file');
      if (isset($file)) {
         //$this->doUnlinkVDO();
         $filename = '/uploads/content/vdo_' . $this->id . '.' . strtolower($file->getExtensionName());
         if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
            $this->vdo = $filename;
         }
      }
      return $this->save();
   }

   public function doUnlinkVDO() {
      if (isset($this->vdo)) {
         //$link = str_replace("/","\\", $this->vdo);
         unlink(Yii::getPathOfAlias('webroot')  .  $link);
         //unlink(Yii::app()->basePath . '\\..\\' . $this->vdo);
      }
   }

   public function doDeleteVDO() {
      if (isset($this->vdo)) {
         //$link = str_replace("/","\\", $this->vdo);
         unlink(Yii::getPathOfAlias('webroot')  .  $link);
         //unlink(Yii::app()->basePath . '\\..\\' . $this->vdo);
         $this->vdo = null;
         $this->save();
      }
   }
}
