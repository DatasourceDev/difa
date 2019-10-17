<?php

class ConfigurationForm extends CFormModel {

    public $sys_noreply_email = 'noreply@difa-tes.mfa.go.th';
    public $sys_admin_email = 'noreply@difa-tes.mfa.go.th';
    public $grid_display_row = 20;
    public $exam_retry_month = 6;
    public $certificate_expire_month = 24;
    public $barcode_x = 200;
    public $barcode_y = 50;
    public $barcode_height = 60;
    public $barcode_text_height = 40;
    public $barcode_text_width = 40;
    public $barcode_amount = 4;
    public $payment_username = 'ktb';
    public $payment_password = 'ktb@1234';
    public $payment_tax;
    public $payment_suffix;
    public $payment_compcode;
    public $payment_due_time = '22:00:00';
    public $register_presubmit_day = 52;
    public $register_before_day = 7;
    public $web_register_index;
    public $web_register_term_en;
    public $web_register_term_th;
    public $web_office_index;
    public $sms_api_url = 'http://ws.n-content.com/N-Subscriptionrequest/broadcastReqServlet';
    public $sms_ivr = '*480633407';
    public $sms_ivr_username = 'cdg07';
    public $sms_ivr_password = 'cdg@sms';
    public $sms_response_username = 's-one';
    public $sms_response_password = 's-one@response';
    public $sms_template_confirmation_th;
    public $sms_template_payment_th;
    public $sms_template_alert_schedule_th;
    public $sms_template_alert_result_th;
    public $sms_template_alert_issue_th;
    public $sms_template_confirmation_en;
    public $sms_template_payment_en;
    public $sms_template_alert_schedule_en;
    public $sms_template_alert_result_en;
    public $sms_template_alert_issue_en;
    public $email_signature;
    public $email_template_confirmation_th;
    public $email_template_confirmation_en;
    public $email_account_info_th;
    public $email_account_info_en;
    public $email_template_payment_th;
    public $email_template_payment_en;
    public $email_template_alert_schedule_th;
    public $email_template_alert_schedule_en;
    public $email_template_alert_issue_th;
    public $email_template_alert_result_th;
    public $email_template_alert_result_en;
    public $email_template_alert_issue_en;

    public function init() {
        parent::init();
        foreach ($this->attributeLabels() as $name => $key) {
            $this->{$name} = Configuration::getKey($name, $this->{$name});
        }
    }

    public function rules() {
        return array(
            array('payment_username, payment_password', 'required', 'on' => 'index'),
            array('sys_admin_email, sys_noreply_email', 'required', 'on' => 'mail'),
            array('grid_display_row', 'required', 'on' => 'index'),
            array('grid_display_row', 'numerical', 'integerOnly' => true, 'on' => 'index'),
            array('exam_retry_month, certificate_expire_month, register_presubmit_day, register_before_day', 'required', 'on' => 'index'),
            array('exam_retry_month, certificate_expire_month, register_presubmit_day, register_before_day', 'numerical', 'integerOnly' => true, 'min' => 0, 'on' => 'index'),
            array('barcode_x, barcode_y, barcode_amount, barcode_height, barcode_text_height, barcode_text_width', 'required', 'on' => 'index'),
            array('barcode_x, barcode_y, barcode_amount, barcode_height, barcode_text_height, barcode_text_width', 'numerical', 'on' => 'index'),
            array('payment_tax, payment_suffix, payment_compcode, payment_due_time', 'required', 'on' => 'index'),
            array('web_register_index, web_register_term_en, web_register_term_th, web_office_index', 'safe', 'on' => 'index'),
            array('sms_api_url, sms_ivr, sms_ivr_username, sms_ivr_password, sms_response_username, sms_response_password', 'required', 'on' => 'sms'),
            array('sms_ivr, sms_template_confirmation_th, sms_template_payment_th, sms_template_alert_schedule_th, sms_template_alert_result_th, sms_template_alert_issue_th', 'safe', 'on' => 'sms'),
            array('sms_api_url, sms_template_confirmation_en, sms_template_payment_en, sms_template_alert_schedule_en, sms_template_alert_result_en, sms_template_alert_issue_en', 'safe', 'on' => 'sms'),
            array('email_signature', 'safe', 'on' => 'mail'),
            array('email_account_info_th, email_template_confirmation_th, email_template_payment_th, email_template_alert_schedule_th, email_template_alert_result_th, email_template_alert_issue_th', 'safe', 'on' => 'mail'),
            array('email_account_info_en, email_template_confirmation_en, email_template_payment_en, email_template_alert_schedule_en, email_template_alert_result_en, email_template_alert_issue_en', 'safe', 'on' => 'mail'),
            array('payment_suffix', 'length', 'min' => 2, 'max' => 2, 'on' => 'index'),
        );
    }

