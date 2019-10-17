<?php

class CodeskActiveRecordBehavior extends CBehavior {

    public function sortBy($order) {
        $criteria = new CDbCriteria;
        $criteria->order = $order;
        $this->owner->dbCriteria->mergeWith($criteria);
        return $this->owner;
    }

}
