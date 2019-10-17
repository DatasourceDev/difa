<?php

Yii::import('application.models._base.BaseCodeTitle');

class CodeTitle extends BaseCodeTitle {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOptions() {
        $titles = CHtml::listData(CodeTitle::model()->findAll(), 'id', 'name');
        $titles['O'] = 'OTHER / อื่นๆ';
        return $titles;
    }

    public static function getThaiOptions() {
        $titles = CHtml::listData(CodeTitle::model()->findAll(), 'id', 'name_th');
        $titles['O'] = 'อื่นๆ';
        return $titles;
    }

    public static function getEnglishOptions() {
        $titles = CHtml::listData(CodeTitle::model()->findAll(), 'id', 'name_en');
        $titles['O'] = 'Other';
        return $titles;
    }
    
    public function getName() {
        return CHtml::value($this, 'name_en') . ' / ' . CHtml::value($this, 'name_th');
    }

}
