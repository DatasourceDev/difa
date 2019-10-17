<?php

class ManagerUserIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        $member = User::model()->findByAttributes(array(
            'username' => $this->username,
            'secret' => Account::encrypt($this->password),
        ));

        if (isset($member)) {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $member->id;

            $this->setState('test', 'ssss');

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
