<?php

Yii::import('application.models._base.BaseMailLog');

class MailLog extends BaseMailLog {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'title' => 'หัวข้อ',
            'mail_from' => 'ผู้ส่ง',
            'mail_to' => 'ผู้รับ',
            'created' => 'เวลาบันทึก',
            'is_sent' => 'สถานะการส่ง',
        ));
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

    public function getIsSent() {
        return $this->is_sent === self::YES;
    }

    public function getHtmlIsSent() {
        return $this->isSent ? '<span class="text-success">เรียบร้อย</span>' : '<span class="text-muted">รอส่ง</span>';
    }

    public function send() {
        $message = new YiiMailMessage;
        $message->view = null;
        $message->setSubject($this->title);
        $message->addTo($this->mail_to);
        $message->setBody($this->content, 'text/html');
        $message->from = $this->mail_from;
        if (Yii::app()->mail->send($message)) {
            $this->is_sent = self::YES;
            $this->save();
        }
    }

}
