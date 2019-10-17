<?php

class ActiveRecord extends GxActiveRecord {

    const YES = '1';
    const NO = '0';

    public $search;

    public function sortBy($order = '') {
        $criteria = new CDbCriteria();
        $criteria->order = $order;
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

}
