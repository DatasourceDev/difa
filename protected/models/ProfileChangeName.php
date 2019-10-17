<?php

Yii::import('application.models._base.BaseProfileChangeName');

class ProfileChangeName extends BaseProfileChangeName {

    public $self_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'title_id_th' => 'คำนำหน้า',
            'title_th' => 'คำนำหน้า',
            'firstname_th' => 'ชื่อ',
            'midname_th' => 'ชื่อกลาง',
            'lastname_th' => 'นามสกุล',
            'title_id_en' => 'Title',
            'title_en' => 'Title',
            'firstname_en' => 'Firstname',
            'midname_en' => 'Middlename',
            'lastname_en' => 'Lastname',
            'self_file' => Helper::t('Approval Docunent', 'เอกสารหลักฐาน'),
        ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->title_en = strtoupper($this->title_en);
            $this->firstname_en = strtoupper($this->firstname_en);
            $this->midname_en = strtoupper($this->midname_en);
            $this->lastname_en = strtoupper($this->lastname_en);
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
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('account_id', 'required'),
            array('title_id_th, firstname_th, lastname_th', 'required', 'on' => array('accountProfileGeneralThai', 'accountProfileDiplomatThai')),
            array('title_id_en, firstname_en, lastname_en', 'required', 'on' => array('accountProfileGeneralThai', 'accountProfileGeneralForeigner', 'accountProfileDiplomatThai', 'accountProfileDiplomatForeigner')),
            array('title_en', 'checkTitleEn', 'on' => array('accountProfileGeneralThai', 'accountProfileGeneralForeigner', 'accountProfileDiplomatThai', 'accountProfileDiplomatForeigner')),
            array('title_th', 'checkTitleTh', 'on' => array('accountProfileGeneralThai', 'accountProfileDiplomatThai')),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
        ));
    }

    public function checkTitleTh() {
        if ($this->title_id_th === 'O') {
            if (empty($this->title_th)) {
                $this->addError('title_th', 'กรุณาระบุให้ครบถ้วน');
            }
        } else {

            $this->title_th = null;
        }
    }

    public function checkTitleEn() {
        if ($this->title_id_en === 'O') {
            if (empty($this->title_en)) {
                $this->addError('title_en', 'Please input other title');
            }
        } else {

            $this->title_en = null;
        }
    }

    public function doChangeName() {
        if ($this->save()) {
            $account = $this->account;
            if (isset($account)) {
                $profile = $account->getProfile();
                if (isset($profile)) {
                    if ($profile->hasAttribute('title_id_th')) {
                        $profile->title_id_th = $this->title_id_th;
                    }
                    if ($profile->hasAttribute('title_th')) {
                        $profile->title_th = $this->title_th;
                    }
                    if ($profile->hasAttribute('firstname_th')) {
                        $profile->firstname_th = $this->firstname_th;
                    }
                    if ($profile->hasAttribute('midname_th')) {
                        $profile->midname_th = $this->midname_th;
                    }
                    if ($profile->hasAttribute('lastname_th')) {
                        $profile->lastname_th = $this->lastname_th;
                    }
                    if ($profile->hasAttribute('title_id_en')) {
                        $profile->title_id_en = $this->title_id_en;
                    }
                    if ($profile->hasAttribute('title_en')) {
                        $profile->title_en = $this->title_en;
                    }
                    if ($profile->hasAttribute('firstname_en')) {
                        $profile->firstname_en = $this->firstname_en;
                    }
                    if ($profile->hasAttribute('midname_en')) {
                        $profile->midname_en = $this->midname_en;
                    }
                    if ($profile->hasAttribute('lastname_en')) {
                        $profile->lastname_en = $this->lastname_en;
                    }
                    if ($profile->save()) {
                        return true;
                    }
                }
            }
        }
    }

    public function getTextTitleEn() {
        $model = CodeTitle::model()->findByPk($this->title_id_en);
        if (isset($model)) {
            return $model->name_en;
        }

        return $this->title_en;
    }

    public function getTextTitleTh() {
        $model = CodeTitle::model()->findByPk($this->title_id_th);
        if (isset($model)) {
            return $model->name_th;
        }

        return $this->title_th;
    }

    public function getTextTitleEnOriginal() {
        $model = CodeTitle::model()->findByPk($this->title_id_en);
        if (isset($model)) {
            return $model->name_en;
        }

        return $this->title_en;
    }

    public function getTextTitleThOriginal() {
        $model = CodeTitle::model()->findByPk($this->title_id_th_original);
        if (isset($model)) {
            return $model->name_th;
        }

        return $this->title_th_original;
    }

    public function getFullnameOriginal() {
        return $this->textTitleThOriginal . $this->firstname_th_original . ' ' . $this->lastname_th_original;
    }

    public function getFullnameEnOriginal() {
        return $this->textTitleEnOriginal . $this->firstname_en_original . ' ' . $this->midname_en_original . ' ' . $this->lastname_en_original;
    }

    public function getFullname() {
        return $this->textTitleTh . $this->firstname_th . ' ' . $this->lastname_th;
    }

    public function getFullnameEn() {
        return $this->textTitleEn . $this->firstname_en . ' ' . $this->midname_en . ' ' . $this->lastname_en;
    }

    public function getHtmlChangeFrom() {
        $html = '';
        if ($this->firstname_en) {
            $html .= CHtml::encode($this->getFullnameEnOriginal());
        }
        $html .= '<br/>';
        if ($this->firstname_th) {
            $html .= CHtml::encode($this->getFullnameOriginal());
        }
        return $html;
    }

    public function getHtmlChangeTo() {
        $html = '';
        if ($this->firstname_en) {
            $html .= CHtml::encode($this->getFullnameEn());
        }
        $html .= '<br/>';
        if ($this->firstname_th) {
            $html .= CHtml::encode($this->getFullname());
        }
        return $html;
    }

}
