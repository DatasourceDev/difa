<?php

Yii::import('application.models._base.BaseProfileChangeType');

class ProfileChangeType extends BaseProfileChangeType {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
            'accountType' => array(self::BELONGS_TO, 'AccountType', 'account_type_id'),
            'accountTypeOriginal' => array(self::BELONGS_TO, 'AccountType', 'account_type_id_original'),
        ));
    }

}
