<?php

Yii::import('application.models._base.BaseAccountProfileOfficeUser');

class AccountProfileOfficeUser extends BaseAccountProfileOfficeUser {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'title_th' => 'คำนำหน้า',
            'firstname_th' => 'ชื่อ',
            'lastname_th' => 'นามสกุล',
            'work_office_id' => 'หน่วยงาน',
            'work_office' => 'ระบุหน่วยงาน',
            'work_department' => 'กรม/สำนัก',
            'contact_phone' => 'โทรศัพท์ที่ทำงาน',
            'contact_fax' => 'โทรสาร',
            'contact_mobile' => 'โทรศัพท์มือถือ',
            'contact_email' => 'อีเมล์',
            'work_office_type' => 'ประเภทหน่วยงาน',
        ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->work_office = strtoupper($this->work_office);
            $this->work_department = strtoupper($this->work_department);
            return true;
        }
    }

    public function afterSave() {
        parent::afterSave();
        if ($this->scenario !== 'prepare') {
            Mailer::sendOfficeUserAccount(CHtml::value($this, 'contact_email'), array(
                'data' => array(
                    'model' => $this->account,
                    'profile' => $this,
                ),
            ));
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'workOffice' => array(self::BELONGS_TO, 'CodeDepartment', 'work_office_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('contact_email', 'email'),
            array('title_th, firstname_th, lastname_th, work_office_id, work_office_type, work_department', 'required', 'on' => 'register, update'),
            array('work_office', 'checkWorkOffice', 'on' => 'register, update'),
            array('contact_phone, contact_email', 'required', 'on' => 'register, update'),
            array('work_office, work_department', 'match', 'pattern' => '/^([a-zA-Z0-9_ \.])+$/u', 'message' => 'กรุณากรอกภาษาอังกฤษเท่านั้น', 'on' => array('register', 'update')),
        ));
    }

    public function checkWorkOffice() {
        if ($this->work_office_id === CodeDepartment::OTHER && empty($this->work_office)) {
            $this->addError('work_office', 'กรุณาระบุหน่วยงาน');
        }
    }

    public function getFullname() {
        return $this->title_th . $this->firstname_th . ' ' . $this->lastname_th;
    }

    /**
     * ชื่อหน่วยงาน
     * @return string Name of department.
     */
    public function getTextDepartment() {
        if ($this->work_office_id <> CodeDepartment::OTHER && isset($this->workOffice)) {
            return $this->workOffice->name_en;
        }
        return $this->work_office;
    }

    public function getTextDepartmentAddress() {
        return CHtml::value($this, 'account.examScheduleAccount.office_address');
    }

    public function validateRegister() {
        $originalScenario = $this->scenario;
        $this->scenario = 'register';
        $this->validate(null, false);
        $this->scenario = $originalScenario;
        if (!$this->hasErrors()) {
            return true;
        }
    }

}
