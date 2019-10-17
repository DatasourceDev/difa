<?php

Yii::import('application.models._base.BaseWebMailItem');

class WebMailItem extends BaseWebMailItem {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'webMail' => array(self::BELONGS_TO, 'WebMail', 'web_mail_id'),
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
        if (Mailer::send('plain', array(
                    'subject' => $this->webMail->title,
                    'to' => $this->address_to,
                    'data' => array(
                        'content' => $this->webMail->content,
                    ),
                ))) {
            $this->msg = $this->webMail->content;
            $this->status = 2;
            $this->send_date = new CDbExpression('NOW()');
        } else {
            $this->status = 9;
        }
        $this->save();
    }

}
