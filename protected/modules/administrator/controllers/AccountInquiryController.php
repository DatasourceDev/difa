<?php

class AccountInquiryController extends AdministratorController {

    public $layout = '/memberAccountDuplicate/_layout';
    public $title = 'ข้อความจากสมาชิก';

    public function actionIndex() {
        $model = new AccountInquiry('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('AccountInquiry');
        $dataProvider = $model->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($id) {
        $model = AccountInquiry::model()->findByPk($id);
        $model->scenario = 'reply';

        $data = Yii::app()->request->getPost('AccountInquiry');
        if (isset($data)) {
            $model->attributes = $data;
            $model->reply_datetime = date('Y-m-d H:i:s');
            $model->user_id = Yii::app()->user->id;
            if ($model->reply()) {
                Yii::app()->user->setFlash('success', 'ตอบกลับข้อมูลเรียบร้อย');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = AccountInquiry::model()->findByPk($id);
        $model->delete();
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_DELETED);
            $this->redirect(array('index'));
        }
    }

    public function actionSetDone($id) {
        $model = AccountInquiry::model()->findByPk($id);
        $model->is_done = ActiveRecord::YES;
        $model->save();
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
            $this->redirect(array('view', 'id' => $model->id));
        }
    }

    public function actionSetUnread($id) {
        $model = AccountInquiry::model()->findByPk($id);
        $model->is_done = ActiveRecord::NO;
        $model->save();
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
            $this->redirect(array('view', 'id' => $model->id));
        }
    }

}
