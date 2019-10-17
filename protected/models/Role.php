<?php

Yii::import('application.models._base.BaseRole');

class Role extends BaseRole {

    public $permissionData;
    private $_permissions;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อกลุ่มผู้ใช้งาน',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name', 'required'),
            array('permissionData', 'safe'),
        ));
    }

    public function afterFind() {
        parent::afterFind();
        $this->permissionData = $this->getPermissionArray();
    }

    public function afterSave() {
        parent::afterSave();
        if (is_array($this->permissionData)) {
            RolePermission::model()->deleteAllByAttributes(array(
                'role_id' => $this->id,
            ));
            foreach ($this->permissionData as $name => $value) {
                if ($value === self::YES) {
                    $this->assign($name);
                } else {
                    $this->revoke($name);
                }
            }
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            RolePermission::model()->deleteAllByAttributes(array(
                'role_id' => $this->id,
            ));
            User::model()->updateAll(array(
                'role_id' => null,
            ));
            return true;
        }
    }

    public function assign($permission) {
        $model = RolePermission::model()->findByAttributes(array(
            'role_id' => $this->id,
            'permission_id' => $permission,
        ));
        if (!isset($model)) {
            $model = new RolePermission;
            $model->role_id = $this->id;
            $model->permission_id = $permission;
            if ($model->save()) {
                return true;
            }
        }
    }

    public function revoke($permission) {
        RolePermission::model()->deleteAllByAttributes(array(
            'role_id' => $this->id,
            'permission_id' => $permission,
        ));
        return true;
    }

    public function getPermissionArray() {
        if (!isset($this->_permissions)) {
            $ret = array();
            $permissions = RolePermission::model()->findAllByAttributes(array(
                'role_id' => $this->id,
            ));
            foreach ($permissions as $permission) {
                $ret[CHtml::value($permission, 'permission.id')] = CHtml::value($permission, 'permission.name');
            }
            $this->_permissions = $ret;
        }
        return $this->_permissions;
    }

    public function checkPermission($permission, $checkAll = false) {
        if (is_array($permission)) {
            $valid = true;
            foreach ($permission as $item) {
                if ($checkAll) {
                    $valid = $valid && $this->checkPermission($item);
                } else {
                    if ($this->checkPermission($item)) {
                        return true;
                    }
                }
            }
            if ($checkAll) {
                return $valid;
            } else {
                return false;
            }
        } else {
            if (strpos($permission, '*') !== false) {
                foreach ($this->permissionArray as $key => $name) {
                    $word = substr($permission, 0, strpos($permission, '*'));
                    if ($checkAll) {
                        if (strpos($word, $key) === false) {
                            return false;
                        }
                    } else {
                        if (strpos($word, $key) !== false) {
                            return true;
                        }
                    }
                }
                if ($checkAll) {
                    return true;
                }
            } else {
                return array_key_exists($permission, $this->permissionArray);
            }
        }
    }

}
