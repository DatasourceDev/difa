<?php

Yii::import('application.models._base.BaseLegacySource');

class LegacySource extends BaseLegacySource {

    const STATUS_FAILED = '-1';
    const STATUS_PROCESSING = '0';
    const STATUS_DONE = '1';

    public $mdb_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อฐานข้อมูล',
            'mdb_file' => 'ไฟล์ฐานข้อมุล',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name', 'required'),
            array('mdb_file', 'file', 'allowEmpty' => false, 'types' => array('mdb', 'accdb'), 'on' => 'create'),
        ));
    }

    public function import() {
        $this->mdb_path = Yii::getPathOfAlias('application.uploads.mdb') . '/' . time() . '.mdb';
        $this->status = self::STATUS_PROCESSING;
        $this->created = new CDbExpression('NOW()');
        $this->modified = new CDbExpression('NOW()');
        if ($this->save()) {
            $this->isNewRecord = false;
            $file = CUploadedFile::getInstance($this, 'mdb_file');
            if ($file) {
                $file->saveAs($this->mdb_path);
            }
            Yii::app()->exec->run('mdb convert', array(
                'id' => $this->id,
            ));
            return true;
        }
    }

    public function loadSource() {
        Yii::app()->setComponents(array(
            'legacy' => array(
                'class' => 'CDbConnection',
                'connectionString' => 'sqlite:' . $this->mdb_name,
            ),
                ), false);
    }

}
