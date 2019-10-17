<?php

Yii::import('application.models._base.BaseAccountProfileGeneralThai');

class AccountProfileGeneralThai extends BaseAccountProfileGeneralThai implements IAccountProfile {

    const EMP_SERVANT = '0';
    const EMP_SELF = '1';
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const DEGREE_PHD = 'P';
    const DEGREE_MASTER = 'M';
    const DEGREE_BACHELOR = 'B';
    const DEGREE_OTHER = 'O';

    public $emp_card_file;
    public $self_file;
    public $photo_file;
    public $name_file;
    public $require_changename;
    public $birth_date_th;
    public $emp_card_issue_date_th;
    public $emp_card_expire_date_th;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getEmpTypeOptions($code = null) {
        $ret = array(
            self::EMP_SERVANT => 'บัตรข้าราชการ/พนง.รัฐวิสาหกิจ',
            self::EMP_SELF => 'หนังสือรับรองสถานภาพข้าราชการ ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getGenderOptions($code = null) {
        $ret = array(
            self::GENDER_MALE => 'ชาย',
            self::GENDER_FEMALE => 'หญิง',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getEducationDegreeOptions($code = null) {
        $ret = array(
            self::DEGREE_PHD => 'ปริญญาเอก',
            self::DEGREE_MASTER => 'ปริญญาโท',
            self::DEGREE_BACHELOR => 'ปริญญาตรี',
            self::DEGREE_OTHER => 'อื่นๆ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getWorkLevelOptions($code = null) {
        $ret = array(
            1 => 'ปลัดกระทรวง / เลขาธิการ',
            2 => 'รองปลัดกระทรวง / รองเลขาธิการ',
            3 => 'อธิบดี',
            4 => 'นักบริหารสูง',
            5 => 'รองอธิบดี / ผู้ช่วยปลัดกระทรวง',
            6 => 'นักบริหารต้น',
            7 => 'ผู้อำนวยการสำนัก',
            8 => 'อำนวยการสูง',
            9 => 'เชี่ยวชาญ',
            10 => 'ผู้อำนวยการกอง',
            11 => 'อำนวยการต้น',
            12 => 'ชำนาญการพิเศษ',
            13 => 'ชำนาญการ',
            14 => 'ปฏิบัติการ',
            15 => 'อาวุโส',
            16 => 'ชำนาญงาน',
            17 => 'ปฏิบัติงาน',
            99 => 'อื่นๆ โปรดระบุ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'gender' => 'เพศ',
            'title_id_th' => 'คำนำหน้า',
            'title_th' => 'ระบุคำนำหน้า',
            'title_id_en' => 'Title',
            'title_en' => 'Other Title',
            'firstname_th' => 'ชื่อ',
            'lastname_th' => 'นามสกุล',
            'firstname_en' => 'Firstname',
            'lastname_en' => 'Lastname',
            'religion_id' => 'ศาสนา',
            'religion_other' => 'ศาสนาอื่นๆ',
            'nationality_id' => 'สัญชาติ',
            'birth_date' => 'วันเดือนปีเกิด',
            'work_office_type' => 'ประเภทหน่วยงาน',
            'work_office_id' => 'กระทรวง/หน่วยงาน',
            'work_office_other' => 'Department',
            'work_office_other_th' => 'หน่วยงานอื่นๆ',
            'work_department' => 'Division',
            'work_department_th' => 'กรม/สำนัก',
            'work_position' => 'ตำแหน่ง',
            'work_level' => 'ระดับ',
            'work_level_other' => 'ระดับอื่นๆ',
            'emp_type' => 'ประเภทหลักฐาน',
            'emp_card' => 'เลขที่บัตร',
            'emp_card_issue_date' => 'วันที่ออกบัตร',
            'emp_card_expire_date' => 'วันหมดอายุ',
            'emp_card_file' => 'แนบไฟล์รูปบัตร',
            'self_file' => 'แนบไฟล์หลักฐาน',
            'educate_degree' => 'ระดับการศึกษา',
            'educate_degree_other' => 'ระดับการศึกษาอื่นๆ',
            'educate_subject' => 'สาขา',
            'educate_university' => 'สถาบันการศึกษา',
            'educate_country' => 'ประเทศ',
            'work_address_name' => 'ชื่อหน่วยงาน',
            'work_address_homeno' => 'เลขที่',
            'work_address_building' => 'อาคาร',
            'work_address_floor' => 'ชั้น',
            'work_address_soi' => 'ซอย',
            'work_address_street' => 'ถนน',
            'work_address_province_id' => 'จังหวัด',
            'work_address_amphur_id' => 'เขต/อำเภอ',
            'work_address_tumbon_id' => 'แขวง/ตำบล',
            'work_address_postcode' => 'รหัสไปรษณีย์',
            'reply_address_name' => 'ชื่อหน่วยงาน',
            'reply_address_homeno' => 'เลขที่',
            'reply_address_building' => 'อาคาร',
            'reply_address_floor' => 'ชั้น',
            'reply_address_soi' => 'ซอย',
            'reply_address_street' => 'ถนน',
            'reply_address_province_id' => 'จังหวัด',
            'reply_address_amphur_id' => 'เขต/อำเภอ',
            'reply_address_tumbon_id' => 'แขวง/ตำบล',
            'reply_address_postcode' => 'รหัสไปรษณีย์',
            'emergency_name' => 'ชื่อ-นามสกุล',
            'emergency_phone' => 'เบอร์โทรศัพท์',
            'contact_phone' => 'โทรศัพท์ที่ทำงาน',
            'contact_fax' => 'โทรสาร',
            'contact_mobile' => 'โทรศัพท์มือถือ',
            'contact_email' => 'อีเมล์',
            'photo_file' => 'ไฟล์รูปผู้สมัคร',
            'name_file' => 'เอกสารแนบ',
            'work_year' => 'ปีที่บรรจุ',
            'emp_pic_file' => 'แนบไฟล์รูปบัตร',
        ));
    }

    public function afterFind() {
        parent::afterFind();

        /* Maintain Thai format date */
        $this->birth_date_th = $this->convertToThaiDate($this->birth_date);
        $this->emp_card_issue_date_th = $this->convertToThaiDate($this->emp_card_issue_date);
        $this->emp_card_expire_date_th = $this->convertToThaiDate($this->emp_card_expire_date);
    }

    public function convertToThaiDate($date) {
        if ($date) {
            $obj = new DateTime($date);
            return $obj->format('d/m/') . ($obj->format('Y') + 543);
        }
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'empCardFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'emp_card_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'protected/uploads/profile',
                'prefix' => 'emp_',
                'forceExt' => 'png',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                        'process' => array(
                            'resize' => array(600, null),
                        ),
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(300, null),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
            'photoFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'photo_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'protected/uploads/profile',
                'prefix' => 'photo_',
                'forceExt' => 'png',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                        'process' => array(
                            'resize' => array(600, null),
                        ),
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(300, null),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
            'selfFile' => array(
                'class' => 'FileARBehavior',
                'attribute' => 'self_file',
                'extension' => implode(',', Helper::getAllowedDocumentExtension()),
                'relativeWebRootFolder' => 'protected/uploads/self',
                'prefix' => 'emp_',
            ),
        ));
    }

    public function newProfileChangeDepartment() {
        $model = new ProfileChangeDepartment;
        $model->account_id = $this->account_id;
        $model->department_type_original = $this->work_office_type;
        $model->department_original = $this->getTextDepartment();
        $model->office_original = $this->work_department;
        $model->position_original = $this->work_position;
        $model->level_original = $this->work_level;
        return $model;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->title_en = strtoupper($this->title_en);
            $this->firstname_en = strtoupper($this->firstname_en);
            $this->lastname_en = strtoupper($this->lastname_en);
            $this->work_department = strtoupper($this->work_department);
            $this->work_office_other = strtoupper($this->work_office_other);

            if (!$this->isNewRecord) {
                $profile = self::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));
                if ($this->checkDepartmentChange($profile)) {
                    $model = new ProfileChangeDepartment;
                    $model->account_id = $profile->account_id;
                    $model->department_type_original = $profile->work_office_type;
                    $model->department_original = $profile->getTextDepartment();
                    $model->office_original = $profile->work_department;
                    $model->position_original = $profile->work_position;
                    $model->level_original = $profile->work_level;
                    $model->department_type = $this->work_office_type;
                    $model->department = $this->getTextDepartment();
                    $model->office = $this->work_department;
                    $model->position = $this->work_position;
                    $model->level = $this->work_level;
                    $model->save();
                }

                if ($this->require_changename) {
                    $model = new ProfileChangeName;
                    $model->account_id = $profile->account_id;
                    $model->title_id_th_original = CHtml::value($profile, 'title_id_th');
                    $model->title_th_original = CHtml::value($profile, 'title_th');
                    $model->firstname_th_original = CHtml::value($profile, 'firstname_th');
                    $model->midname_th_original = CHtml::value($profile, 'midname_th');
                    $model->lastname_th_original = CHtml::value($profile, 'lastname_th');
                    $model->title_id_en_original = CHtml::value($profile, 'title_id_en');
                    $model->title_en_original = CHtml::value($profile, 'title_en');
                    $model->firstname_en_original = CHtml::value($profile, 'firstname_en');
                    $model->midname_en_original = CHtml::value($profile, 'midname_en');
                    $model->lastname_en_original = CHtml::value($profile, 'lastname_en');
                    $model->title_id_th = CHtml::value($this, 'title_id_th');
                    $model->title_th = CHtml::value($this, 'title_th');
                    $model->firstname_th = CHtml::value($this, 'firstname_th');
                    $model->midname_th = CHtml::value($this, 'midname_th');
                    $model->lastname_th = CHtml::value($this, 'lastname_th');
                    $model->title_id_en = CHtml::value($this, 'title_id_en');
                    $model->title_en = CHtml::value($this, 'title_en');
                    $model->firstname_en = CHtml::value($this, 'firstname_en');
                    $model->midname_en = CHtml::value($this, 'midname_en');
                    $model->lastname_en = CHtml::value($this, 'lastname_en');
                    $file = CUploadedFile::getInstance($this, 'name_file');
                    $filename = strtolower(time() . '.' . $file->extensionName);
                    if ($file) {
                        $file->saveAs(Yii::getPathOfAlias('application.uploads.name') . '/' . $filename);
                    }
                    $model->file_url = '/uploads/name/' . $filename;
                    $model->save();
                }
            }
            return true;
        }
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->is_same_address === self::YES) {
                $this->reply_address_name = $this->work_address_name;
                $this->reply_address_homeno = $this->work_address_homeno;
                $this->reply_address_building = $this->work_address_building;
                $this->reply_address_floor = $this->work_address_floor;
                $this->reply_address_soi = $this->work_address_soi;
                $this->reply_address_street = $this->work_address_street;
                $this->reply_address_province_id = $this->work_address_province_id;
                $this->reply_address_amphur_id = $this->work_address_amphur_id;
                $this->reply_address_tumbon_id = $this->work_address_tumbon_id;
                $this->reply_address_postcode = $this->work_address_postcode;
            }

            if ($this->work_office_id <> '9999') {
                /* @var $department CodeDepartment */
                $department = CodeDepartment::model()->findByPk($this->work_office_id);
                if (isset($department)) {
                    $this->work_office_other_th = $department->name_th;
                    $this->work_office_other = $department->name_en;
                }
            }
            $this->work_office_other = strtoupper($this->work_office_other);
            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'nationality' => array(self::BELONGS_TO, 'CodeCountry', 'nationality_id'),
            'replyAddressProvince' => array(self::BELONGS_TO, 'CodeProvince', 'reply_address_province_id'),
            'replyAddressAmphur' => array(self::BELONGS_TO, 'CodeAmphur', 'reply_address_amphur_id'),
            'replyAddressTumbon' => array(self::BELONGS_TO, 'CodeTumbon', 'reply_address_tumbon_id'),
            'workOffice' => array(self::BELONGS_TO, 'CodeDepartment', 'work_office_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            /* scenario : all */
            array('contact_email', 'email'),
            /* scenario : register, update */
            array('emp_type, gender, title_id_th, title_id_en, firstname_th, lastname_th, firstname_en, lastname_en, birth_date, nationality_id', 'required', 'on' => array('register', 'update')),
            array('work_office_type,work_office_id, work_office_other, work_department, work_position, work_level, work_level_other', 'required', 'on' => array('register', 'update')),
            array('educate_degree, educate_subject, educate_university, educate_country', 'required', 'on' => array('register', 'update')),
            array('work_address_homeno, work_address_province_id, work_address_amphur_id, work_address_tumbon_id, work_address_postcode', 'required', 'on' => array('register', 'update')),
            array('reply_address_homeno, reply_address_province_id, reply_address_amphur_id, reply_address_tumbon_id, reply_address_postcode', 'required', 'on' => array('register', 'update')),
            array('contact_mobile, contact_email', 'required', 'on' => array('register', 'update')),
            array('title_en', 'checkTitleEn', 'on' => array('register', 'update')),
            array('title_th', 'checkTitleTh', 'on' => array('register', 'update')),
            array('educate_degree_other', 'checkEducateDegree', 'on' => array('register', 'update')),
            array('title_en, firstname_en, lastname_en', 'match', 'pattern' => '/^([a-zA-Z0-9_ \,\.\-\(\)\/])+$/u', 'message' => 'กรุณากรอกภาษาอังกฤษ', 'on' => array('register', 'update')),
            array('title_th, firstname_th, lastname_th', 'match', 'pattern' => '/[^a-z_\-0-9]/i', 'message' => 'กรุณากรอกภาษาไทย', 'on' => array('register', 'update')),
            array('work_office_other, work_department', 'match', 'pattern' => '/^([a-zA-Z0-9_ \,\.\-\(\)\/])+$/u', 'message' => '', 'on' => array('register', 'update')),
            /* scenario : registerByOffice */
            array('gender, title_id_th, title_id_en, firstname_th, lastname_th, firstname_en, lastname_en, birth_date', 'required', 'on' => array('registerByOffice', 'updateByOffice')),
            array('work_office_type,work_office_id, work_department, work_position, work_level, work_level_other', 'required', 'on' => array('registerByOffice', 'updateByOffice')),
            array('contact_mobile_country, contact_mobile, contact_email', 'required', 'on' => array('registerByOffice', 'updateByOffice')),
            array('title_en, firstname_en, lastname_en', 'match', 'pattern' => '/^([a-zA-Z0-9_ \,\.\-\(\)\/])+$/u', 'message' => 'กรุณากรอกภาษาอังกฤษ', 'on' => array('registerByOffice', 'updateByOffice')),
            array('title_th, firstname_th, lastname_th', 'match', 'pattern' => '/[^a-z_\-0-9]/i', 'message' => 'กรุณากรอกภาษาไทย', 'on' => array('registerByOffice', 'updateByOffice')),
            /* scenario : checkIdentityCard */
            array('emp_card', 'required', 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate')),
            array('emp_pic_file', 'required', 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate')),
            array('emp_card_expire_date', 'compare', 'operator' => '>', 'compareValue' => date('Y-m-d'), 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate'), 'message' => 'ไม่สามารถบันทึกบัตรที่หมดอายุแล้ว'),
            array('emp_card_issue_date, emp_card_expire_date', 'required', 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate')),
            array('emp_card_issue_date', 'compare', 'operator' => '<', 'compareAttribute' => 'emp_card_expire_date', 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate')),
            /* scenario : checkSelfIdentity */
            array('self_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedDocumentExtension(), 'maxSize' => 2 * 1024 * 1024, 'on' => array('checkSelfIdentity'), 'tooLarge' => 'ไฟล์มีขนาดใหญ่ไป กรุณาลดขนาดภาพก่อนอัพโหลด'),
            array('self_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedDocumentExtension(), 'maxSize' => 2 * 1024 * 1024, 'on' => array('checkSelfIdentityUpdate'), 'tooLarge' => 'ไฟล์มีขนาดใหญ่ไป กรุณาลดขนาดภาพก่อนอัพโหลด'),
            /* changename */
            array('require_changename', 'checkChangeName', 'on' => 'update'),
            array('name_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedDocumentExtension(), 'on' => 'checkChangeName'),
            /* fake date */
            array('birth_date_th, emp_card_issue_date_th, emp_card_expire_date_th', 'safe'),
        ));
    }

    public function checkChangeName() {
        if ($this->require_changename) {
            $originalScenario = $this->scenario;
            $this->scenario = 'checkChangeName';
            $this->validate(null, false);
            $this->scenario = $originalScenario;
        }
    }

    public function checkDepartmentChange($model) {
        if ($this->getTextDepartment() <> $model->getTextDepartment()) {
            return true;
        }
        if ($this->work_department <> $model->work_department) {
            return true;
        }
        if ($this->work_office_type <> $model->work_office_type) {
            return true;
        }
        if ($this->work_position <> $model->work_position) {
            return true;
        }
        if ($this->work_level <> $model->work_level) {
            return true;
        }
    }

    public function validateRegister() {
        $originalScenario = $this->scenario;
        $this->scenario = 'register';
        $this->validate(null, false);
        switch ($this->emp_type) {
            case self::EMP_SERVANT:
                $this->scenario = $this->isNewRecord ? 'checkIdentityCard' : 'checkIdentityCardUpdate';
                $this->validate(null, false);
                break;
            case self::EMP_SELF:
                $this->scenario = $this->isNewRecord ? 'checkSelfIdentity' : 'checkSelfIdentityUpdate';
                $this->validate(null, false);
                break;
        }
        $this->scenario = $originalScenario;
        if (!$this->hasErrors()) {
            return true;
        }
    }

    public function checkTitleTh() {
        if ($this->title_id_th === 'O') {
            if (empty($this->title_th)) {
                $this->addError('title_th', 'กรุณาระบุให้ครบถ้วน');
            }
        } else {

            $this->title_th = null;
        }
    }

    public function checkTitleEn() {
        if ($this->title_id_en === 'O') {
            if (empty($this->title_en)) {
                $this->addError('title_en', 'Please input other title');
            }
        } else {

            $this->title_en = null;
        }
    }

    public function checkEducateDegree() {
        if ($this->educate_degree === 'O') {
            if (empty($this->educate_degree_other)) {
                $this->addError('educate_degree_other', 'กรุณาระบุระดับการศึกษา');
            }
        } else {
            $this->
                    educate_degree_other = null;
        }
    }

    public function getFullname() {
        return $this->textTitleTh . $this->firstname_th . ' ' . $this->lastname_th;
    }

    public function getFullnameTh() {
        return $this->textTitleTh . $this->firstname_th . ' ' . $this->lastname_th;
    }

    public function getFullnameEn() {
        return strtoupper($this->textTitleEn . ' ' . $this->firstname_en . ' ' . $this->lastname_en);
    }

    public function getReplyAddress() {
        $ret = '';
        $ret .= $this->replyAddressLine1;
        $ret .= "\n";
        $line = $this->replyAddressLine2;
        $ret .= trim($line) ? $line . "\n" : '';
        $ret .= $this->replyAddressLine3;
        $ret .= "\n";
        $ret .= $this->replyAddressLine4;
        return $ret;
    }

    public function getReplyAddressLine1() {
        $ret = '';
        $ret .= ($this->reply_address_name ? $this->reply_address_name . "\n" : '');
        $ret .= ($this->reply_address_homeno ? ' เลขที่ ' . $this->reply_address_homeno : '');
        $ret .= ($this->reply_address_building ? ' ' . $this->reply_address_building : '');
        $ret .= ($this->reply_address_floor ? ' ชั้น ' . $this->reply_address_floor : '');
        return $ret;
    }

    public function getReplyAddressLine2() {
        $ret = ($this->reply_address_soi ? ' ซ.' . $this->reply_address_soi : '');
        $ret .= ($this->reply_address_street ? ' ถ.' . $this->reply_address_street : '');
        return $ret;
    }

    public function getReplyAddressLine3() {
        $ret = '';
        if (CHtml::value($this, 'replyAddressProvince.name') === 'กรุงเทพมหานคร') {
            $ret .= ($this->reply_address_tumbon_id ? ' แขวง' . CHtml::value($this, 'replyAddressTumbon.name') : '');
            $ret .= ($this->reply_address_amphur_id ? ' ' . CHtml::value($this, 'replyAddressAmphur.name') : '');
        } else {
            $ret .= ($this->reply_address_tumbon_id ? ' ต.' . CHtml::value($this, 'replyAddressTumbon.name') : '');
            $ret .= ($this->reply_address_amphur_id ? ' อ.' . CHtml::value($this, 'replyAddressAmphur.name') : '');
        }
        return $ret;
    }

    public function getReplyAddressLine4() {
        $ret = '';
        if (CHtml::value($this, 'replyAddressProvince.name') === 'กรุงเทพมหานคร') {
            $ret .= ($this->reply_address_province_id ? CHtml::value($this, 'replyAddressProvince.name') : '');
        } else {
            $ret .= ($this->reply_address_province_id ? ' จ.' . CHtml::value($this, 'replyAddressProvince.name') : '');
        }
        $ret .= ($this->reply_address_postcode ? ' ' . $this->reply_address_postcode : '');
        return $ret;
    }

    public function getTextAnyPhone() {
        if ($this->contact_phone) {
            return $this->contact_phone;
        }
        if ($this->contact_mobile) {
            return $this->contact_mobile;
        }
    }

    public function getTextContactPhone() {
        return $this->contact_phone;
    }

    public function getTextContactMobile() {
        return $this->contact_mobile_country . ' ' . $this->contact_mobile;
    }

    public function getTextTitleTh() {
        $model = CodeTitle::model()->findByPk($this->title_id_th);
        if (isset($model)) {
            return $model->name_th;
        }

        return $this->title_th;
    }

    public function getTextTitleEn() {
        $model = CodeTitle::model()->findByPk($this->title_id_en);
        if (isset($model)) {
            return $model->name_en;
        }

        return $this->title_en;
    }

    public function getTextDepartment() {
        if ($this->work_office_id === '9999') {
            return strtoupper($this->work_office_other);
        } else {
            return strtoupper(CHtml::value($this, 'workOffice.name_en'));
        }
    }

    public function getTextDepartmentTh() {
        if ($this->work_office_id === '9999') {
            return $this->work_office_other_th;
        } else {
            return CHtml::value($this, 'workOffice.name_th');
        }
    }

    public function getTextDepartmentForCard() {
        return $this->getTextDepartment();
    }

    public function getTextWorkLevel() {
        if ($this->work_level === '99') {
            return self::getWorkLevelOptions($this->work_level);
        }
        return $this->work_level_other;
    }

    public function getTextWorkPosition() {
        return $this->work_position;
    }

    public function getTextWorkOffice() {
        return $this->work_department;
    }

    public function getTextWorkOfficeTh() {
        return $this->work_department_th;
    }

    public function getTextFirstnameEn() {
        return $this->firstname_en;
    }

    public function getTextFirstnameTh() {
        return $this->firstname_th;
    }

    public function getTextMidnameEn() {
        return $this->midname_en;
    }

    public function getTextMidnameTh() {
        return $this->midname_th;
    }

    public function getTextLastnameEn() {
        return $this->lastname_en;
    }

    public function getTextLastnameTh() {
        return $this->lastname_th;
    }

    public function getPhotoUrl($self = true) {
        $file = null;
        if (!$this->isNewRecord) {
            try {
                $path = $this->empCardFile->getFilePath('thumbnail');
                if ($path) {
                    $newName = uniqid() . '.' . pathinfo($path, PATHINFO_EXTENSION);
                    rename($path, Yii::getPathOfAlias('application.uploads.emp') . '/' . $newName);
                    $this->saveAttributes(array(
                        'emp_pic_file' => $newName,
                    ));
                    $this->emp_pic_file = $newName;
                }
            } catch (CException $e) {
                
            }

            try {
                $path = $this->passportFile->getFilePath();
                if ($path) {
                    echo $path;
                    exit;
                }
            } catch (CException $e) {
                
            }

            if (isset($this->emp_pic_file)) {
                if (substr($this->emp_pic_file, 0, 11) === 'data:image/') {
                    return $this->emp_pic_file;
                }
                if (substr($this->emp_pic_file, 0, 6) === 'draft_') {
                    $name = $this->emp_pic_file;
                    $newName = substr($name, 6);
                    if (file_exists(Yii::getPathOfAlias('webroot.uploads.emp') . '/' . $this->emp_pic_file)) {
                        rename(Yii::getPathOfAlias('webroot.uploads.emp') . '/' . $name, Yii::getPathOfAlias('application.uploads.emp') . '/' . $newName);
                    }
                    $this->saveAttributes(array(
                        'emp_pic_file' => $newName,
                    ));
                    $this->emp_pic_file = $newName;
                }
                $file = Yii::getPathOfAlias('application.uploads.emp') . '/' . $this->emp_pic_file;
            }
        }
        if (!file_exists($file)) {
            $file = Yii::getPathOfAlias('webroot') . '/images/card-placeholder.png';
        }
        $type = pathinfo($file, PATHINFO_EXTENSION);
        $data = file_get_contents($file);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function getPhotoRealPath() {
        /*
          if (CHtml::value($this, 'empCardFile.filePath')) {
          return CHtml::value($this, 'empCardFile.fileUrl');
          }
          if (CHtml::value($this, 'passportFile.filePath')) {
          return CHtml::value($this, 'passportFile.fileUrl');
          } */
        if (isset($this->emp_pic_file)) {
            $file = Yii::getPathOfAlias('application.uploads.emp') . $this->emp_pic_file;
        } else {
            $file = Yii::getPathOfAlias('webroot') . '/images/card-placeholder.png';
        }
        $type = pathinfo($file, PATHINFO_EXTENSION);
        $data = file_get_contents($file);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function createProfileOfType($id) {
        switch ($id) {
            case '1':
                $profile = AccountProfileGeneralThai::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));
                if (!isset($profile)) {
                    $profile = new AccountProfileGeneralThai;
                }
                break;
            case '2':
                $profile = AccountProfileGeneralForeigner::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));
                if (!isset($profile)) {
                    $profile = new AccountProfileGeneralForeigner;
                }
                break;
            case '3':
                $profile = AccountProfileDiplomatThai::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));
                if (!isset($profile)) {
                    $profile = new AccountProfileDiplomatThai;
                }
                break;
            case '4':
                $profile = AccountProfileDiplomatForeigner::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));
                if (!isset($profile)) {
                    $profile = new AccountProfileDiplomatForeigner;
                }
                break;
        }
        if (!isset($profile)) {
            return false;
        }
        $profile->attributes = array(
            'account_id' => CHtml::value($this, 'account_id'),
            'gender' => CHtml::value($this, 'gender'),
            'title_en' => CHtml::value($this, 'title_en'),
            'title_id_en' => CHtml::value($this, 'title_id_en'),
            'firstname_en' => CHtml::value($this, 'firstname_en'),
            'midname_en' => CHtml::value($this, 'midname_en'),
            'lastname_en' => CHtml::value($this, 'lastname_en'),
            'title_th' => CHtml::value($this, 'title_th'),
            'title_id_th' => CHtml::value($this, 'title_id_th'),
            'firstname_th' => CHtml::value($this, 'firstname_th'),
            'midname_th' => CHtml::value($this, 'midname_th'),
            'lastname_th' => CHtml::value($this, 'lastname_th'),
            'birth_date' => CHtml::value($this, 'birth_date'),
            'birth_date_th' => CHtml::value($this, 'birth_date_th'),
            'nationality_id' => CHtml::value($this, 'nationality_id'),
            'religion_id' => CHtml::value($this, 'religion_id'),
            'religion_other' => CHtml::value($this, 'religion_other'),
        );
        return $profile->save(false);
    }

}
