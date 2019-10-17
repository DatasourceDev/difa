<?php

class SecurityLog {

    public function getCases() {
        return array(
            'etc/passwd',
            'passwd',
            '/var/'
        );
    }

    public function run() {
        foreach ($this->getCases() as $case) {
            if (strpos(Yii::app()->request->url, $case) !== false) {
                Yii::log('Someone trying to crack our system.', CLogger::LEVEL_WARNING, 'security');
                break;
            }
        }
    }

}
