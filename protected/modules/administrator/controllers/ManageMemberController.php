<?php

class ManageMemberController extends AdministratorController {

    public $layout = '/manageUser/_layout';
    public $title = 'จัดการผู้ใช้งาน (Frontend)';

    public function accessRules() {
        return array_merge(array(
            array(
                'deny',
                'actions' => array(
                    'deleteBulk',
                ),
                'verbs' => array(
                    'GET',
                ),
            ),
                ), parent::accessRules());
    }

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionDelete($id) {
        $model = Account::model()->findByPk($id);
        if (isset($model)) {
            $model->delete();
        }
    }

    public function actionGoto($id) {
        $model = Account::model()->findByPk($id);
        $this->redirect(array('profile', 'id' => $model->id));
    }

    public function actionView($id) {
        $model = Account::model()->findByPk($id);
        Helper::setLaguageByClass(get_class($model->getProfile()));
        $model->scenario = 'changePassword';
        $data = Yii::app()->request->getPost('Account');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                $model->profile->save(false);
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('/manageMember/view', array(
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
        $this->redirect(array('home/index'));
    }

    public function actionModalViewPassport($id) {
        $model = Account::model()->findByPk($id);
        $this->renderPartial('modal/viewPassport', array(
            'model' => $model,
        ));
    }

    public function actionGetSelfFile($id) {
        $model = Account::model()->findByPk($id);
        $file = CHtml::value($model, 'profile.selfFile.filePath');
        Yii::app()->request->sendFile(basename($file), file_get_contents($file));
    }

    public function actionProfile($id) {
        $model = Account::model()->findByPk($id);
        $profile = $model->getProfile();
        $profile->scenario = 'update';

        Helper::setLaguageByClass(get_class($profile));
        switch (get_class($profile)) {
            case 'AccountProfileGeneralThai':
                $view = '/manageMemberGeneralThai/create';
                break;
            case 'AccountProfileGeneralForeigner':
                $view = '/manageMemberGeneralForeigner/create';
                break;
            case 'AccountProfileDiplomatThai':
                $view = '/manageMemberDiplomatThai/create';
                break;
            case 'AccountProfileDiplomatForeigner':
                $view = '/manageMemberDiplomatForeigner/create';
                break;
            case 'AccountProfileOfficeUser':
                $model->scenario = 'updateOfficeUser';
                $view = '/manageOfficeUser/create';
                break;
        }

        $data = Yii::app()->request->getPost(get_class($profile));
        if (isset($data)) {
            $profile->attributes = $data;
            $model->attributes = Yii::app()->request->getPost('Account');
            if (!Yii::app()->request->isAjaxRequest && $profile->save() && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('profile', 'id' => $model->id));
            } else {
                $profile->validate();
            }
        }

        $this->render('profile', array(
            'model' => $model,
            'profile' => $profile,
            'view' => $view,
        ));
    }

    public function actionApplication($id) {
        $account = Account::model()->findByPk($id);
        Helper::setLaguageByClass(get_class($account->getProfile()));
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->account_id = $account->id;
        $dataProvider = $model->sortBy()->scopeValid()->search();

        $this->render('application', array(
            'model' => $account,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCertificate($id) {
        $model = Account::model()->findByPk($id);
        Helper::setLaguageByClass(get_class($model->getProfile()));
        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->account_id = $model->id;
        $dataProvider = $application->with(array('examSchedule' => array('together' => true)))->scopeValid()->sortBy('examSchedule.db_date DESC')->search();
        $dataProvider->pagination = false;


        $this->render('certificate', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /*
      public function actionCreateGeneralThai() {
      Yii::app()->user->setState('current_language', 'th');
      Yii::app()->language = 'th';
      $this->create(1, new AccountProfileGeneralThai('register'), 'createGeneralThaiByStaff', 'create');
      }

      public function actionCreateGeneralForeigner() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(2, new AccountProfileGeneralForeigner('register'), 'createGeneralForeigner', '/register/createGeneralForeigner');
      }

      public function actionCreateDiplomatThai() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(3, new AccountProfileDiplomatThai('register'), 'createDiplomatThai', '/register/createDiplomatThai');
      }

      public function actionCreateDiplomatForeigner() {
      Yii::app()->user->setState('current_language', 'en');
      Yii::app()->language = 'en';
      $this->create(4, new AccountProfileDiplomatForeigner('register'), 'createDiplomatForeigner', '/register/createDiplomatForeigner');
      }
     */

    public function actionConfirm($id) {
        $model = Account::model()->findByPk($id);
        $this->render('confirm', array(
            'model' => $model,
        ));
    }

    /**
     * 
     * @param integer $id Application ID
     */
    public function actionCancel($id) {
        $model = ExamApplication::model()->findByPk($id);
        $model->cancel();
    }

    public function create($type, $profile, $scenario, $view) {
        $this->layout = $this->module->layout;
        $model = new Account($scenario);
        if (Yii::app()->request->getQuery('exam_schedule_id')) {
            $model->default_exam_schedule_id = Yii::app()->request->getQuery('exam_schedule_id');
        }
        $model->account_type_id = $type;
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('Account');
            $profile->attributes = Yii::app()->request->getPost(get_class($profile));
            $profile->account_id = 0;
            $valid = $profile->validateRegister() & $model->validate();
            $model->cProfile = $profile;

            if ($scenario === 'createOfficeUser') {
                $model->status = Account::STATUS_ACTIVED;
            }

            if (!Yii::app()->request->isAjaxRequest && $valid && $model->save(false)) {
                $profile->account_id = $model->id;
                $profile->save(false);
                if ($scenario === 'createOfficeUser') {
                    $esa = new ExamScheduleAccount;
                    $esa->payment_suffix = Configuration::getKey('payment_suffix');
                    $esa->payment_tax = Configuration::getKey('payment_tax');
                    $esa->account_id = $model->id;
                    $esa->exam_schedule_id = $model->default_exam_schedule_id;
                    $esa->max_quota = $model->default_max_quota;
                    $esa->preserved_quota = $model->default_max_quota;
                    $esa->office_department_type_id = CHtml::value($profile, 'work_office_type');
                    $esa->office_department_id = CHtml::value($profile, 'work_office_id');
                    $esa->office_department_name = CHtml::value($profile, 'work_office');
                    $esa->office_office = CHtml::value($profile, 'work_department');
                    $esa->office_co_user = CHtml::value($profile, 'fullname');
                    $esa->office_phone = CHtml::value($profile, 'contact_phone');
                    $schedule = ExamSchedule::model()->findByPk($esa->exam_schedule_id);
                    $esa->expire_date = date('Y-m-d', strtotime('+30 days', strtotime($schedule->db_date)));
                    if ($esa->save()) {
                        Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                        $id = Yii::app()->request->getQuery('exam_schedule_id');
                        if ($id) {
                            $this->redirect(array('manageSchedule/viewUser', 'id' => $id));
                        } else {
                            $this->redirect(array('index'));
                        }
                    }
                }
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('manageMember/profile', 'id' => $model->id));
            }
        }
        $this->render($view, array(
            'model' => $model,
            'profile' => $profile,
        ));
    }

    public function actionDeleteBulk() {
        $ids = Yii::app()->request->getPost('ids', array());
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($ids as $id) {
                $model = Account::model()->findByPk($id);
                if (isset($model)) {
                    $model->delete();
                }
            }
            $transaction->commit();
        } catch (CException $e) {
            $transaction->rollback();
            throw new CHttpException(500, $e->getMessage());
        }
    }

    public function actionSetting($id) {
        $account = Account::model()->findByPk($id);
        $this->render('setting', array(
            'account' => $account,
        ));
    }

    public function actionDoAccountEnable($id) {
        $account = Account::model()->findByPk($id);
        $account->is_disable = 0;
        $account->save();
        Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
        $this->redirect(array('setting', 'id' => $account->id));
    }

    public function actionDoAccountDisable($id) {
        $account = Account::model()->findByPk($id);
        $account->is_disable = 1;
        $account->save();
        Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
        $this->redirect(array('setting', 'id' => $account->id));
    }

    public function actionChangeType($id) {
        $account = Account::model()->findByPk($id);
        $profile = $account->getProfile();
        $account->scenario = 'changeType';
        switch ($account->account_type_id) {
            case '1':
                $account->account_type_id_new = '3';
                break;
            case '2':
                $account->account_type_id_new = '4';
                break;
            case '3':
                $account->account_type_id_new = '1';
                break;
            case '4':
                $account->account_type_id_new = '2';
                break;
        }

        $data = Yii::app()->request->getPost('Account');

        if (isset($data)) {
            $account->attributes = $data;
            if ($account->doChangeType()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('profile', 'id' => $account->id));
            }
        }

        $this->render('changeType', array(
            'account' => $account,
            'profile' => $profile,
        ));
    }

    public function actionChangeName($id) {
        $account = Account::model()->findByPk($id);
        $profile = $account->getProfile();
        Helper::setLaguageByClass(get_class($profile));


        $model = new ProfileChangeName(get_class($profile));
        $model->account_id = $account->id;
        $model->title_id_th_original = CHtml::value($profile, 'title_id_th');
        $model->title_th_original = CHtml::value($profile, 'title_th');
        $model->firstname_th_original = CHtml::value($profile, 'firstname_th');
        $model->midname_th_original = CHtml::value($profile, 'midname_th');
        $model->lastname_th_original = CHtml::value($profile, 'lastname_th');
        $model->title_id_en_original = CHtml::value($profile, 'title_id_en');
        $model->title_en_original = CHtml::value($profile, 'title_en');
        $model->firstname_en_original = CHtml::value($profile, 'firstname_en');
        $model->midname_en_original = CHtml::value($profile, 'midname_en');
        $model->lastname_en_original = CHtml::value($profile, 'lastname_en');
        $model->title_id_th = CHtml::value($profile, 'title_id_th');
        $model->title_th = CHtml::value($profile, 'title_th');
        $model->firstname_th = CHtml::value($profile, 'firstname_th');
        $model->midname_th = CHtml::value($profile, 'midname_th');
        $model->lastname_th = CHtml::value($profile, 'lastname_th');
        $model->title_id_en = CHtml::value($profile, 'title_id_en');
        $model->title_en = CHtml::value($profile, 'title_en');
        $model->firstname_en = CHtml::value($profile, 'firstname_en');
        $model->midname_en = CHtml::value($profile, 'midname_en');
        $model->lastname_en = CHtml::value($profile, 'lastname_en');

        $data = Yii::app()->request->getPost('ProfileChangeName');

        if (isset($data)) {
            $model->attributes = $data;
            if ($model->doChangeName()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('profile'));
            }
        }

        $log = new ProfileChangeName('search');
        $log->unsetAttributes();
        $log->account_id = $account->id;
        $dataProvider = $log->sortBy('created DESC')->search();

        $work = new ProfileChangeDepartment('search');
        $work->unsetAttributes();
        $work->account_id = $account->id;
        $workProvider = $work->sortBy('created DESC')->search();

        $type = new ProfileChangeType('search');
        $type->unsetAttributes();
        $type->account_id = $account->id;
        $typeProvider = $type->sortBy('created DESC')->search();

        $this->render('changeName', array(
            'model' => $model,
            'account' => $account,
            'profile' => $profile,
            'dataProvider' => $dataProvider,
            'work' => $work,
            'workProvider' => $workProvider,
            'type' => $type,
            'typeProvider' => $typeProvider,
        ));
    }

    public function actionChangeNameDelete($id) {
        $model = ProfileChangeName::model()->findByPk($id);
        $model->delete();
    }

    public function actionChangeDepartmentDelete($id) {
        $model = ProfileChangeDepartment::model()->findByPk($id);
        $model->delete();
    }

    public function actionChangeTypeDelete($id) {
        $model = ProfileChangeType::model()->findByPk($id);
        $model->delete();
    }

    public function actionDownloadDocumentChangeName($id) {
        $model = ProfileChangeName::model()->findByPk($id);
        Yii::app()->request->sendFile(basename($model->file_url), file_get_contents(Yii::getPathOfAlias('application') . $model->file_url));
    }

    public function actionExportXls() {
        $this->render('exportXls', array(
        ));
    }

}
