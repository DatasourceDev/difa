<?php

class CodeskWebModule extends CWebModule {

    private $_assetUrl;

    public function init() {
        Yii::app()->setComponents(
                array('messages' => array(
                        'class' => 'CPhpMessageSource',
                        'basePath' => $this->basePath . '/messages',
        )));
    }

    public function getAssetUrl() {
        if (!isset($this->_assetUrl) && file_exists($this->basePath . '/assets')) {
            $this->_assetUrl = Yii::app()->assetManager->publish($this->basePath . '/assets', false, -1, YII_DEBUG);
        }
        return $this->_assetUrl;
    }

    public function getBaseUrl() {
        return Yii::app()->createUrl($this->id);
    }

}