    public function attributeLabels() {
        return array(
            'payment_username' => 'ชื่อบัญชีสำหรับ KTB',
            'payment_password' => 'รหัสผ่านสำหรับ KTB',
            'payment_due_time' => 'เวลาหมดเขตชำระเงิน',
            'sys_admin_email' => 'อีเมล์สำหรับผู้ดูแลระบบ',
            'sys_noreply_email' => 'อีเมล์สำหรับส่งแบบไม่ตอบกลับ',
            'grid_display_row' => 'จำนวนแถวที่ต้องการแสดง',
            'exam_retry_month' => 'ระยะเวลาที่อนุญาตให้สอบซ้ำ',
            'certificate_expire_month' => 'อายุผลการสอบ',
            'barcode_x' => 'ตำแหน่งขอบซ้าย',
            'barcode_y' => 'ตำแหน่งขอบบน',
            'barcode_amount' => 'จำนวนบาร์โค๊ด',
            'barcode_height' => 'ความสูงของแท่งบาร์โค๊ด',
            'barcode_text_height' => 'ความสูงของชื่อผู้สมัคร',
            'barcode_text_width' => 'ความกว้างของชื่อผู้สมัคร',
            'payment_tax' => 'เลขประจำตัวผู้เสียภาษี',
            'payment_suffix' => 'เลข Suffix (2หลัก)',
            'payment_compcode' => 'Company Code',
            'register_presubmit_day' => 'ระยะเวลาสมัครล่วงหน้า',
            'register_before_day' => 'ต้องสมัครเสร็จก่อนวันสอบ',
            'web_register_index' => 'หน้าสมัครสมาชิก',
            'web_register_term_en' => 'เงื่อนไข/ข้อตกลงการสมัคร (en)',
            'web_register_term_th' => 'เงื่อนไข/ข้อตกลงการสมัคร (th)',
            'web_office_index' => 'คำอธิบายสำหรับตัวแทนหน่วยงาน',
            'sms_ivr' => 'หมายเลข IVR สำหรับสมัคร SMS',
            'sms_ivr_username' => 'ชื่อผู้ใช้งาน (สำหรับส่งข้อความ)',
            'sms_ivr_password' => 'รหัสผ่าน (สำหรับส่งข้อความ)',
            'sms_response_username' => 'ชื่อผู้ใช้งาน (สำหรับรับผล)',
            'sms_response_password' => 'รหัสผ่าน (สำหรับรับผล)',
            'sms_template_confirmation_th' => 'ยืนยันการสมัคร SMS',
            'sms_template_payment_th' => 'ชำระค่าธรรมเนียมแล้ว',
            'sms_template_alert_schedule_th' => 'เตือนก่อนถึงวันสอบ 1 วัน',
            'sms_template_alert_result_th' => 'เตือนเมื่อผลสอบออก',
            'sms_template_alert_issue_th' => 'แจ้งเตือนกรณีเกิดปัญหา',
            'sms_template_confirmation_en' => 'ยืนยันการสมัคร SMS',
            'sms_template_payment_en' => 'ชำระค่าธรรมเนียมแล้ว',
            'sms_template_alert_schedule_en' => 'เตือนก่อนถึงวันสอบ 1 วัน',
            'sms_template_alert_result_en' => 'เตือนเมื่อผลสอบออก',
            'sms_template_alert_issue_en' => 'แจ้งเตือนกรณีเกิดปัญหา',
            'email_signature' => 'ข้อความท้ายจดหมาย',
            'email_account_info_th' => 'แจ้งข้อมูลการสมัครบัญชี',
            'email_account_info_en' => 'แจ้งข้อมูลการสมัครบัญชี',
            'email_template_confirmation_th' => 'ยืนยันการสมัครสมาชิก',
            'email_template_payment_th' => 'ชำระค่าธรรมเนียมแล้ว',
            'email_template_alert_schedule_th' => 'เตือนก่อนถึงวันสอบ 1 วัน',
            'email_template_alert_result_th' => 'เตือนเมื่อผลสอบออก',
            'email_template_alert_issue_th' => 'แจ้งเตือนกรณีเกิดปัญหา',
            'email_template_confirmation_en' => 'ยืนยันการสมัครสมาชิก',
            'email_template_payment_en' => 'ชำระค่าธรรมเนียมแล้ว',
            'email_template_alert_schedule_en' => 'เตือนก่อนถึงวันสอบ 1 วัน',
            'email_template_alert_result_en' => 'เตือนเมื่อผลสอบออก',
            'email_template_alert_issue_en' => 'แจ้งเตือนกรณีเกิดปัญหา',
            'sms_api_url' => 'API URL',
        );
    }

    public function save() {
        if ($this->validate()) {
            foreach ($this->attributeLabels() as $name => $key) {
                Configuration::setKey($name, $this->{$name});
            }
            return true;
        }
    }

}
