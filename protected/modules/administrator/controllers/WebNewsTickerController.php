<?php

class WebNewsTickerController extends AdministratorController {

    public function actionIndex() {
        $model = new WebNewsTicker('index');
        $data = Yii::app()->request->getPost('WebNewsTicker');
        if (isset($data)) {
            $model->attributes = $data;
            $model->web_news_ticker = $data['web_news_ticker'];
            $model->web_news_ticker1 = $data['web_news_ticker1'];
            $model->web_news_ticker2 = $data['web_news_ticker2'];
            $model->web_news_ticker3 = $data['web_news_ticker3'];
            $model->custom_new1 = $data['custom_new1'];
            $model->custom_new2 = $data['custom_new2'];
            $model->custom_new3 = $data['custom_new3'];
            $model->custom_date_from1 = $data['custom_date_from1'];
            $model->custom_date_from2 = $data['custom_date_from2'];
            $model->custom_date_from3 = $data['custom_date_from3'];
            $model->custom_date_to1 = $data['custom_date_to1'];
            $model->custom_date_to2 = $data['custom_date_to2'];
            $model->custom_date_to3 = $data['custom_date_to3'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('index', array(
            'model' => $model
        ));
    }

}
