<?php

Yii::import('application.models._base.BaseAccount');

class Account extends BaseAccount {

    const STATUS_DELETED = '-1';
    const STATUS_NEW = '0';
    const STATUS_ACTIVED = '1';
    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const DEGREE_PHD = 'P';
    const DEGREE_MASTER = 'M';
    const DEGREE_BACHELOR = 'B';
    const DEGREE_OTHER = 'O';

    public $title;
    public $password_input;
    public $password_confirm;
    public $is_agree;
    public $verifyCode;
    public $cProfile;
    public $secure_answer_num;
    public $secure_answer_input;
    public $default_exam_schedule_id;
    public $default_max_quota;
    public $email;
    public $account_type_id_new;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function encrypt($str) {
        return PasswordStorage::create_hash($str);
    }

    public static function encryptLegacy($str) {
        return md5($str);
    }

    public function validatePassword() {
        if ($this->is_legacy && $this->legacy_secret) {
            return $this->legacy_secret === self::encryptLegacy($this->password_input);
        } else {
            return PasswordStorage::verify_password($this->password_input, $this->secret);
        }
    }

    public static function getStatusOptions($code = null) {
        $ret = array(
            self::STATUS_ACTIVED => Helper::t('Actived', 'ยืนยันบัญชีแล้ว'),
            self::STATUS_NEW => Helper::t('Not Active', 'ยังไม่ได้ยืนยันบัญชี'),
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getGenderOptions($code = null) {
        $ret = array(
            self::GENDER_MALE => 'Male / ชาย',
            self::GENDER_FEMALE => 'Female / หญิง',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getEducationDegreeOptions($code = null) {
        $ret = array(
            self::DEGREE_PHD => 'Ph.D. / ปริญญาเอก',
            self::DEGREE_MASTER => 'Master / ปริญญาโท',
            self::DEGREE_BACHELOR => 'Bachelor / ปริญญาตรี',
            self::DEGREE_OTHER => 'Other / อื่นๆ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getSecureQuestionOptions($unset = null) {
        if (Yii::app()->language === 'th') {
            $ret = array(
                '01' => 'สีที่ชอบ',
                '03' => 'สัตว์เลี้ยงสุดโปรด',
                '05' => 'ปีเกิดของคุณ',
                '07' => 'กีฬาที่คุณชอบที่สุด',
                '08' => 'ชื่อโรงเรียนสมัยประถม',
                '09' => 'ร้านอาหารโปรดของคุณ',
                '10' => 'เมืองที่คุณเกิด',
            );
        } else {
            $ret = array(
                '01' => 'Your favorite colour?',
                '03' => 'Your pet\'s name?',
                '05' => 'Your birth year?',
                '07' => 'Your favorite sport?',
                '08' => 'Your lucky number?',
                '09' => 'Your favorite restaurant?',
                '10' => 'Place of birth?',
            );
        }
        if (isset($unset) && isset($ret[$unset])) {
            unset($ret[$unset]);
        }
        return $ret;
    }

    public static function getDepartmentClassOptions() {
        $ret = array();
        for ($i = 10; $i >= 1; $i--) {
            $ret[$i] = 'ระดับ ' . $i;
        }
        $ret['O'] = 'Other / อื่นๆ';
        return $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'entry_code' => Yii::app()->language === 'th' ? 'เลขบัตรประจำตัวประชาชน' : 'ID No.',
            'password_input' => Yii::app()->language === 'th' ? 'รหัสผ่าน' : 'Password',
            'password_confirm' => Yii::app()->language === 'th' ? 'ยืนยันรหัสผ่าน' : 'Confirm Password',
            'is_agree' => Yii::app()->language === 'th' ? 'ยอมรับข้อตกลงการให้บริการ' : 'I agree.',
            'secure_answer_input' => 'คำตอบ',
            'verifyCode' => 'Verification Code',
            'secure_question_1' => Yii::app()->language === 'th' ? 'คำถามที่ 1' : 'Question 1',
            'secure_answer_1' => Yii::app()->language === 'th' ? 'คำตอบ' : 'Answer',
            'secure_question_2' => Yii::app()->language === 'th' ? 'คำถามที่ 2' : 'Question 2',
            'secure_answer_2' => Yii::app()->language === 'th' ? 'คำตอบ' : 'Answer',
            'status' => Helper::t('Status', 'สถานะบัญชี'),
            'account_type_id' => Yii::app()->language === 'th' ? 'ประเภทสมาชิก' : 'Member Type',
            'account_type_id_new' => Yii::app()->language === 'th' ? 'ประเภทสมาชิก' : 'Member Type',
        ));
    }

    public function afterFind() {
        parent::afterFind();
        if (isset($this->examScheduleAccount)) {
            $this->default_max_quota = $this->examScheduleAccount->preserved_quota;
        }
    }

    public function afterSave() {
        parent::afterSave();
        if (isset($this->examScheduleAccount)) {
            if ($this->examScheduleAccount->preserved_quota <> $this->default_max_quota) {
                $this->examScheduleAccount->preserved_quota = $this->default_max_quota;
                $this->examScheduleAccount->max_quota = $this->default_max_quota;
                $this->examScheduleAccount->save();
            }
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (!empty($this->password_input)) {
                if (CHtml::value($this, 'accountType.table_name') === 'accountProfileOfficeUser') {
                    $this->tmp_password = $this->password_input;
                }
            }
            switch ($this->scenario) {
                case 'createGeneralThai':
                case 'createGeneralForeigner':
                case 'createDiplomatThai':
                case 'createDiplomatForeigner':
                case 'createGeneralThaiByStaff':
                case 'createGeneralForeignerByStaff':
                case 'createDiplomatThaiByStaff':
                case 'createDiplomatForeignerByStaff':
                case 'createOfficeUser':
                case 'changePassword':
                    if (!empty($this->password_input)) {
                        $this->secret = self::encrypt($this->password_input);

                        /* Legacy Removal */
                        if ($this->is_legacy) {
                            $this->is_legacy = self::NO;
                            $this->legacy_secret = null;
                        }

                        if (CHtml::value($this, 'accountType.table_name') !== 'accountProfileOfficeUser') {
                            $this->tmp_password = null;
                        }
                    }
                    break;
            }
            switch ($this->scenario) {
                case 'createGeneralThai':
                case 'createBulkGeneralThai':
                case 'createDiplomatThai':
                case 'createGeneralThaiByStaff':
                case 'createDiplomatThaiByStaff':
                    $this->username = $this->entry_code;
                    break;
                case 'createGeneralForeigner':
                case 'createBulkGeneralForeigner':
                case 'createDiplomatForeigner':
                case 'createGeneralForeignerByStaff':
                case 'createDiplomatForeignerByStaff':
                    $key = KeyCounter::getNewKey('foreigner_register');
                    $this->username = 'F' . CHtml::value($this, 'cProfile.nationality_id') . CHtml::value($this, 'cProfile.passport_issue_country', '999') . str_pad($key, 6, '0', STR_PAD_LEFT);
                    $this->entry_code = $this->username;
                    break;
                case 'createOfficeUser':
                    $this->username = $this->entry_code;
                    break;
            }
            return true;
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                /* ลบข้อมูลส่วนตัว */
                AccountProfileDiplomatForeigner::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                AccountProfileDiplomatThai::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                AccountProfileGeneralForeigner::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                AccountProfileGeneralThai::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                AccountProfileOfficeUser::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                foreach ($this->examApplications as $item) {
                    $item->delete();
                }

                foreach ($this->accountOverseaPostings as $item) {
                    $item->delete();
                }

                ExamScheduleAccount::model()->deleteAllByAttributes(array(
                    'account_id' => $this->id,
                ));
                $transaction->commit();
                return true;
            } catch (CException $e) {
                $transaction->rollback();
                throw new CHttpException(500, $e->getMessage());
            }
        }
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

    public function getIsLegacy() {
        return $this->is_legacy == 0 ? false : true;
    }

    public function getIsEnable() {
        return $this->is_disable == 0 ? true : false;
    }

    public function getProfile() {
        return $this->{$this->accountType->table_name};
    }

    public function getDefaultLanguage() {
        return CHtml::value($this, 'accountType.isForeigner') ? 'en' : 'th';
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'accountTypeNew' => array(self::BELONGS_TO, 'AccountType', 'account_type_id_new'),
            'accountProfile' => array(self::HAS_ONE, 'AccountProfile', 'id'),
            'countExamApplication' => array(self::STAT, 'ExamApplication', 'account_id'),
            'examScheduleAccount' => array(self::HAS_ONE, 'ExamScheduleAccount', '', 'foreignKey' => array('account_id' => 'id'))
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('cProfile', 'safe'),
            array('password_input, password_confirm', 'length', 'min' => 8),
            array('password_confirm', 'compare', 'compareAttribute' => 'password_input'),
            /* Login */
            array('username ,password_input', 'required', 'on' => 'login'),
            array('password_input', 'checkLogin', 'on' => 'login'),
            /* Check existing account */
            array('username ,password_input, password_confirm', 'required', 'on' => 'checkExistingAccount'),
            /* Change Password */
            array('password_input, password_confirm', 'required', 'on' => 'changePassword'),
            /* Forgot */
            array('username', 'required', 'on' => 'forgot'),
            array('username', 'checkForgot', 'on' => 'forgot'),
            /* Forgot Question */
            array('secure_answer_input, secure_answer_num', 'required', 'on' => 'forgotQuestion'),
            array('secure_answer_input', 'checkForgotQuestion', 'on' => 'forgotQuestion'),
            array('secure_answer_num', 'safe'),
            /*  Register - General - Thai */
            array('entry_code, password_input, password_confirm', 'required', 'on' => 'createGeneralThai, createGeneralThaiByStaff'),
            array('entry_code', 'length', 'min' => 13, 'max' => 13, 'on' => 'createGeneralThai, createGeneralThaiByStaff'),
            array('entry_code', 'numerical', 'integerOnly' => true, 'on' => 'createGeneralThai, createGeneralThaiByStaff'),
            array('entry_code', 'checkCitizenDigit', 'on' => 'createGeneralThai, createGeneralThaiByStaff'),
            array('entry_code', 'unique', 'on' => 'createGeneralThai, createGeneralThaiByStaff', 'message' => 'เลขบัตรประจำตัวประชาชน เคยใช้ในการสมัครสมาชิกแล้ว'),
            array('is_agree', 'required', 'on' => 'createGeneralThai', 'message' => 'กรุณายอมรับข้อตกลงก่อนสมัครสมาชิก'),
            array('secure_question_1, secure_answer_1, secure_question_2, secure_answer_2', 'required', 'on' => 'createGeneralThai'),
            array('verifyCode', 'checkReCaptcha', 'on' => 'createGeneralThai'),
            /*  Register - General - Bulk - Thai */
            array('entry_code', 'required', 'on' => 'createBulkGeneralThai'),
            array('entry_code', 'length', 'min' => 13, 'max' => 13, 'on' => 'createBulkGeneralThai'),
            array('entry_code', 'numerical', 'integerOnly' => true, 'on' => 'createBulkGeneralThai'),
            array('entry_code', 'checkCitizenDigit', 'on' => 'createBulkGeneralThai'),
            array('entry_code', 'unique', 'on' => 'createBulkGeneralThai', 'message' => 'เลขบัตรประจำตัวประชาชน เคยใช้ในการสมัครสมาชิกแล้ว'),
            /* Register - General - Foreigner */
            array('password_input, password_confirm', 'required', 'on' => 'createGeneralForeigner, createGeneralForeignerByStaff'),
            array('verifyCode', 'checkReCaptcha', 'on' => 'createGeneralForeigner'),
            array('is_agree', 'required', 'on' => 'createGeneralForeigner', 'message' => 'Please accept agreement before submit'),
            array('secure_question_1, secure_answer_1, secure_question_2, secure_answer_2', 'required', 'on' => 'createGeneralForeigner'),
            /*  Register - Diplomat - Thai */
            array('entry_code, password_input, password_confirm', 'required', 'on' => 'createDiplomatThai, createDiplomatThaiByStaff'),
            array('entry_code', 'length', 'min' => 13, 'max' => 13, 'on' => 'createDiplomatThai, createDiplomatThaiByStaff'),
            array('entry_code', 'numerical', 'integerOnly' => true, 'on' => 'createDiplomatThai, createDiplomatThaiByStaff'),
            array('entry_code', 'checkCitizenDigit', 'on' => 'createDiplomatThai, createDiplomatThaiByStaff'),
            array('entry_code', 'unique', 'on' => 'createDiplomatThai, createDiplomatThaiByStaff', 'message' => 'เลขบัตรประจำตัวประชาชน เคยใช้ในการสมัครสมาชิกแล้ว'),
            array('is_agree', 'required', 'on' => 'createDiplomatThai', 'message' => 'Please accept agreement before submit'),
            array('secure_question_1, secure_answer_1, secure_question_2, secure_answer_2', 'required', 'on' => 'createDiplomatThai'),
            array('verifyCode', 'checkReCaptcha', 'on' => 'createDiplomatThai'),
            /* Register - Diplomat - Foreigner */
            array('password_input, password_confirm', 'required', 'on' => 'createDiplomatForeigner, createDiplomatForeignerByStaff'),
            array('verifyCode', 'checkReCaptcha', 'on' => 'createDiplomatForeigner'),
            array('is_agree', 'required', 'on' => 'createDiplomatForeigner', 'message' => 'Please accept agreement before submit'),
            array('secure_question_1, secure_answer_1, secure_question_2, secure_answer_2', 'required', 'on' => 'createDiplomatForeigner'),
            /* Register - OfficeUser */
            array('entry_code', 'unique', 'on' => 'createOfficeUser', 'message' => 'ชื่อบัญชีนี้มีผู้ใช้งานแล้ว'),
            array('entry_code, password_input, password_confirm, default_exam_schedule_id, default_max_quota', 'required', 'on' => 'createOfficeUser'),
            array('default_max_quota', 'checkMaxQuota', 'on' => 'createOfficeUser', 'updateOfficeUser'),
            array('search', 'safe', 'on' => 'search'),
            /* Takeback */
            array('email', 'required', 'on' => 'doTackback'),
            array('email', 'email', 'on' => 'doTackback'),
            /* ChangeType */
            array('account_type_id_new', 'required', 'on' => 'changeType'),
        ));
    }

    public function checkReCaptcha($attribute) {
        $this->{$attribute} = Yii::app()->request->getPost('g-recaptcha-response');
        $result = Helper::post(CHtml::value(Yii::app()->params, 'reCaptcha.url'), array(
                    'secret' => CHtml::value(Yii::app()->params, 'reCaptcha.secret'),
                    'response' => $this->{$attribute},
                    'remoteip' => Yii::app()->request->userHostAddress,
                        ), 'json');
        if (!CHtml::value($result, 'success')) {
            switch ($this->account_type_id) {
                case '1':
                case '3':
                    $this->addError($attribute, 'กรุณายืนยันรหัสป้องกัน');
                    break;
                default:
                    $this->addError($attribute, 'Please check this.');
                    break;
            }
        }
    }

    public function checkDuplicateOffice($attribute) {
        $model = Account::model()->findByAttributes(array(
            'entry_code' => $this->{$attribute},
        ));
        if (isset($model) && $model->getIsOfficeUser()) {
            $this->addError($attribute, '');
        }
    }

    public function checkMaxQuota() {
        $schedule = ExamSchedule::model()->findByPk($this->default_exam_schedule_id);
        $count = $schedule->getCountSeatAvailable();
        if ($count < $this->default_max_quota) {
            $this->addError('default_max_quota', 'ไม่สามารถตั้งโควต้ามากกว่าจำนวนที่นั่ง (เหลือ ' . $count . ' ที่นั่ง)');
        }
    }

    public function checkForgotQuestion($attribute) {
        $input = 'secure_answer_' . ($this->secure_answer_num);
        if ($this->{$input} !== $this->secure_answer_input) {
            $this->addError($attribute, 'คำตอบไม่ถูกต้อง');
        }
    }

    public function checkForgot($attribute) {
        $model = Account::model()->findByAttributes(array(
            'username' => $this->{$attribute},
            'status' => self::STATUS_ACTIVED,
        ));
        if (isset($model)) {
            $this->id = $model->id;
        } else {
            $this->addError($attribute, 'ไม่พบชื่อบัญชีที่ตรงกัน');
        }
    }

    public function checkCitizenDigit($attribute) {
        $personID = $this->{$attribute};
        if (strlen($personID) != 13) {
            return false;
        }
        $rev = strrev($personID);
        $total = 0;
        for ($i = 1; $i < 13; $i++) {
            $mul = $i + 1;
            $count = $rev [$i] * $mul;
            $total = $total + $count;
        }
        $mod = $total % 11;
        $sub = 11 - $mod;
        $check_digit = $sub % 10;
        if ($rev[0] == $check_digit) {

            return true;
        } else {
            $this->addError($attribute, 'รูปแบบไม่ถูกต้อง');
        }
    }

    public function getFullname() {
        return $this->firstname_en . ' ' . $this->lastname_en;
    }

    public function checkLogin($attribute) {
        $identity = new UserIdentity($this->username, $this->password_input);
        if (!$identity->authenticate()) {
            $this->addError($attribute, 'รหัสผ่านไม่ถูกต้อง');
        }
    }

    public function login() {
        $identity = new UserIdentity($this->username, $this->password_input);
        if ($identity->authenticate()) {
            Yii::app()->user->login($identity);
            return true;
        }
    }

    public function confirm($code) {
        if ($this->confirmation_code === $code) {
            $this->confirmation_date = new CDbExpression('NOW()');
            return $this->doActivate();
        }
    }

    public function doActivate() {
        $this->status = self::STATUS_ACTIVED;
        if ($this->save()) {
            return true;
        }
    }

    public function disable() {
        $this->status = self::STATUS_DELETED;
        return $this->save();
    }

    public function withOfficeUser() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'accountType' => array(
                'together' => true,
            ),
        );
        $criteria->compare('accountType.table_name', 'accountProfileOfficeUser');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    /**
     * ตรวจสอบบัญชีที่เคยสมัคร
     * @param mixed $data Array of entry_code, password_input, password_confirm, birth_date
     * @return boolean
     * @return Account 
     */
    public function checkExistingAccount($data = array()) {
        $this->attributes = $data;
        if (!$this->validate(array(
                    'entry_code',
                    'password_input',
                    'password_confirm',
                ))) {
            return false;
        }
        if (!CHtml::value($data, 'birth_date')) {
            $this->addError('entry_code', 'birth_date is required');
            return false;
        }
        $account = Account::model()->findByAttributes(array(
            'entry_code' => $this->entry_code,
            'secret' => self::encrypt($this->password_input),
        ));
        if (isset($account)) {
            if (CHtml::value($account, 'profile.birth_date') === CHtml::value($data, 'birth_date')) {
                return $account;
            }
        }
        return false;
    }

