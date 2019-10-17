<?php

Yii::import('application.models._base.BaseCodeCountry');

class CodeCountry extends BaseCodeCountry {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'รหัสเลข 3 หลัก',
            'name_th' => 'ชื่อประเทศ',
            'name_en' => 'Country Name',
            'alpha2' => 'รหัสอักษร 2 หลัก',
            'alpha3' => 'รหัสอักษร 3 หลัก',
            'nationality' => 'สัญชาติ',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('alpha2, alpha3', 'unique', 'message' => 'ไม่สามารถบันทึกค่าซ้ำกับรายการอื่น'),
            array('name_th, name_en, alpha2, alpha3', 'required'),
        ));
    }

    public function forNationality() {
        $criteria = new CDbCriteria();
        $criteria->group = 'nationality';
        $criteria->addCondition('nationality IS NOT NULL');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

}
