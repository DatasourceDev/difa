<?php

class WebUser extends CWebUser {

    private $_account;

    public function getAccount() {
        if (!isset($this->_account)) {
            $this->_account = Account::model()->findByPk($this->id);
        }
        return $this->_account;
    }

    public function getIsOfficeUser() {
       return get_class(CHtml::value($this, 'account.profile')) === 'AccountProfileOfficeUser';
        
    }

    public function getIsDiplomat() {
        return in_array(CHtml::value($this, 'account.account_type_id'), array(3, 4));
    }

    public function getMyExamScheduleMenu() {
        $esa = ExamScheduleAccount::model()->findAllByAttributes(array(
            'account_id' => $this->id,
        ));
        $menu = array();
        foreach ($esa as $item) {
            $menu[] = array(
                'label' => CHtml::value($item, 'examSchedule.exam_code'),
                'url' => array('office/index', 'id' => CHtml::value($item, 'exam_schedule_id')),
            );
        }
        return $menu;
    }

    public function logout($destroySession = true) {
        parent::logout($destroySession);
        Yii::app()->session->open();
    }

}
