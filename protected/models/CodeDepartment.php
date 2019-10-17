<?php

Yii::import('application.models._base.BaseCodeDepartment');

class CodeDepartment extends BaseCodeDepartment {

    const OTHER = '9999';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'รหัส',
            'name_th' => 'ชื่อหน่วยงาน',
            'name_en' => 'Agency',
            'department_type_id' => 'ประเภทหน่วยงาน',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('id', 'unique', 'message' => 'ไม่สามารถบันทึกค่าซ้ำกับรายการอื่น'),
            array('name_th, name_en', 'required'),
        ));
    }

    public static function getDepartmentTypeOptions($code = null) {
        $ret = array(
            '1' => 'ราชการ',
            '2' => 'รัฐวิสาหกิจ',
            '3' => 'หน่วยราชการอิสระ/องค์กรอิสระ',
        );

        return isset($code) ? (isset($ret[$code]) ? $ret[$code] : $code) : $ret;
    }

    public function withIn($id) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('department_type_id = :department_type_id OR id = 9999');
        $criteria->params[':department_type_id'] = $id;
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function getDepartmentType() {
        if ($this->department_type_id) {
            return self::getDepartmentTypeOptions($this->department_type_id);
        }
        return '-';
    }

    public function findAllForSelect2() {
        $ret = array();
        $results = $this->findAll();
        foreach ($results as $result) {
            $ret[] = array(
                'id' => $result->id,
                'name_th' => $result->name_th,
                'name_en' => $result->name_en,
            );
        }
        return $ret;
    }

    public function getSelect2Item() {
        return array(
            'id' => $this->id,
            'name_th' => $this->name_th,
            'name_en' => $this->name_en,
        );
    }

}
