<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    const ERROR_EXPIRED = 3;
    const ERROR_INACTIVE = 4;
    const ERROR_DUPLICATE = 5;
    const ERROR_DISABLED = 6;

    private $_id;

    public function getId() {
        return $this->_id;
    }

    public function authenticate() {
        $model = Account::model()->findByAttributes(array(
            'username' => $this->username,
        ));
        if (isset($model)) {
            $model->password_input = $this->password;
            
            /* Check Password */
            if (!$model->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                return !$this->errorCode;
            }

            if (CHtml::value($model, 'accountType.table_name') === 'accountProfileOfficeUser') {

                /* ป้องกันการ Login ซ้ำซ้อน */
                if (isset($model->session_ip)) {
                    if (Yii::app()->request->userHostAddress !== $model->session_ip) {
                        if ($model->session_timeout > date('Y-m-d H:i:s')) {
                            $this->errorCode = self::ERROR_DUPLICATE;
                            return !$this->errorCode;
                        }
                    }
                }

                /* ตรวจสอบวันหมดอายุของบัญชีตัวแทน */
                $esa = ExamScheduleAccount::model()->findByAttributes(array(
                    'account_id' => $model->id,
                ));
                if (isset($esa)) {
                    if ($esa->expire_date < date('Y-m-d')) {
                        $this->errorCode = self::ERROR_EXPIRED;
                        return !$this->errorCode;
                    }
                }
            }

            if ($model->status !== Account::STATUS_ACTIVED) {
                $this->errorCode = self::ERROR_INACTIVE;
                return !$this->errorCode;
            }

            if ($model->is_disable) {
                $this->errorCode = self::ERROR_DISABLED;
                return !$this->errorCode;
            }



            $this->errorCode = self::ERROR_NONE;
            $this->_id = $model->id;
        } else {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        return !$this->errorCode;
    }

}
