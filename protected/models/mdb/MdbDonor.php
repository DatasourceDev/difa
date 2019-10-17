<?php

class MdbDonor extends MdbActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function primaryKey() {
        return 'DonorID';
    }

}
