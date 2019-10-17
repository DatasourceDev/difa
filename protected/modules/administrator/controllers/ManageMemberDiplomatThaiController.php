<?php

Yii::import('administrator.controllers.ManageMemberController');

class ManageMemberDiplomatThaiController extends ManageMemberController {

    public $layout = '/manageUser/_layout';
    public $title = 'นักการทูตไทย และ นักวิเทศสหการ';

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->scopeAccountProfile('accountProfileDiplomatThai')->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $profile = new AccountProfileDiplomatThai('register');
        $this->create(3, $profile, 'createDiplomatThaiByStaff', 'create');
    }

    public function actionSetConfirm($id) {
        $model = Account::model()->findByPk($id);
        $model->doActivate();
        Yii::app()->user->setFlash('success', 'ยืนยันการสมัครสมาชิกเรียบร้อย');
        $this->redirect(array('index'));
    }

    public function actionResendConfirmationMail($id) {
        $model = Account::model()->findByPk($id);
        $model->confirmation_code = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $model->save();
        Mailer::sendConfirmation($model->getProfile()->contact_email, array(
            'data' => array(
                'model' => $model,
            ),
        ));
        Yii::app()->user->setFlash('success', 'ระบบได้ส่งอีเมล์ยืนยันการสมัครเรียบร้อย กรุณาตรวจสอบกล่องจดหมายของคุณ');
        $this->redirect(array('index'));
    }

    public function actionExportXls() {
        $model = new Account('search');
        $model->unsetAttributes();
        $dataProvider = $model->scopeAccountProfile('accountProfileDiplomatThai')->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = 200;

        $ids = explode(',', Yii::app()->request->getPost('ids'));
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.id', $ids);

        $dataProvider->criteria->mergeWith($criteria);

        $models = new CDataProviderIterator($dataProvider);

        Helper::sendFile(time() . '.xls');
        $this->renderPartial('/manageMember/exportXls', array(
            'models' => $models,
        ));
    }

}
