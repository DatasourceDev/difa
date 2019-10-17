<?php

Yii::import('application.models._base.BaseAccountProfileDiplomatThai');

class AccountProfileDiplomatThai extends BaseAccountProfileDiplomatThai implements IAccountProfile {

    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const DEGREE_PHD = 'P';
    const DEGREE_MASTER = 'M';
    const DEGREE_BACHELOR = 'B';
    const DEGREE_OTHER = 'O';
    const DIPLOMAT_TYPE_THAILAND = 'THAILAND';
    const DIPLOMAT_TYPE_OVERSEAS = 'OVERSEAS';
    const DIPLOMAT_POSITION_DIPLOMAT = 'DPMT';
    const DIPLOMAT_POSITION_TICA = 'TICA';

    public $emp_card_file;
    public $photo_file;
    public $overseaPosting;
    public $name_file;
    public $require_changename;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getGenderOptions($code = null) {
        $ret = array(
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getDiplomatTypeOptions($code = null) {
        $ret = array(
            self::DIPLOMAT_TYPE_THAILAND => 'In Thailand',
            self::DIPLOMAT_TYPE_OVERSEAS => 'Overseas Posting',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getDiplomatPositionOptions($code = null) {
        $ret = array(
            self::DIPLOMAT_POSITION_DIPLOMAT => 'Diplomat',
            self::DIPLOMAT_POSITION_TICA => 'TICA Staff',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getEducationDegreeOptions($code = null) {
        $ret = array(
            self::DEGREE_PHD => 'Ph.D.',
            self::DEGREE_MASTER => 'Master',
            self::DEGREE_BACHELOR => 'Bachelor',
            self::DEGREE_OTHER => 'Other',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getOverseaOfficeOptions($code = null) {
        $ret = array(
            'RTE' => 'RTE',
            'PR' => 'PR',
            'TTEO' => 'TTEO (Taipei)',
            'RCG' => 'RCG',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getDiplomatOfficeOptions() {
        $ret = array(
            'Office of the Minister',
            'Office of the Permanent Secretary',
            'Legal Affairs Group',
            'Public Sector Development Group',
            'International Security Unit',
            'General Affairs Division',
            'Personnel Management Bureau',
            'Financial Management Bureau',
            'Asset Procurement and Management Bureau',
            'Archives and Library Division',
            'Office of Policy and Planning',
            'Information and Communication Technology Centre',
            'Devawongse Varopakarn Institute of Foreign Affairs',
            'Internal Audit Group',
            'Department of Protocol',
            'Department of European Affairs',
            'Department of Internationl Economic Affairs',
            'Department of Treaties and Legal Affairs',
            'Department of Information',
            'Department of International Organizations',
            'Department of American and South Pacific Affairs',
            'Department of ASEAN Affairs',
            'Department of East Asian Affairs',
            'Department of South Asian, Middle East and African Affairs',
            'Department of Consular Affairs',
            'Thailand International Development Cooperation Agency (TICA)',
        );
        sort($ret);
        return $ret;
    }

    public static function getDiplomatLevelOptions($type, $code = null) {
        switch ($type) {
            case self::DIPLOMAT_TYPE_THAILAND:
                $ret = array(
                    'T01' => 'นักบริหารสูง / Executive, Higher Level',
                    'T02' => 'นักบริหารต้น / Executive, Primary Level',
                    'T03' => 'อำนวยการสูง / Director, Higher Level',
                    'T04' => 'เชี่ยวชาญ / Expert Level',
                    'T05' => 'อำนวยการต้น / Director, Primary Level',
                    'T06' => 'ผู้อำนวยการกอง / Director',
                    'T07' => 'ชำนาญการพิเศษ / Senior Professional Level',
                    'T08' => 'ชำนาญการ (ที่ปรึกษา) / Professional Level',
                    'T09' => 'ชำนาญการ (เลขานุการเอก) / Professional Level',
                    'T10' => 'ปฏิบัติการ (5) / Practitioner Level',
                    'T11' => 'ปฏิบัติการ (4) / Practitioner Level',
                    'T12' => 'ปฏิบัติการ (3) / Practitioner Level',
                );
                break;
            case self::DIPLOMAT_TYPE_OVERSEAS:
                $ret = array(
                    'O01' => 'เอกอัครราชทูต / Ambassador',
                    'O02' => 'อัครราชทูต / Minister',
                    'O03' => 'กงสุลใหญ่ / Consul-General',
                    'O04' => 'อัครราชทูตที่ปรึกษา / Minister Counsellor',
                    'O05' => 'รองกงสุลใหญ่ / Deputy Consul-General',
                    'O06' => 'ที่ปรึกษา / Counsellor',
                    'O07' => 'กงสุล / Consul',
                    'O08' => 'รองกงสุล / Vice-Consul',
                    'O09' => 'เลขานุการเอก / First Secretary',
                    'O10' => 'เลขานุการโท / Second Secretary',
                    'O11' => 'เลขานุการตรี / Third Secretary',
                    'O12' => 'นายเวร หรือ ผู้ช่วยเลขานุการ / Attache',
                );
                break;
            default:
                $ret = array();
                break;
        }
        $ret['9999'] = 'อื่นๆ / Other Level';

        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getWorkLevelOptions($code = null) {
        $ret = array(
            1 => 'ปลัดกระทรวง / เลขาธิการ',
            2 => 'รองปลัดกระทรวง / รองเลขาธิการ / อธิบดี',
            3 => 'นักบริหารสูง',
            4 => 'รองอธิบดี / ผู้ช่วยปลัดกระทรวง',
            5 => 'นักบริหารต้น',
            6 => 'ผู้อำนวยการสำนัก',
            7 => 'อำนวยการสูง',
            8 => 'เชี่ยวชาญ',
            9 => 'ผู้อำนวยการกอง',
            10 => 'อำนวยการต้น',
            11 => 'ชำนาญการพิเศษ',
            12 => 'ชำนาญการ',
            13 => 'ปฏิบัติการ',
            14 => 'อาวุโส',
            15 => 'ชำนาญงาน',
            16 => 'ปฏิบัติงาน',
            99 => 'อื่นๆ โปรดระบุ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'gender' => 'Gender',
            'title_id_th' => 'คำนำหน้า',
            'title_th' => 'โปรดระบุคำนำหน้า',
            'firstname_th' => 'First Name',
            'lastname_th' => 'Last Name',
            'title_id_en' => 'Title',
            'title_en' => 'Other Title',
            'firstname_en' => 'First Name',
            'midname_en' => 'Middle Name',
            'lastname_en' => 'Last Name',
            'religion_id' => 'Religion',
            'religion_other' => 'Other Religion',
            'nationality_id' => 'Nationality',
            'birth_date' => 'Date of Birth',
            'diplomat_type' => 'Place',
            'diplomat_level' => 'Level',
            'diplomat_level_other' => 'Other Level',
            'diplomat_position' => 'Position',
            'diplomat_office' => 'Office',
            'work_office_id' => 'Office',
            'work_office_other' => 'Office Name',
            'work_department' => 'Department',
            'work_position' => 'Position',
            'work_level' => 'Level',
            'work_level_other' => 'Other Level',
            'educate_degree' => 'Highest Education',
            'educate_subject' => 'Branch',
            'educate_university' => 'University/Institute',
            'educate_country' => 'Country',
            'reply_address_homeno' => 'House No.',
            'reply_address_building' => 'Building',
            'reply_address_floor' => 'Floor',
            'reply_address_soi' => 'Soi',
            'reply_address_street' => 'Street',
            'reply_address_province_id' => 'Province',
            'reply_address_amphur_id' => 'District',
            'reply_address_tumbon_id' => 'Subdistrict',
            'reply_address_postcode' => 'Postal Code',
            'emergency_name' => 'Fullname',
            'emergency_phone' => 'Phone',
            'contact_voip' => 'VOIP',
            'contact_fax' => 'Fax',
            'contact_mobile' => 'Mobile Phone',
            'contact_email' => 'email Address',
            'oversea_posting' => 'Overseas Posting',
            'photo_file' => 'Photo',
            'name_file' => 'Name Change Document',
            'work_year' => 'Joined MFA',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'nationality' => array(self::BELONGS_TO, 'CodeCountry', 'nationality_id'),
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
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
        ));
    }

    public function newProfileChangeDepartment() {
        $model = new ProfileChangeDepartment;
        $model->account_id = $this->account_id;
        $model->department_type_original = $this->diplomat_type;
        $model->department_original = $this->getTextDepartment();
        $model->office_original = $this->diplomat_office;
        $model->position_original = $this->diplomat_position;
        $model->level_original = $this->diplomat_level;
        return $model;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->title_en = strtoupper($this->title_en);
            $this->firstname_en = strtoupper($this->firstname_en);
            //$this->midname_en = strtoupper($this->midname_en);
            $this->lastname_en = strtoupper($this->lastname_en);


            if (!$this->isNewRecord) {
                $profile = self::model()->findByAttributes(array(
                    'account_id' => $this->account_id,
                ));

                if ($this->checkDepartmentChange($profile)) {
                    $model = new ProfileChangeDepartment;
                    $model->account_id = $profile->account_id;
                    $model->department_type_original = $profile->diplomat_type;
                    $model->department_original = $profile->getTextDepartment();
                    $model->office_original = $profile->diplomat_office;
                    $model->position_original = $profile->diplomat_position;
                    $model->level_original = $profile->diplomat_level;
                    $model->department_type = $this->diplomat_type;
                    $model->department = $this->getTextDepartment();
                    $model->office = $this->diplomat_office;
                    $model->position = $this->diplomat_position;
                    $model->level = $this->diplomat_level;
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

    public function checkDepartmentChange($model) {
        if ($this->diplomat_type <> $model->diplomat_type) {
            return true;
        }
        if ($this->diplomat_office <> $model->diplomat_office) {
            return true;
        }
        if ($this->diplomat_position <> $model->diplomat_position) {
            return true;
        }
        if ($this->diplomat_level <> $model->diplomat_level) {
            return true;
        }
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('photo_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedImageExtension()),
            array('contact_email', 'email'),
            array('gender, title_id_th, firstname_th, lastname_th, title_id_en, firstname_en, lastname_en, birth_date, nationality_id', 'required', 'on' => array('register', 'update')),
            array('title_en, firstname_en, lastname_en', 'match', 'pattern' => '/^([a-zA-Z0-9_ \.\-\(\)\/])+$/u', 'on' => array('register', 'update'), 'message' => 'Please use english alphabhets'),
            array('title_th, firstname_th, lastname_th', 'match', 'pattern' => '/[^a-z_\-0-9]/i', 'on' => array('register', 'update'), 'message' => 'Please use thai alphabhet'),
            array('diplomat_type, diplomat_position, diplomat_level, diplomat_office', 'required', 'on' => array('register', 'update')),
            array('diplomat_level', 'checkDiplomatLevel', array('register', 'update')),
            array('contact_email, contact_mobile, contact_mobile_country', 'required', 'on' => array('register', 'update')),
            array('oversea_posting', 'required', 'on' => array('register', 'update')),
            array('educate_bachelor, educate_bachelor_country, educate_bachelor_university, educate_bachelor_year_from, educate_bachelor_year_to', 'required', 'on' => array('register', 'update')),
            array('overseaPosting', 'safe'),
            /* changename */
            array('require_changename', 'checkChangeName', 'on' => 'update'),
            array('name_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedDocumentExtension(), 'on' => 'checkChangeName'),
        ));
    }

    public function checkDiplomatLevel() {
        if ($this->diplomat_level === '9999') {
            if (empty($this->diplomat_level_other)) {
                $this->addError('diplomat_level_other', Helper::t('Can not be blank.', 'กรุณาระบุข้อมูล'));
            }
        }
    }

    public function checkChangeName() {
        if ($this->require_changename) {
            $originalScenario = $this->scenario;
            $this->scenario = 'checkChangeName';
            $this->validate(null, false);
            $this->scenario = $originalScenario;
        }
    }

    public function validateRegister() {
        $originalScenario = $this->scenario;
        $this->scenario = 'register';
        $this->validate(null, false);
        $this->scenario = 'checkDiplomatLevel';
        $this->validate(null, false);
        $this->scenario = $originalScenario;
        if (!$this->hasErrors()) {
            return true;
        }
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

    public function getFullname() {
        return strtoupper($this->textTitleEn . ' ' . $this->firstname_en . ' ' . $this->lastname_en);
    }

    public function getFullnameTh() {
        return strtoupper($this->textTitleTh . $this->firstname_th . ' ' . $this->lastname_th);
    }

    public function getFullnameEn() {
        return strtoupper($this->textTitleEn . ' ' . $this->firstname_en . ' ' . $this->lastname_en);
    }

    public function afterFind() {
        parent::afterFind();
        $items = AccountOverseaPosting::model()->sortBy('op_number')->findAllByAttributes(array(
            'account_id' => $this->account_id,
        ));
        foreach ($items as $item) {
            $this->overseaPosting[$item->op_number] = array(
                'office' => CHtml::value($item, 'office'),
                'city' => CHtml::value($item, 'city'),
                'country' => CHtml::value($item, 'country'),
                'year_start' => CHtml::value($item, 'year_start'),
                'year_end' => CHtml::value($item, 'year_end'),
            );
        }
    }

    public function afterSave() {
        parent::afterSave();
        if (isset($this->overseaPosting) && is_array($this->overseaPosting)) {
            AccountOverseaPosting::model()->deleteAllByAttributes(array(
                'account_id' => $this->account_id,
            ));
            foreach ($this->overseaPosting as $num => $item) {
                $op = new AccountOverseaPosting;
                $op->account_id = $this->account_id;
                $op->op_number = $num;
                $op->office = CHtml::value($item, 'office');
                $op->city = CHtml::value($item, 'city');
                $op->country = CHtml::value($item, 'country');
                $op->year_start = CHtml::value($item, 'year_start');
                $op->year_end = CHtml::value($item, 'year_end');
                $op->save();
            }
        }
    }

    public function getTextDepartment() {
        return 'MINISTRY OF FOREIGN AFFAIRS';
    }

    public function getTextDepartmentTh() {
        return 'กระทรวงการต่างประเทศ';
    }

    public function getTextDepartmentForCard() {
        return $this->diplomat_office;
    }

    public function getTextContactPhone() {
        return $this->contact_mobile;
    }

    public function getTextWorkLevel() {
        if ($this->diplomat_level === '9999') {
            return self::getDiplomatLevelOptions($this->diplomat_type, $this->diplomat_level);
        }
        return $this->diplomat_level_other;
    }

    public function getReplyAddress() {
        return '';
    }

    public function getReplyAddressLine1() {
        return '';
    }

    public function getReplyAddressLine2() {
        return '';
    }

    public function getReplyAddressLine3() {
        return '';
    }

    public function getReplyAddressLine4() {
        return '';
    }

    public function getTextWorkPosition() {
        return $this->diplomat_position;
    }

    public function getTextWorkOffice() {
        return $this->diplomat_office;
    }

    public function getTextWorkOfficeTh() {
        return $this->diplomat_office;
    }

    public function getTextFirstnameEn() {
        return $this->firstname_en;
    }

    public function getTextFirstnameTh() {
        return $this->firstname_th;
    }

    public function getTextMidnameEn() {
        return '';
    }

    public function getTextMidnameTh() {
        return '';
    }

    public function getTextLastnameEn() {
        return $this->lastname_en;
    }

    public function getTextLastnameTh() {
        return $this->lastname_th;
    }

    public function getTextAnyPhone() {
        if ($this->contact_mobile) {
            return $this->contact_mobile;
        }
    }

    public function getTextContactMobile() {
        $mobile = str_replace('-', '', $this->contact_mobile);
        if (strpos($this->contact_mobile, '0') !== 0) {
            return '0' . $this->contact_mobile;
        }
        return $this->contact_mobile;
    }

    public function getPhotoUrl() {
        if (CHtml::value($this, 'empCardFile.filePath')) {
            return CHtml::value($this, 'empCardFile.fileUrl');
        }
        if (CHtml::value($this, 'passportFile.filePath')) {
            return CHtml::value($this, 'passportFile.fileUrl');
        }
        if (isset($this->emp_pic_file)) {
            return Yii::app()->baseUrl . '/uploads/emp/' . $this->emp_pic_file;
        }
        return Yii::app()->baseUrl . '/images/card-placeholder.png';
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
