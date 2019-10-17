<?php

Yii::import('administrator.controllers.ManageMemberController');

class ManageMemberGeneralForeignerController extends ManageMemberController {

    public $layout = '/manageUser/_layout';
    public $title = 'สมาชิกชาวต่างชาติ';

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->scopeAccountProfile('accountProfileGeneralForeigner')->sortBy('created DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $profile = new AccountProfileGeneralForeigner('register');
        $this->create(2, $profile, 'createGeneralForeignerByStaff', 'create');
    }

    public function actionImport() {
        Yii::import('administrator.models.AccountGeneralForeignerImportForm');
        $model = new AccountGeneralThaiImportForm;
        $data = Yii::app()->request->getPost('AccountGeneralForeignerImportForm');
        if (isset($data)) {
            $model->attributes = $data;

            switch (Yii::app()->request->getQuery('mode')) {
                case 'save':
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                        $this->redirect(array('index'));
                    } else {
                        $this->render('importForm', array(
                            'model' => $model,
                        ));
                    }
                    Yii::app()->end();
                    break;
                default:
                    if ($model->import()) {
                        Yii::app()->user->setFlash('success', 'นำเข้าข้อมูลเรียบร้อย');
                        $this->render('importForm', array(
                            'model' => $model,
                        ));
                        Yii::app()->end();
                    }
                    break;
            }
        }
        $this->render('import', array(
            'model' => $model,
        ));
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
        $dataProvider = $model->scopeAccountProfile('accountProfileGeneralForeigner')->sortBy('created DESC')->search();
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
