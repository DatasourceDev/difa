<?php

class MdbNameAPList extends MdbActiveRecord {

    const TYPE_NAME = '1';
    const TYPE_TESTDATE = '2';
    const TYPE_TESTROUND = '3';
    const TYPE_TESTLEVEL = '4';
    const TYPE_DONOR = '5';
    const TYPE_SUBJECT = '6';
    const TYPE_DEPARTMENT = '7';
    const TYPE_TESTSET = '8';
    const TYPE_TESTTYPE = '9';
    const TYPE_DESKNUMBER = '10';
    const TYPE_SCORE_READING = '11';
    const TYPE_SCORE_LISTENING = '12';
    const TYPE_SCORE_TOTAL = '13';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getSortOptions() {
        return array(
            self::TYPE_NAME => 'ชื่อผู้สอบ',
            self::TYPE_TESTDATE => 'วันที่สอบ',
            self::TYPE_TESTROUND => 'รอบสอบ',
            self::TYPE_TESTLEVEL => 'ระดับ',
            self::TYPE_DONOR => 'แหล่งทุน',
            self::TYPE_SUBJECT => 'ชื่อทุน',
            self::TYPE_DEPARTMENT => 'หน่วยงาน',
            self::TYPE_TESTSET => 'ชุดสอบ',
            self::TYPE_TESTTYPE => 'ประเภท',
            self::TYPE_DESKNUMBER => 'ที่นั่งสอบ',
            self::TYPE_SCORE_READING => 'คะแนนการอ่าน',
            self::TYPE_SCORE_LISTENING => 'คะแนนการฟัง',
            self::TYPE_SCORE_TOTAL => 'คะแนนรวม',
        );
    }

    public function primaryKey() {
        return array(
            'RoomID',
            'PersonID',
        );
    }

    public function relations() {
        return array(
            'room' => array(self::BELONGS_TO, 'MdbRoomAPList', 'RoomID'),
            'person' => array(self::BELONGS_TO, 'MdbPerson', 'PersonID'),
        );
    }

    public function search() {
        $dataProvider = parent::search();

        if (!empty($this->search['room_date'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('DATE(room.TestDate)', $this->search['room_date']);
            $dataProvider->criteria->mergeWith($criteria);
        }
        if (!empty($this->search['room_round'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('room.Round', $this->search['room_round']);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['room_level'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
                'room.level' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('level.Level', $this->search['room_level'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['person_title'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'person' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('person.Title', $this->search['person_title'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['person_name'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'person' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('person.Name', $this->search['person_name'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['person_department'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'person' => array(
                    'together' => true,
                ),
                'person.department' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('department.Department', $this->search['person_department'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['donor_name'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
                'room.donor' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('donor.DonorName', $this->search['donor_name'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['subject_name'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
                'room.subject' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('subject.Subject', $this->search['subject_name'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['room_testset'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('room.TestSet', $this->search['room_testset'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['room_testtype'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'room' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('room.TestType', $this->search['room_testtype'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['sort_by'])) {
            $criteria = new CDbCriteria();
            switch ($this->search['sort_by']) {
                case self::TYPE_TESTDATE:
                    $criteria->with = array(
                        'room' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'room.TestDate';
                    break;
                case self::TYPE_TESTROUND:
                    $criteria->with = array(
                        'room' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'room.Round';
                    break;
                case self::TYPE_TESTLEVEL:
                    $criteria->with = array(
                        'room' => array(
                            'together' => true,
                        ),
                        'room.level' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'level.Level';
                    break;
                case self::TYPE_DONOR:
                    $criteria->with = array(
                        'donor' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'donor.DonorName';
                    break;
                case self::TYPE_SUBJECT:
                    $criteria->with = array(
                        'subject' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'subject.Subject';
                    break;
                case self::TYPE_DEPARTMENT:
                    $criteria->with = array(
                        'person' => array(
                            'together' => true,
                        ),
                        'person.department' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'department.Department';
                    break;
                case self::TYPE_TESTSET:
                    $criteria->with = array(
                        'room' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'room.TestSet';
                    break;
                case self::TYPE_TESTTYPE:
                    $criteria->with = array(
                        'room' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'room.TestType';
                    break;
                case self::TYPE_DESKNUMBER:
                    $criteria->order = 't.DeskNumber';
                    break;
                case self::TYPE_SCORE_READING:
                    $criteria->order = 't.Reading';
                    break;
                case self::TYPE_SCORE_LISTENING:
                    $criteria->order = 't.Listening';
                    break;
                case self::TYPE_SCORE_TOTAL:
                    $criteria->order = 't.ScoreTotal';
                    break;
                case self::TYPE_NAME:
                default:
                    $criteria->with = array(
                        'person' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->order = 'person.Name';
                    break;
            }

            if (!empty($this->search['sort_direction'])) {
                switch ($this->search['sort_direction']) {
                    case 'desc':
                        $criteria->order .= ' DESC';
                        break;
                }
            }
            $dataProvider->criteria->mergeWith($criteria);
        }

        return $dataProvider;
    }

    public function scopeAcademic() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'room' => array(
                'together' => true,
            ),
        );
        $criteria->compare('room.TestType', 'A');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function scopePractical() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'room' => array(
                'together' => true,
            ),
        );
        $criteria->compare('room.TestType', 'P');
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

}
