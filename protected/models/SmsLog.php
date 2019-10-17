<?php

Yii::import('application.models._base.BaseSmsLog');

class SmsLog extends BaseSmsLog {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getNextTransId() {
        return str_pad(Yii::app()->db->createCommand('SELECT COALESCE(MAX(id),0)+1 FROM sms_log')->queryScalar(), 6, 0, STR_PAD_LEFT);
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

}
