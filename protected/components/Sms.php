<?php

class Sms {

    public $result;

    public static function send($msisdn, $message, $replace = array(), $group_id = 1) {

        $message = str_replace(array_keys($replace), $replace, $message);

        $log = new SmsLog;
        $log->message = $message;
        $log->msisdn = $msisdn;
        $log->status = 'sending';
        $log->detail = '';
        $log->transid = SmsLog::getNextTransId();
        $log->groupid = $group_id;
        $log->account_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
        $log->save();

        $result = Yii::app()->curl->get(Configuration::getKey('sms_api_url'), array(
            'usr' => Configuration::getKey('sms_ivr_username'),
            'pwd' => Configuration::getKey('sms_ivr_password'),
            'msisdn' => $log->msisdn,
            'sms' => $log->message,
            'transid' => $log->transid,
            'groupid' => $log->groupid,
        ));

        $doc = new SimpleXMLElement($result);
        $log->isNewRecord = false;
        $log->saveAttributes(array(
            'status' => $doc->status,
            'detail' => $doc->detail,
        ));
        return true;
    }

    public function sendDebug($msisdn, $message, $replace = array(), $group_id = 1) {
        $message = str_replace(array_keys($replace), $replace, $message);
        $log = new SmsLog;
        $log->message = $message;
        $log->msisdn = $msisdn;
        $log->status = 'sending';
        $log->detail = '';
        $log->transid = SmsLog::getNextTransId();
        $log->groupid = $group_id;
        $log->account_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
        $log->save();
        $result = Yii::app()->curl->get(Configuration::getKey('sms_api_url'), array(
            'usr' => Configuration::getKey('sms_ivr_username'),
            'pwd' => Configuration::getKey('sms_ivr_password'),
            'msisdn' => $log->msisdn,
            'sms' => $log->message,
            'transid' => $log->transid,
            'groupid' => $log->groupid,
        ));
        $doc = new SimpleXMLElement($result);
        $log->isNewRecord = false;
        $log->saveAttributes(array(
            'status' => $doc->status,
            'detail' => $doc->detail,
        ));
        return $doc;
    }

}