    public function scopeForeigner() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'accountType' => array(
                'together' => true,
            ),
        );
        $criteria->compare('accountType.is_foreigner', self::YES);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function scopeMaybeDuplicate() {
        $criteria = new CDbCriteria();

        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function scopeAccountProfile($tb_name) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'accountType' => array(
                'together' => true,
            ),
        );
        $criteria->compare('accountType.table_name', $tb_name);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getEntryCode() {
        switch ($this->accountType->table_name) {
            case 'accountProfileGeneralThai':
            case 'accountProfileDiplomatThai':
                return substr($this->username, 0, 1) . ' ' . substr($this->username, 1, 4) . ' ' . substr($this->username, 5, 5) . ' ' . substr($this->username, 10, 2) . ' ' . substr($this->username, 12, 1);
            case 'accountProfileGeneralForeigner':
            case 'accountProfileDiplomatForeigner':
                return $this->username;
            default:
                return $this->username;
        }
    }

    public function getHtmlExpireDate() {
        if (isset($this->examSchedule)) {
            return $this->examSchedule->getHtmlExpireDate();
        }
        return '<span class="text-muted">no expiry date</span>';
    }

    public function getMsisdn() {
        $country = str_replace(array('-', ' ', '+'), '', CHtml::value($this, 'profile.contact_mobile_country'));
        if ($country === '') {
            $country = '66';
        }
        $mobile = str_replace(array('-', ' ', '+'), '', CHtml::value($this, 'profile.contact_mobile'));
        if (substr($mobile, 0, 1) === '0') {
            $mobile = substr($mobile, 1, strlen($mobile));
        }
        return $country . $mobile;
    }

    public function doRequestResetPassword() {
        if ($this->validate()) {
            $this->isNewRecord = false;
            $this->tmp_password = substr(sha1(rand(0, 99999)), 0, 16);
            if ($this->save(false)) {
                Mailer::sendResetPassword(CHtml::value($this, 'profile.contact_email'), array(
                    'data' => array(
                        'model' => $this,
                    ),
                ));
                return true;
            }
        }
    }

    public function scopeMember() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'accountType' => array(
                'together' => true,
            ),
        );
        $criteria->compare('accountType.table_name', '<>accountProfileOfficeUser');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function search() {
        $dataProvider = parent::search();

        if (!empty($this->search['username'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'accountProfile' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('accountProfile.username', $this->search['username'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['firstname'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'accountProfile' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('accountProfile.firstname', $this->search['firstname'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['lastname'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'accountProfile' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('accountProfile.lastname', $this->search['lastname'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }


        return $dataProvider;
    }

    public function scopeOfficeUser() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'accountType' => array(
                'together' => true,
            ),
        );
        $criteria->compare('accountType.table_name', 'accountProfileOfficeUser');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getIsForeign() {
        if (CHtml::value($this, 'accountType.is_foreigner') === self::YES) {
            return true;
        }
    }

    public function getIsOfficeUser() {
        if ($this->is_office_user === self::YES) {
            return true;
        }
        return false;
    }

    public function getLatestOfficeUser() {
        $model = ExamApplication::model()->sortBy('created DESC')->findByAttributes(array(
            'account_id' => $this->id,
        ));
        return Account::model()->findByPk(CHtml::value($model, 'office_user_id'));
    }

    public function doTakeback() {
        if ($this->validate()) {
            $this->tmp_password = substr(sha1(rand(0, 99999)), 0, 16);
            if ($this->save(false)) {

                $profile = $this->getProfile();
                if (isset($profile) && isset($profile->contact_email)) {
                    $profile->contact_email = $this->email;
                    $profile->save();
                }
                Mailer::sendResetPassword(CHtml::value($this, 'email'), array(
                    'data' => array(
                        'model' => $this,
                    ),
                ));
                return true;
            }
        }
    }

    public function doChangeType() {
        if (!$this->validate()) {
            return false;
        }

        if ($this->account_type_id_new == $this->account_type_id) {
            return true;
        }
        $log = new ProfileChangeType;
        $log->account_id = $this->id;
        $log->account_type_id_original = $this->account_type_id;
        $log->account_type_id = $this->account_type_id_new;

        $profile = $this->getProfile();
        $this->account_type_id = $this->account_type_id_new;
        if ($this->save()) {
            if ($profile->createProfileOfType($this->account_type_id)) {
                if ($log->save()) {
                    return true;
                } else {
                    var_dump($profile->errors, 1);
                    exit;
                }
            } else {
                var_dump($profile->errors, 2);
                exit;
            }
        } else {
            var_dump($this->errors, 3);
            exit;
        }
    }

}
