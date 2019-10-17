<?php

Yii::import('application.models._base.BaseIncomeType');

class IncomeType extends BaseIncomeType {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'เลขที่ใช้',
            'name' => 'ประเภทรายรับ',
            'comp_code' => 'Company Code'
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('id, name', 'required'),
            array('id', 'unique'),
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            Income::model()->deleteAllByAttributes(array(
                'income_type_id' => $this->id,
            ));
            return true;
        }
    }

    public function getCompanyCode() {
        return CHtml::value($this, 'comp_code', '-');
    }

    public function getTextName() {
        return $this->id . ' - ' . $this->name . ' (' . $this->getCompanyCode() . ')';
    }

}
