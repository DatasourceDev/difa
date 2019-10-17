<?php

class QzPrintComponent extends CApplicationComponent {

    public $signRequestUrl;
    private $_assetUrl;

    public function init() {
        parent::init();
        Yii::setPathOfAlias('qz', dirname(__FILE__));
    }

    public function getAssetUrl() {
        if (!isset($this->_assetUrl)) {
            $this->_assetUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets', false, -1, YII_DEBUG);
        }
        return $this->_assetUrl;
    }

    public function registerScripts() {
        Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/js/qz-websocket.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/js/qz-base.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('qz-print', '
            function getCertificate(callback) {
                $.ajax({
                    method: "GET",
                    async: false,
                    url: "' . $this->assetUrl . '/certs/certificate.crt",
                    success: callback,
                    cache : false
                });
            }
            function signRequest(toSign, callback) {
                $.ajax({
                    method: "GET",
                    contentType: "text/plain",
                    url : "' . Yii::app()->createUrl($this->signRequestUrl) . '",
                    data: {
                        request : toSign
                    },
                    async: false,
                    success: callback
                });
            }
        ', CClientScript::POS_HEAD);
    }

    public function deploy() {
        $this->registerScripts();
        Yii::app()->clientScript->registerScript('qz-print-deploy', '
            deployQZ();
        ', CClientScript::POS_HEAD);
    }

}
