<?php

class TestCoverForm extends CFormModel {

    public $approve_name;
    public $approve_position;
    public $approve_date;
    public $approve_address;
    public $approve_footer1;
    public $approve_footer2;
    public $approve_footer3;
    public $approve_footer4;
    public $approve_footer5;
    public $items;

    public function init() {
        parent::init();
        $this->approve_date = Yii::app()->format->formatDateThai(date('Y-m-d'));
        $this->approve_footer1 = 'สำนักงานปลัดกระทรวง';
        $this->approve_footer2 = 'สถาบันการต่างประเทศเทวะวงศ์วโรปการ';
        $this->approve_footer3 = 'ส่วนมาตรฐานและประเมินผล';
        $this->approve_footer4 = 'โทร. 0 2203 5000 ต่อ 47009';
        $this->approve_footer5 = 'โทรสาร 0 2143 9326';
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'approve_name' => 'ชื่อผู้อนุมัติ',
            'approve_position' => 'ตำแหน่ง',
            'approve_date' => 'วันที่ออกเอกสาร',
            'approve_address' => 'ที่อยู่',
            'approve_footer1' => 'ท้ายกระดาษ (1)',
            'approve_footer2' => 'ท้ายกระดาษ (2)',
            'approve_footer3' => 'ท้ายกระดาษ (3)',
            'approve_footer4' => 'ท้ายกระดาษ (4)',
            'approve_footer5' => 'ท้ายกระดาษ (5)',
            'items' => '',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('approve_name, approve_position, approve_date', 'required'),
            array('approve_footer1, approve_footer2, approve_footer3, approve_footer4, approve_footer5', 'safe'),
            array('items', 'safe'),
        ));
    }

}
