<?php

class AdministratorUserIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        $member = User::model()->findByAttributes(array(
            'username' => $this->username,
        ));

        if (isset($member)) {

            $member->password_input = $this->password;
            /* Check Password */
            if (!$member->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                return !$this->errorCode;
            }

            $this->errorCode = self::ERROR_NONE;
            $this->_id = $member->id;
            $member->saveAttributes(array(
                'last_login' => new CDbExpression('NOW()'),
            ));
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
