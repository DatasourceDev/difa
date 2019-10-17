<?php

class SmsController extends Controller {

    public function accessRules() {
        return array(
            array(
                'allow',
                'users' => '*',
            ),
        );
    }

    public function actionResponse() {
        $msg = array(
            'date' => date('Y-m-d H:i:s'),
            'ip' => Yii::app()->request->userHostAddress,
            'data' => $_GET,
        );
        file_put_contents(Yii::app()->assetManager->basePath . '/sms_log', json_encode($msg, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        echo 'SUCCESS';
    }

}
