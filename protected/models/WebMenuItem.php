<?php

Yii::import('application.models._base.BaseWebMenuItem');

class WebMenuItem extends BaseWebMenuItem {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อเมนู',
            'name_en' => 'Menu Title',
            'url' => 'URL',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name, name_en, url', 'required'),
        ));
    }

}
