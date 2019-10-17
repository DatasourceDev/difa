<?php

Yii::import('application.models._base.BaseOmrStorageData');

class OmrStorageData extends BaseOmrStorageData {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_set' => 'ชุดข้อสอบ',
            'dvifa_code' => 'รหัสประจำตัว',
            'exam_num' => 'เลขที่นั่งสอบ',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'account' => array(self::BELONGS_TO, 'Account', '', 'foreignKey' => array(
                    'dvifa_code' => 'username',
                )),
            'examSet' => array(self::BELONGS_TO, 'ExamSet', 'exam_set'),
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule'),
        ));
    }

    public function getExamPhotos() {
        $data = CJSON::decode($this->json_data);
        $photos = array();
        if (isset($data['photos'])) {
            foreach ($data['photos'] as $name => $url) {
                $obj = new stdClass;
                $obj->fileName = $name;
                $obj->fileUrl = $url;
                $obj->filePath = Yii::getPathOfAlias('application') . str_replace('/protected', '', $url);
                $photos[] = $obj;
            }
        }
        return $photos;
    }

}
