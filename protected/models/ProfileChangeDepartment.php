<?php

Yii::import('application.models._base.BaseProfileChangeDepartment');

class ProfileChangeDepartment extends BaseProfileChangeDepartment {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'department_type' => 'ประเภทหน่วยงาน',
            'department' => 'กระทรวง/หน่วยงาน',
            'office' => 'กรม/สำนัก',
            'position' => 'ตำแหน่ง',
            'level' => 'ระดับ',
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('department_type, department, office, position, level', 'required', 'on' => 'changeType'),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
        ));
    }

    public function getHtmlChangeFrom() {
        $html = '';
        if ($this->department_type_original) {
            $html .= CodeDepartment::getDepartmentTypeOptions($this->department_type_original) . '<br/>';
        }
        if ($this->department_original) {
            $html .= CHtml::encode($this->department_original) . '<br/>';
        }
        if ($this->office_original) {
            $html .= CHtml::encode($this->office_original) . '<br/>';
        }
        if ($this->position_original) {
            $html .= CHtml::encode($this->position_original) . '<br/>';
        }
        if ($this->level_original) {
            $html .= CHtml::encode($this->level_original) . '<br/>';
        }
        return $html;
    }

    public function getHtmlChangeTo() {
        $html = '';
        if ($this->department_type) {
            $html .= CodeDepartment::getDepartmentTypeOptions($this->department_type) . '<br/>';
        }
        if ($this->department) {
            $html .= CHtml::encode($this->department) . '<br/>';
        }
        if ($this->office) {
            $html .= CHtml::encode($this->office) . '<br/>';
        }
        if ($this->position) {
            $html .= CHtml::encode($this->position) . '<br/>';
        }
        if ($this->level) {
            $html .= CHtml::encode($this->level) . '<br/>';
        }
        return $html;
    }

}
