<?php

Yii::import('application.models._base.BaseAccountInquiry');

class AccountInquiry extends BaseAccountInquiry {

    public $attachment_file;
    public $verifyCode;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'verifyCode' => 'Verification Code',
            'user_id' => 'ชื่อผู้ตอบกลับ',
            'reply_datetime' => 'วันเวลาที่ตอบกลับ',
            'reply_message' => 'ข้อความตอบกลับ',
            'title' => 'Title',
            'firstname' => 'First Name',
            'midname' => 'Middle Name',
            'lastname' => 'Last Name',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('title, firstname, lastname, topic, email', 'required'),
            array('email', 'email'),
            array('place_of_birth', 'required', 'on' => 'forgotUsername'),
            array('attachment_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedFileExtension()),
            array('attachment_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedFileExtension(), 'on' => 'forgotUsername'),
            array('verifyCode', 'required', 'on' => 'insert'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'insert'),
            array('reply_message, email', 'required', 'on' => 'reply'),
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
            'attachmentFile' => array(
                'class' => 'FileARBehavior',
                'attribute' => 'attachment_file',
                'extension' => implode(',', Helper::getAllowedFileExtension()),
                'relativeWebRootFolder' => 'uploads/inquiry',
                'prefix' => 'inquiry_',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                ),
                'defaultName' => 'default',
            ),
        ));
    }

    public function reply() {
        if ($this->save()) {
            Mailer::send('inquiryReply', array(
                'subject' => 'DIFA-TES : Replying your message',
                'to' => $this->email,
                'data' => array(
                    'model' => $this,
                ),
            ));
            return true;
        }
    }

    public function saveForgotUsername() {
        if ($this->save()) {
            /* Send mail to alert admin */
            Mailer::sendAlertForgotUsername(Configuration::getKey('sys_admin_email'), array(
                'data' => array(
                    'model' => $this,
                ),
            ));
            return true;
        }
    }

    public function getFullname() {
        return $this->title . ' ' . $this->firstname . ' ' . $this->midname . ' ' . $this->lastname;
    }

}
