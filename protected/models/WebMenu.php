<?php

Yii::import('application.models._base.BaseWebMenu');

class WebMenu extends BaseWebMenu {

    const SHOW_ALL = '0';
    const SHOW_ONLY_ET = '1';
    const SHOW_ONLY_HI = '2';
    const SHOW_ONLY_TH = '1';
    const SHOW_ONLY_EN = '2';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getAccountClassOptions($code = null) {
        $ret = array(
            self::SHOW_ALL => 'แสดงในทุกประเภท',
            self::SHOW_ONLY_ET => 'ข้าราชการ / ชาวต่างชาติ ทั่วไป',
            self::SHOW_ONLY_HI => 'นักการฑูตไทย / นักการฑูตต่างชาติ (IH)',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getAccountNationOptions($code = null) {
        $ret = array(
            self::SHOW_ALL => 'แสดงในทุกประเภท',
            self::SHOW_ONLY_TH => 'ข้าราชการไทย / นักการฑูตไทย',
            self::SHOW_ONLY_EN => 'ชาวต่างชาติ / นักการฑูตต่างชาติ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getIsDropDownOptions($code = null) {
        $ret = array(
            self::NO => 'ลิงค์เชื่อมโยง',
            self::YES => 'เมนูหลัก',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getMenuItems() {
        $ret = array();
        $items = WebMenu::model()->sortBy('order_no')->findAll();
        foreach ($items as $item) {
            if ($item->isDropDown) {
                $items = array();
                foreach ($item->webMenuItems as $subItem) {
                    $items[] = array(
                        'label' => Yii::app()->language === 'th' ? $subItem->name : $subItem->name_en,
                        'url' => $subItem->url,
                        'linkOptions' => array(
                            'target' => '_blank',
                        ),
                    );
                }
                $ret[] = array(
                    'label' => Yii::app()->language === 'th' ? $item->name : $item->name_en,
                    'url' => array('#'),
                    'visible' => $item->bizrule ? Yii::app()->request->getQuery('exam_code') === $item->bizrule : true,
                    'items' => $items,
                );
            } else {
                $ret[] = array(
                    'label' => Yii::app()->language === 'th' ? $item->name : $item->name_en,
                    'url' => $item->url,
                    'linkOptions' => array(
                        'target' => '_blank',
                    ),
                    'visible' => $item->getIsVisible(),
                );
            }
        }
        return $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'name' => 'ชื่อเมนู',
            'name_en' => 'Menu Title',
            'url' => 'URL',
            'is_dropdown' => 'ประเภทเมนู',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name, name_en, is_dropdown', 'required'),
        ));
    }

    public function getTextIsDropDown() {
        return self::getIsDropDownOptions($this->is_dropdown);
    }

    public function getIsDropDown() {
        return $this->is_dropdown === self::YES;
    }

    public function getTextName() {
        return $this->name . ' ( ' . $this->name_en . ')';
    }

    public function getIsVisible() {
        if (isset($this->bizrule)) {
            if (Yii::app()->user->isGuest) {
                if (Yii::app()->request->getQuery('exam_code') === $this->bizrule) {
                    return true;
                }
            }
        }

        if (!Yii::app()->user->isGuest) {
            switch ($this->account_class) {
                case self::SHOW_ONLY_ET:
                    if (CHtml::value(Yii::app()->user, 'account.accountType.is_diplomat') !== '0') {
                        return false;
                    }
                    break;
                case self::SHOW_ONLY_HI:
                    if (CHtml::value(Yii::app()->user, 'account.accountType.is_diplomat') !== '1') {
                        return false;
                    }
                    break;
            }
            switch ($this->account_nation) {
                case self::SHOW_ONLY_TH:
                    if (CHtml::value(Yii::app()->user, 'account.accountType.is_foreigner') !== '0') {
                        return false;
                    }
                    break;
                case self::SHOW_ONLY_EN:
                    if (CHtml::value(Yii::app()->user, 'account.accountType.is_foreigner') !== '1') {
                        return false;
                    }
                    break;
            }
        } else {
            if ($this->account_class || $this->account_nation) {
                return false;
            }
        }

        return true;
    }

}
