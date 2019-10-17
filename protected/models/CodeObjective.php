<?php

Yii::import('application.models._base.BaseCodeObjective');

class CodeObjective extends BaseCodeObjective {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getIsPrivateObtions($code = null) {
        $ret = array(
            self::NO => 'ทั่วไป',
            self::YES => 'เฉพาะกิจ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'วัตถุประสงค์',
            'is_private' => 'ประเภท',
            'period_start' => 'วันที่เริ่ม',
            'period_end' => 'วันที่สิ้นสุด',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name_th, name_en, is_private', 'required'),
        ));
    }

    public function getTextIsPrivate() {
        return self::getIsPrivateObtions($this->is_private);
    }

}
