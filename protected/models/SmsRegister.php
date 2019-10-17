<?php

Yii::import('application.models._base.BaseSmsRegister');

class SmsRegister extends BaseSmsRegister {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function isRegistered($msisdn) {
        $model = SmsRegister::model()->findByPk($msisdn);
        return isset($model);
    }

}
