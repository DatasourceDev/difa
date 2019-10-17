<?php

class MdbActiveRecord extends GxActiveRecord {

    public $search;

    public function getDbConnection() {
        return Yii::app()->legacy;
    }

    public function sortBy($order) {
        $criteria = new CDbCriteria();
        $criteria->order = $order;
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function tableName() {
        $tableName = str_replace('Mdb', 'T_', get_class($this));
        if (($pos = strrpos($tableName, '\\')) !== false)
            return substr($tableName, $pos + 1);
        return $tableName;
    }

    public function rules() {
        return array(
            array(implode(',', array_keys($this->getAttributes())), 'safe', 'on' => 'search'),
            array('search', 'safe', 'on' => 'search'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute => $value) {
            $criteria->compare($attribute, $this->{$attribute}, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
