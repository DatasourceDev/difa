<?php

Yii::import('application.models._base.BaseCodeReligion');

class CodeReligion extends BaseCodeReligion {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getName() {
        return $this->name_en . ' / ' . $this->name_th;
    }

}
