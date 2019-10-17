<?php

class QzSignRequestAction extends CAction {

    public $caKey;

    public function run() {
        $this->caKey = dirname(__FILE__) . '/../data/ca.key';
        $signature = null;
        $r = openssl_sign(Yii::app()->request->getQuery('request'), $signature, openssl_get_privatekey(file_get_contents($this->caKey)));
        if ($signature) {
            header("Content-type: text/plain");
            echo base64_encode($signature);
            exit(0);
        }
        echo '<h1>Error signing message</h1>';
        exit(1);
    }

}
