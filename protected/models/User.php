<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser {

    public $password_input;
    public $password_confirm;

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

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'username' => 'ชื่อบัญชี',
            'password_input' => 'รหัสผ่าน',
            'password_confirm' => 'ยืนยันรหัสผ่าน',
            'email' => 'อีเมล์',
            'role_id' => 'กลุ่มผู้ใช้งาน',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('username', 'unique', 'on' => 'insert, update'),
            array('email', 'email'),
            array('username', 'match', 'pattern' => '/^([a-z0-9_\-])+$/', 'message' => 'เฉพาะอักษร a-z หรือ 0-9 เท่านั้น'),
            array('username, password_input, password_confirm', 'length', 'min' => 4, 'max' => 64),
            /* Login */
            array('username ,password_input', 'required', 'on' => 'login, loginByManager'),
            array('password_input', 'checkLogin', 'on' => 'login'),
            array('password_input', 'checkLoginByManager', 'on' => 'loginByManager'),
            /* Insert */
            array('username, email ,password_input, password_confirm, role_id', 'required', 'on' => 'insert'),
            array('username', 'required', 'on' => 'update'),
            array('password_input', 'safe', 'on' => 'update'),
            array('password_confirm', 'compare', 'compareAttribute' => 'password_input', 'on' => 'insert, update'),
        ));
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->username = strtolower($this->username);
            return true;
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            UserActivityLog::model()->deleteAllByAttributes(array(
                'user_id' => $this->id,
            ));
            return true;
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            switch ($this->scenario) {
                case 'insert':
                case 'update':
                    if ($this->password_input) {
                        $this->secret = self::encrypt($this->password_input);
                        /* Legacy Removal */
                        if ($this->is_legacy) {
                            $this->is_legacy = self::NO;
                            $this->legacy_secret = null;
                        }
                    }
                    break;
            }
            return true;
        }
    }

    public function checkLogin($attribute) {
        $identity = new AdministratorUserIdentity($this->username, $this->password_input);
        if (!$identity->authenticate()) {
            $this->addError($attribute, 'รหัสผ่านไม่ถูกต้อง');
        }
    }

    public function login() {
        $identity = new AdministratorUserIdentity($this->username, $this->password_input);
        if ($identity->authenticate()) {
            $log = new UserActivityLog;
            $log->user_id = $this->id;
            $log->message = 'Login Successfully.';
            $log->save();
            Yii::app()->user->login($identity);
            return true;
        }
    }

    public function checkLoginByManager($attribute) {
        $identity = new ManagerUserIdentity($this->username, $this->password_input);
        if (!$identity->authenticate()) {
            $this->addError($attribute, 'รหัสผ่านไม่ถูกต้อง');
        }
    }

    public function loginByManager() {
        $identity = new ManagerUserIdentity($this->username, $this->password_input);
        if ($identity->authenticate()) {
            $log = new UserActivityLog;
            $log->user_id = $this->id;
            $log->message = 'Login Successfully.';
            $log->save();

            Yii::app()->user->login($identity);
            return true;
        }
    }

    public function getFullname() {
        return $this->username;
    }

    /**
     * Check if user is super user.
     * @return boolean
     */
    public function getIsSuperUser() {
        return $this->is_superuser === self::YES;
    }

    public function getRoleName() {
        if ($this->isSuperUser) {
            return 'ผู้ดูแลระบบระดับสูง';
        }
        return CHtml::value($this, 'role.name', 'ยังไม่ได้กำหนด');
    }

    public function checkPermission($id) {
        if ($this->isSuperUser) {
            return true;
        }

        if (isset($this->role)) {
            return $this->role->checkPermission($id);
        }
        return false;
    }

}
