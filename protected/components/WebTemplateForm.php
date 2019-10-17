<?php

class WebTemplateForm extends CFormModel {

    public $theme_name;
    public $desc;

    public $header_bgColor;
    public $header_bgSrc;
    public $menu_bgColor;
    public $menu_bgSrc;
    public $body_bgColor;
    public $body_bgSrc;
    public $subMenu_bgColor;
    public $subMenu_bgSrc;

    public $base_fontSize;
    public $menu_fontSize;
    public $heading_fontSize;
    public $content_fontSize;
    public $subMenu_fontSize;

    public $base_fontColor;
    public $heading_fontColor;
    public $content_fontColor;
    public $subMenu_fontColor;

    //  Menu Links
    public $menu_fontColor;
    public $menuLink_fontColor;
    public $menuALink_fontColor;
    public $menuHLink_fontColor;
    public $menuALink_bgColor;


    public function init() {
        parent::init();
        if (!isset($this->theme_name)) {
            $this->theme_name = Yii::app()->request->getQuery('id');
        }
        foreach ($this->keyMatch() as $name => $key) {
            $this->{$name} = Configuration::getKey($key);
        }
        foreach ($this->imageKeyMatch() as $name => $key) {
            $this->{$name} = Configuration::getKey($key);
        }
    }

    public function keyMatch() {
        return array(
            'desc' => $this->theme_name . '_desc',
            'header_bgColor' => $this->theme_name . '_header_bgColor',
            'menu_bgColor' => $this->theme_name . '_menu_bgColor',
            'body_bgColor' => $this->theme_name . '_body_bgColor',
            'subMenu_bgColor' => $this->theme_name . '_subMenu_bgColor',
            // 'base_fontSize' => $this->theme_name . '_base_fontSize',
            'menu_fontSize' => $this->theme_name . '_menu_fontSize',
            'subMenu_fontSize' => $this->theme_name . '_subMenu_fontSize',
            // 'heading_fontSize' => $this->theme_name . '_heading_fontSize',
            // 'content_fontSize' => $this->theme_name . '_content_fontSize',
            // 'base_fontColor' => $this->theme_name . '_base_fontColor',
            'heading_fontColor' => $this->theme_name . '_heading_fontColor',
            'subMenu_fontColor' => $this->theme_name . '_subMenu_fontColor',
            // 'content_fontColor' => $this->theme_name . '_content_fontColor',
            'menu_fontColor' => $this->theme_name . '_menu_fontColor',
            'menuLink_fontColor' => $this->theme_name . '_menuLink_fontColor',
            'menuALink_fontColor' => $this->theme_name . '_menuALink_fontColor',
            'menuHLink_fontColor' => $this->theme_name . '_menuHLink_fontColor',
            'menuALink_bgColor' => $this->theme_name . '_menuALink_bgColor',
        );
    }

    public function imageKeyMatch() {
        return array(
            'header_bgSrc' => $this->theme_name . '_header_bgSrc',
            'menu_bgSrc' => $this->theme_name . '_menu_bgSrc',
            'body_bgSrc' => $this->theme_name . '_body_bgSrc',
            'subMenu_bgSrc' => $this->theme_name . '_subMenu_bgSrc',
        );
    }

    public function getTemplateFolders() {
        $ret = array();
        $templates = scandir(Yii::getPathOfAlias('webroot') . '/themes');
        foreach ($templates as $template) {
            if (!in_array($template, array('.', '..'))) {
                $ret[] = array(
                    'id' => $template,
                    'name' => $template,
                    'desc' => Configuration::getKey($template.'_desc'),
                );
            }
        }
        return $ret;
    }

    public function rules() {
        return array(
            array('header_bgSrc,menu_bgSrc,menu_bgSrc,body_bgSrc,subMenu_bgSrc', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'gif', 'png')),
            array('header_bgColor,menu_bgColor,subMenu_bgColor,body_bgColor,base_fontColor,menu_fontColor,heading_fontColor,content_fontColor,subMenu_fontColor,menuLink_fontColor,menuALink_fontColor,menuHLink_fontColor,menuALink_bgColor', 'length', 'min' => 7, 'max' => 7),
            array('base_fontSize,menu_fontSize,heading_fontSize,content_fontSize,subMenu_fontSize', 'length', 'max' => 2),
            array('desc', 'length', 'max' => 300),
        );
    }

    public function attributeLabels() {
        return array(
            'header_bgColor' => 'สีพื้นหลัง Header',
            'header_bgSrc' => 'รูปภาพพื้นหลัง Header',
            'menu_bgColor' => 'สีพื้นหลังเมนูบาร์ และ Footer',
            'menu_bgSrc' => 'รูปภาพพื้นหลังเมนูบาร์',
            'body_bgColor' => 'สีพื้นหลัง Body',
            'body_bgSrc' => 'รูปภาพพื้นหลัง Body',
            'subMenu_bgColor' => 'สีพื้นหลังเมนูย่อย',
            'subMenu_bgSrc' => 'รูปภาพพื้นหลังเมนูย่อย',
            'base_fontSize' => 'ขนาดตัวอักษรพื้นฐาน',
            'menu_fontSize' => 'ขนาดอักษรเมนูบาร์ และ Footer',
            'subMenu_fontSize' => 'ขนาดอักษรเมนูย่อย',
            'heading_fontSize' => 'ขนาดอักษร Header',
            'content_fontSize' => 'ขนาดอักษรของข้อความ',
            'base_fontColor' => 'สีอักษรพื้นฐาน',
            'menu_fontColor' => 'สีอักษรเมนูบาร์ และ Footer',
            'menuLink_fontColor' => 'สีตัวอักษรเมนูบาร์',
            'menuALink_fontColor' => 'สีตัวอักษรเมนูบาร์ (ใช้งาน)',
            'menuHLink_fontColor' => 'สีตัวอักษรเมนูบาร์ (เม้าส์ชี้)',
            'menuALink_bgColor' => 'สีพื้นหลังเมนูบาร์ (ใช้งาน)',
            'subMenu_fontColor' => 'สีอักษรเมนูย่อย',
            'heading_fontColor' => 'สีอักษร Header',
            'content_fontColor' => 'สีอักษรของข้อความ',
            'desc' => 'ชื่อรูปแบบ',
        );
    }

    public function active($id) {
        Configuration::setKey('web_template', $id);
        return true;
    }

    public function search() {
        return new CArrayDataProvider($this->getTemplateFolders(), array(
        ));
    }

    private function uploadFile($field) {
        $file = CUploadedFile::getInstance($this, $field);
        if (isset($file)) {
            $filename = '/uploads/' . $this->theme_name . '/' . $field . '.' . strtolower($file->getExtensionName());
            if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
                Configuration::setKey($this->theme_name . '_' . $field, $filename);
            }
        }
    }

    public function removeImage($field) {
        $fileName = Configuration::getKey($this->theme_name . '_' . $field);
        Configuration::setKey($this->theme_name . '_' . $field, null);
        if (isset($fileName)) {
         unlink(Yii::getPathOfAlias('webroot') . $fileName);
        }
        return $fileName;
    }

    public static function getUploadURL($theme, $data) {
        return Yii::app()->baseUrl . $data;
    }

    public function save() {
        if ($this->validate()) {
            foreach ($this->keyMatch() as $name => $key) {
                Configuration::setKey($key, $this->{$name});
            }
            foreach ($this->imageKeyMatch() as $name => $key) {
                $this->uploadFile($name);
            }
            return true;
        }
    }
}
