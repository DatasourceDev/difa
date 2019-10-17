<?php

class WebSliderController extends AdministratorController {
    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'users' => array('?'),
                'actions' => array(
                    'delete',
                ),
            ),
                ), parent::accessRules());
    }
    public function actionIndex() {
        $model = new WebSlider;
        $data = Yii::app()->request->getPost('WebSlider');
        if (isset($data)) {
            $model->attributes = $data;
            $model->web_slider_url1 = $data['web_slider_url1'];
            $model->web_slider_url2 = $data['web_slider_url2'];
            $model->web_slider_url3 = $data['web_slider_url3'];
            $model->web_slider_url4 = $data['web_slider_url4'];
            $model->web_slider_url5 = $data['web_slider_url5'];
            $model->web_slider_is_visible1 = $data['web_slider_is_visible1'];
            $model->web_slider_is_visible2 = $data['web_slider_is_visible2'];
            $model->web_slider_is_visible3 = $data['web_slider_is_visible3'];
            $model->web_slider_is_visible4 = $data['web_slider_is_visible4'];
            $model->web_slider_is_visible5 = $data['web_slider_is_visible5'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionDelete($index) {
        $model = new WebSlider;
        $f = $model->remove($index);
        Yii::app()->user->setFlash('success', 'ลบรูป ' . $f . ' สำเร็จ');
    }


}
