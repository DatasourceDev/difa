<?php

Yii::import('application.models._base.BaseReceiptApprover');

class ReceiptApprover extends BaseReceiptApprover {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อ-นามสกุล',
            'position' => 'ตำแหน่ง',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name,position', 'required'),
        ));
    }

    public function getIsDefault() {
        return $this->is_default === self::YES;
    }

}
