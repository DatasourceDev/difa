<?php

Yii::import('application.models._base.BaseWebDownload');

class WebDownload extends BaseWebDownload {

    public $doc_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getMaxOrder() {
        return Yii::app()->db->createCommand('SELECT COALESCE(MAX(order_no),0) FROM web_download LIMIT 1')->queryScalar();
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name_th' => 'ชื่อเอกสาร',
            'name_en' => 'Document Name',
            'doc_file' => 'ไฟล์เอกสาร',
            'created' => 'สร้างเมื่อ',
        ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (!isset($this->order_no)) {
                $this->order_no = self::getMaxOrder() + 1;
            }
            return true;
        }
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
            'docFile' => array(
                'class' => 'FileARBehavior',
                'attribute' => 'doc_file',
                'extension' => implode(',', Helper::getAllowedFileExtension()),
                'relativeWebRootFolder' => 'uploads/content',
                'prefix' => 'doc_',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(300, 150),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name_th', 'required'),
            array('doc_file', 'file', 'allowEmpty' => false, 'types' => Helper::getAllowedFileExtension(), 'on' => 'insert'),
            array('doc_file', 'file', 'allowEmpty' => true, 'types' => Helper::getAllowedFileExtension(), 'on' => 'update'),
        ));
    }

    public function doDownload() {
        if (!$this->isNewRecord && file_exists($this->docFile->filePath)) {
            Yii::app()->request->sendFile(basename($this->fileUrl), file_get_contents($this->filePath));
        } else {
            throw new CException('Attachment not found.');
        }
    }

    public function doMoveDown() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('order_no > :current');
        $criteria->order = '(order_no - :current)';
        $criteria->limit = 1;
        $criteria->params = array(
            ':current' => $this->order_no,
        );
        $model = WebDownload::model()->find($criteria);
        if (isset($model)) {
            $tmp = $model->order_no;
            $model->order_no = $this->order_no;
            $this->order_no = $tmp;
            if ($model->save()) {
                $this->save();
                return true;
            }
        }
    }

    public function doMoveUp() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('order_no < :current');
        $criteria->order = '(:current - order_no)';
        $criteria->limit = 1;
        $criteria->params = array(
            ':current' => $this->order_no,
        );
        $model = WebDownload::model()->find($criteria);
        if (isset($model)) {
            $tmp = $model->order_no;
            $model->order_no = $this->order_no;
            $this->order_no = $tmp;
            if ($model->save()) {
                $this->save();
                return true;
            }
        }
    }

}
