<?php

Yii::import('application.models._base.BaseAccountProfileGeneralForeigner');

class AccountProfileGeneralForeigner extends BaseAccountProfileGeneralForeigner implements IAccountProfile {

    const EMP_PASSPORT = '0';
    const EMP_SELF = '1';
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const DEGREE_PHD = 'P';
    const DEGREE_MASTER = 'M';
    const DEGREE_BACHELOR = 'B';
    const DEGREE_OTHER = 'O';

    public $passport_file;
    public $self_file;
    public $photo_file;
    public $name_file;
    public $require_changename;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getEmpTypeOptions($code = null) {
        $ret = array(
            self::EMP_PASSPORT => 'Passport',
            self::EMP_SELF => 'ID / letter of certify identity',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getGenderOptions($code = null) {
        $ret = array(
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
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

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'emp_type' => 'Type of Document',
            'gender' => 'Gender',
            'title_id_en' => 'Title',
            'title_en' => 'Other Title',
            'firstname_en' => 'First Name',
            'midname_en' => 'Middle Name',
            'lastname_en' => 'Last Name',
            'religion_id' => 'Religion',
            'religion_other' => 'Other Religion',
            'nationality_id' => 'Nationality',
            'birth_date' => 'Date of Birth',
            'work_office_id' => 'Agency',
            'work_office_other' => 'Agency',
            'work_department' => 'Department',
            'work_position' => 'Position',
            'work_level' => 'Level',
            'work_level_other' => 'Level',
            'educate_degree' => 'Degree',
            'educate_degree_other' => 'Other Degree',
            'educate_subject' => 'Subject',
            'educate_university' => 'University/Institute',
            'educate_country' => 'Country',
            'work_address' => 'Address',
            'work_address_country_id' => 'Country',
            'work_address_postcode' => 'Postal Code',
            'reply_address' => 'Address',
            'reply_address_country_id' => 'Country',
            'reply_address_postcode' => 'Postal Code',
            'emergency_name' => 'Full Name',
            'emergency_phone' => 'Phone',
            'passport_no' => 'Passport No.',
            'passport_issue_country' => 'Issuing Country',
            'passport_issue_date' => 'Date of Issue',
            'passport_expire_date' => 'Date of Expiry',
            'passport_file' => 'Passport Image',
            'contact_phone' => 'Office Phone',
            'contact_fax' => 'Fax',
            'contact_mobile' => 'Mobile Phone',
            'contact_email' => 'email Address',
            'photo_file' => 'Photo',
            'name_file' => 'Name Change Document',
            'work_year' => 'Work Year',
            'emp_pic_file' => 'File Attachment',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'nationality' => array(self::BELONGS_TO, 'CodeCountry', 'nationality_id'),
            'replyAddressCountry' => array(self::BELONGS_TO, 'CodeCountry', 'reply_address_country_id'),
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'passportFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'passport_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'protected/uploads/profile',
                'prefix' => 'passport_',
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
        $model->department_original = $this->getTextDepartment();
        $model->office_original = $this->work_department;
        $model->position_original = $this->work_position;
        $model->level_original = $this->getTextWorkLevel();
        return $model;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->title_en = strtoupper($this->title_en);
            $this->firstname_en = strtoupper($this->firstname_en);
            $this->midname_en = strtoupper($this->midname_en);
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
                    $model->department_original = $profile->getTextDepartment();
                    $model->office_original = $profile->work_department;
                    $model->position_original = $profile->work_position;
                    $model->level_original = $profile->getTextWorkLevel();
                    $model->department = $this->getTextDepartment();
                    $model->office = $this->work_department;
                    $model->position = $this->work_position;
                    $model->level = $this->getTextWorkLevel();
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
        if ($this->getTextDepartment() <> $model->getTextDepartment()) {
            return true;
        }
        if ($this->work_department <> $model->work_department) {
            return true;
        }
        if ($this->work_position <> $model->work_position) {
            return true;
        }
        if ($this->work_level <> $model->work_level) {
            return true;
        }
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->is_same_address === self::YES) {
                $this->reply_address = $this->work_address;
                $this->reply_address_country_id = $this->work_address_country_id;
                $this->reply_address_postcode = $this->work_address_postcode;
            }
            $this->work_office_other = strtoupper($this->work_office_other);
            return true;
        }
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            /* scenario : all */
            array('emp_type', 'required'),
            array('photo_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedImageExtension()),
            array('work_office_other', 'match', 'pattern' => '/^([a-zA-Z0-9_ \.\-\(\)\/])+$/u', 'on' => 'register', 'message' => 'Please use english characters only.'),
            array('contact_email', 'email'),
            array('is_same_address', 'safe'),
            /* scenario : register, update */
            array('gender, title_id_en, title_en, firstname_en, lastname_en, birth_date, nationality_id', 'required', 'on' => array('register', 'update')),
            array('work_office_other, work_position', 'required', 'on' => array('register', 'update')),
            array('educate_degree, educate_degree_other, educate_subject, educate_university, educate_country', 'required', 'on' => array('register', 'update')),
            array('work_address, work_address_country_id, work_address_postcode', 'required', 'on' => array('register', 'update')),
            array('reply_address, reply_address_country_id, reply_address_postcode', 'required', 'on' => array('register', 'update')),
            array('contact_mobile_country, contact_mobile, contact_email', 'required', 'on' => array('register', 'update')),
            /* scenario : registerByOffice */
            array('gender, title_id_en, title_en, firstname_en, lastname_en, birth_date, nationality_id', 'required', 'on' => array('registerByOffice', 'updateByOffice')),
            array('contact_email', 'required', 'on' => array('registerByOffice', 'updateByOffice')),
            array('title_en, firstname_en, lastname_en', 'match', 'pattern' => '/^([a-zA-Z0-9_ \.\-\(\)\/])+$/u', 'message' => 'Please use english alphabhet', 'on' => array('registerByOffice', 'updateByOffice')),
            /* scenario : checkIdentityCard */
            array('passport_no, passport_issue_date, passport_expire_date', 'required', 'on' => 'checkIdentityCard,checkIdentityCardUpdate'),
            array('emp_pic_file', 'required', 'on' => array('checkIdentityCard', 'checkIdentityCardUpdate')),
            array('passport_expire_date', 'compare', 'compareAttribute' => 'passport_issue_date', 'operator' => '>', 'on' => 'checkIdentityCard,checkIdentityCardUpdate'),
            array('passport_expire_date', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>', 'on' => 'checkIdentityCard,checkIdentityCardUpdate'),
            /* scenario : checkSelfIdentity */
            array('self_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedDocumentExtension(), 'on' => 'checkSelfIdentity'),
            array('self_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedDocumentExtension(), 'on' => 'checkSelfIdentityUpdate'),
            /* changename */
            array('require_changename', 'checkChangeName', 'on' => 'update'),
            array('name_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedDocumentExtension(), 'on' => 'checkChangeName'),
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

    public function validateRegister() {
        $originalScenario = $this->scenario;
        $this->scenario = 'register';
        $this->validate(null, false);
        switch ($this->emp_type) {
            case self::EMP_PASSPORT:
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

    public function getFullname() {
        return strtoupper($this->title_en . ' ' . $this->firstname_en . ' ' . $this->midname_en . ' ' . $this->lastname_en);
    }

    public function getFullnameTh() {
        return strtoupper($this->title_en . ' ' . $this->firstname_en . ' ' . $this->midname_en . ' ' . $this->lastname_en);
    }

    public function getFullnameEn() {
        return strtoupper($this->title_en . ' ' . $this->firstname_en . ' ' . $this->midname_en . ' ' . $this->lastname_en);
    }

    public function getTextDepartment() {
        return strtoupper($this->work_office_other);
    }

    public function getTextDepartmentTh() {
        return strtoupper($this->work_office_other);
    }

    public function getTextDepartmentForCard() {
        return $this->getTextDepartment();
    }

    public function getTextWorkLevel() {
        return $this->work_level_other;
    }

    public function getReplyAddress() {
        return $this->getReplyAddressLine1() . "\n" . $this->getReplyAddressLine2();
    }

    public function getReplyAddressLine1() {
        return $this->reply_address;
    }

    public function getReplyAddressLine2() {
        return CHtml::value($this, 'replyAddressCountry.name_en') . ' ' . $this->reply_address_postcode;
    }

    public function getReplyAddressLine3() {
        return '';
    }

    public function getReplyAddressLine4() {
        return '';
    }

    public function getTextContactPhone() {
        return $this->contact_phone;
    }

    public function getTextWorkPosition() {
        return $this->work_position;
    }

    public function getTextWorkOffice() {
        return $this->work_department;
    }

    public function getTextWorkOfficeTh() {
        return $this->work_department;
    }

    public function getTextFirstnameEn() {
        return $this->firstname_en;
    }

    public function getTextFirstnameTh() {
        return $this->firstname_en;
    }

    public function getTextMidnameEn() {
        return $this->midname_en;
    }

    public function getTextMidnameTh() {
        return $this->midname_en;
    }

    public function getTextLastnameEn() {
        return $this->lastname_en;
    }

    public function getTextLastnameTh() {
        return $this->lastname_en;
    }

    public function getTextTitleEn() {
        return $this->title_en;
    }

    public function getTextTitleTh() {
        return $this->title_en;
    }

    public function getTextAnyPhone() {
        if ($this->contact_phone) {
            return $this->contact_phone;
        }
        if ($this->contact_mobile) {
            return $this->contact_mobile;
        }
    }

    public function getTextContactMobile() {
        return $this->contact_mobile_country . ' ' . $this->contact_mobile;
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
