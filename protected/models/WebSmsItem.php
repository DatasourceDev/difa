<?php

Yii::import('application.models._base.BaseWebSmsItem');

class WebSmsItem extends BaseWebSmsItem {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'webSms' => array(self::BELONGS_TO, 'WebSms', 'web_sms_id'),
        ));
    }

    public function getTextStatus() {
        switch ($this->status) {
            case '9':
                return 'ไม่สามารถส่งได้';
            case '2' :
                return 'เรียบร้อย';
            case '1' :
                return 'กำลังส่งข้อความ';
            case '0':
                return 'รอดำเนินการ';
        }
    }

    public function send() {
        if (Sms::send($this->address_to, $this->webSms->content)) {
            $this->msg = $this->webSms->content;
            $this->status = 2;
            $this->send_date = new CDbExpression('NOW()');
        } else {
            $this->status = 9;
        }
        $this->save();
    }

}
