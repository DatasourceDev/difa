<?php

class WebConfigurationForm extends CFormModel {

    public $title;
    public $title_en;
    public $logo_file;

    public static function getLogoUrl() {
        return Yii::app()->baseUrl . Configuration::getKey('web_logo_url', '/images/logo.png');
    }

    public function keyMatch() {
        return array(
            'title' => 'web_title',
            'title_en' => 'web_title_en',
            'logo_file' => 'web_logo_url',
        );
    }

    public function init() {
        parent::init();
        foreach ($this->keyMatch() as $name => $key) {
            $this->{$name} = Configuration::getKey($key);
        }
    }

    public function rules() {
        return array(
            array('title, title_en', 'required'),
            array('logo_file', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png')),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => 'ชื่อเว็บไซต์',
            'title_en' => 'Website Title',
            'logo_file' => 'ไฟล์โลโก้',
        );
    }

    public function save() {
        if ($this->validate()) {
            foreach ($this->keyMatch() as $name => $key) {
                if ($name !== 'logo_file') {
                    Configuration::setKey($key, $this->{$name});
                }
            }
            $file = CUploadedFile::getInstance($this, 'logo_file');
            if (isset($file)) {
                $filename = '/uploads/web/logo.' . strtolower($file->getExtensionName());
                if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
                    Configuration::setKey('web_logo_url', $filename);
                }
            }
            return true;
        }
    }

}
