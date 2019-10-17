<?php

class MdbRoomAPList extends MdbActiveRecord {

    public $search;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function primaryKey() {
        return 'RoomID';
    }

    public function relations() {
        return array(
            'level' => array(self::BELONGS_TO, 'MdbLevel', 'LevelID'),
            'subject' => array(self::BELONGS_TO, 'MdbSubject', 'SubjectID'),
            'donor' => array(self::BELONGS_TO, 'MdbDonor', 'DonorID'),
        );
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('search', 'safe', 'on' => 'search'),
        ));
    }

}
