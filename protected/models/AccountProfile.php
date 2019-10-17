<?php

Yii::import('application.models._base.BaseAccountProfile');

class AccountProfile extends BaseAccountProfile {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function primaryKey() {
        return 'id';
    }

}
