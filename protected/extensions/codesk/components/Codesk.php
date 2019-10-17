<?php

class Codesk extends CApplicationComponent {

    private $_assetUrl;

    public function init() {
        parent::init();
        if (!Yii::getPathOfAlias('codesk')) {
            Yii::setPathOfAlias('codesk', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
        }
        Yii::import('codesk.components.*');
        $this->registerCss();
        $this->registerScript();
    }

    public function registerCss() {
        Yii::app()->clientScript->registerCssFile($this->assetUrl . '/css/font.css');
    }

    public function registerScript() {
        Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/js/main.js');
    }

    public function getAssetUrl() {
        if (!isset($this->_assetUrl)) {
            $this->_assetUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/../assets', false, -1, YII_DEBUG);
        }
        return $this->_assetUrl;
    }

}
