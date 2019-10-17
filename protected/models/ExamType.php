<?php

Yii::import('application.models._base.BaseExamType');

class ExamType extends BaseExamType {

    public $account_types;
    public $cover_file;
    public $info_file;
    public $special_info_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'เลขรหัส',
            'code' => 'รหัสอักษร',
            'name' => 'ชื่อประเภทการสอบ',
            'description' => 'คำอธิบาย',
            'default_register_fee' => 'ค่าธรรมเนียมการสอบ',
            'badge_color' => 'สี',
            'is_active' => 'สถานะ',
            'account_types' => 'ประเภทสมาชิกที่อนุญาติให้สมัคร',
            'cover_file' => 'รูปหน้าปก',
            'info_file' => 'รูปแสดงหน้าเนื้อหา',
            'html_page' => 'เนื้อหาของหลักสูตร',
            'is_special_info' => 'การสมัครกรณีพิเศษ',
            'special_info_file' => 'ภาพสำหรับกรณีพิเศษ',
            'special_info' => 'รายละเอียดการสมัครกรณีพิเศษ',
            'income_type_id' => 'รหัสบันทึกรายรับ',
        ));
    }

    public function afterFind() {
        parent::afterFind();
        $this->account_types = CHtml::listData(ExamTypeAccount::model()->findAllByAttributes(array('exam_type_id' => $this->id)), 'account_type_id', 'account_type_id');
    }

    public function afterSave() {
        parent::afterSave();
        ExamTypeAccount::model()->deleteAllByAttributes(array('exam_type_id' => $this->id));
        if (isset($this->account_types) && is_array($this->account_types)) {
            foreach ($this->account_types as $type) {
                $item = new ExamTypeAccount;
                $item->exam_type_id = $this->id;
                $item->account_type_id = $type;
                $item->save();
            }
        }
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'coverFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'cover_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/exam_type',
                'prefix' => 'cover_',
                'forceExt' => 'jpg',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(339, 198, 1),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
            'infoFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'info_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/exam_type',
                'prefix' => 'info_',
                'forceExt' => 'jpg',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(339, 198, 1),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
            'specialFile' => array(
                'class' => 'ImageARBehavior',
                'attribute' => 'special_info_file',
                'extension' => implode(',', Helper::getAllowedImageExtension()),
                'relativeWebRootFolder' => 'uploads/exam_type',
                'prefix' => 'special_',
                'forceExt' => 'jpg',
                'formats' => array(
                    'normal' => array(
                        'suffix' => '',
                    ),
                    'thumbnail' => array(
                        'suffix' => '_thumbnail',
                        'process' => array(
                            'resize' => array(339, 198, 1),
                        ),
                    ),
                ),
                'defaultName' => 'default',
            ),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name, code', 'required'),
            array('id, code', 'unique'),
            array('code', 'match', 'pattern' => '/^[A-Z]*$/', 'message' => 'รหัสต้องเป็นอักขระภาษาอังกฤษ A-Z เท่านั้น'),
            array('code', 'length', 'min' => 2, 'max' => 2),
            array('account_types', 'safe'),
            array('cover_file', 'file', 'types' => Helper::getAllowedImageExtension(), 'allowEmpty' => true),
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ExamTypeAccount::model()->deleteAllByAttributes(array(
                'exam_type_id' => $this->id,
            ));

            foreach ($this->examDefaultGrades as $item) {
                $item->delete();
            }

            foreach ($this->examPrerequisites as $item) {
                $item->delete();
            }

            foreach ($this->examPrerequisites1 as $item) {
                $item->delete();
            }

            foreach ($this->examSchedules as $item) {
                $item->delete();
            }

            foreach ($this->examSets as $item) {
                $item->delete();
            }

            foreach ($this->examSubjects as $item) {
                $item->delete();
            }

            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'incomeType' => array(self::BELONGS_TO, 'IncomeType', 'income_type_id'),
            'examSubjects' => array(self::HAS_MANY, 'ExamSubject', 'exam_type_id', 'order' => 'order_no'),
        ));
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->code = strtoupper($this->code);
            return true;
        }
    }

    public function getHtmlTitle() {
        return '<span class="label label-primary" style="background-color:' . CHtml::value($this, 'badge_color') . ';">' . CHtml::encode($this->id) . '</span> - <strong>' . CHtml::encode($this->code) . '</strong> - ' . CHtml::encode($this->name) . ' - ค่าธรรมเนียม : <span class="text-success">' . number_format($this->default_register_fee, 2) . '</span> บาท';
    }

    public function getTextTitle() {
        return CHtml::encode($this->id) . ' ' . CHtml::encode($this->name);
    }

    public function getClassName() {
        return 'event-exam-' . strtolower($this->code);
    }

    public function scopeActive() {
        $criteria = new CDbCriteria();
        $criteria->compare('is_active', self::YES);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function hasAccountType($account_type_id) {
        return ExamTypeAccount::model()->countByAttributes(array(
                    'exam_type_id' => $this->id,
                    'account_type_id' => $account_type_id,
        ));
    }

}
