<?php

class DebugMailerForm extends CFormModel {

    public $subject;
    public $message;
    public $to;

    public function rules() {
        return array(
            array('subject, message, to', 'required'),
            array('to', 'email'),
        );
    }

    public function send() {
        if ($this->validate()) {
            $message = new YiiMailMessage;
            $message->setSubject(CHtml::value($this, 'subject'));
            $message->setBody(CHtml::value($this, 'message'), 'text/html');
            $message->addTo(CHtml::value($this, 'to'));
            $message->from = Yii::app()->params['adminEmail'];
            return Yii::app()->mail->send($message);
        }
    }

}
