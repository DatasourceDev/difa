<?php

class AdministratorWebUser extends CWebUser {

    private $_model;

    public function getModel() {
        if (!isset($this->_model)) {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    public function checkPermission($permission, $checkAll = false) {
        if (isset($this->model)) {
            if ($this->model->getIsSuperUser()) {
                return true;
            }
            if (isset($this->model->role)) {
                return $this->model->role->checkPermission($permission, $checkAll);
            }
        }
        return false;
    }

}
