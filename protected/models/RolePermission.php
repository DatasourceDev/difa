<?php

Yii::import('application.models._base.BaseRolePermission');

class RolePermission extends BaseRolePermission {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'permission' => array(self::BELONGS_TO, 'Permission', 'permission_id'),
            'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
        ));
    }

}
