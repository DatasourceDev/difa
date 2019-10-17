<?php

Yii::import('application.models._base.BaseCodePlace');

class CodePlace extends BaseCodePlace {

    public $place_file;
    public $place_file_en;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อสถานที่',
            'name_en' => 'Venue',
            'place_file' => 'รูปแผนที่ (ภาษาไทย)',
            'place_file_en' => 'รูปแผนที่ (ภาษาอังกฤษ)',
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'placeEnFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'place_file_en',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/place',
                'prefix' => 'place_en_',
                'forceExt' => 'png',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                ),
                'defaultName' => 'default',
            ),
            'placeFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'place_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/place',
                'prefix' => 'place_',
                'forceExt' => 'png',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                ),
                'defaultName' => 'default',
            ),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name', 'required'),
            array('place_file, place_file_en', 'file', 'allowEmpty' => false, 'types' => array('jpg', 'png'), 'on' => 'insert'),
            array('place_file, place_file_en', 'file', 'allowEmpty' => true, 'types' => array('jpg', 'png'), 'on' => 'update'),
        ));
    }

}
