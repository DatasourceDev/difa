<?php

class AppController extends Controller {

    /*
    public function actionGetPhoto($id) {
        $account = Account::model()->findByPk($id);
        if (Yii::app()->user->id !== $account->id) {
            throw new CHttpException('access denied');
        }
        header('Content-type: image/jpeg');
        $contents = file_get_contents($account->profile->getPhotoRealPath());
        echo $contents;
    }*/

}
