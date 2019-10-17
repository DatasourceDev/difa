<?php

Yii::import('application.models._base.BaseExpenditureType');

class ExpenditureType extends BaseExpenditureType {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'รหัส',
            'name' => 'ประเภทรายจ่าย',
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            Expenditure::model()->deleteAllByAttributes(array(
                'expenditure_type_id' => $this->id,
            ));
            return true;
        }
    }

}
