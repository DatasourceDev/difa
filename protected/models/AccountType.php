<?php

Yii::import('application.models._base.BaseAccountType');

class AccountType extends BaseAccountType {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getId($name) {
        $model = AccountType::model()->findByAttributes(array(
            'table_name' => $name,
        ));
        return CHtml::value($model, 'id');
    }

    public function onlyUser() {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('id', 1, 4);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getAccountManagerLink() {
        switch ($this->table_name) {
            case 'accountProfileGeneralThai':
                return array('manageMemberGeneralThai/index');
            case 'accountProfileGeneralForeigner':
                return array('manageMemberGeneralForeigner/index');
            case 'accountProfileDiplomatThai':
                return array('manageMemberDiplomatThai/index');
            case 'accountProfileDiplomatForeigner':
                return array('manageMemberDiplomatForeigner/index');
        }
    }

    public function getIsForeigner() {
        return $this->is_foreigner === self::YES;
    }

    public function getIsDiplomat() {
        return $this->is_diplomat === self::YES;
    }

    public function scopeRegistrable() {
        $criteria = new CDbCriteria();
        $criteria->compare('is_registrable', self::YES);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

}
