<?php

class OfficeController extends Controller {

    public $account;
    public $schedule;

    /**
     *
     * @var ExamScheduleAccount
     */
    public $scheduleAccount;
    public $countCurrent;

    public function init() {
        parent::init();
        if (!Yii::app()->user->isGuest) {
            $this->account = Account::model()->findByPk(Yii::app()->user->id);
            $this->scheduleAccount = CHtml::value($this->account, 'examScheduleAccount');
            $this->schedule = CHtml::value($this->account, 'examScheduleAccount.examSchedule');

            $this->countCurrent = ExamApplication::model()->countByAttributes(array(
                'office_user_id' => $this->account->id,
                'is_applicable' => ActiveRecord::YES,
            ));
        }
    }

    public function actionIndex() {
        $this->render('index', array(
            'account' => $this->account,
            'schedule' => $this->schedule,
        ));
    }

    public function actionCheckExistingAccount($id) {
        $model = Account::model()->findByAttributes(array(
            'entry_code' => $id,
        ));
        if (isset($model)) {
            $application = ExamApplication::model()->findByAttributes(array(
                'account_id' => $model->id,
                'exam_schedule_id' => $this->schedule->id,
            ));
            if (!isset($application)) {
                $this->renderPartial('checkExistingAccount', array(
                    'model' => $model,
                    'examSchedule' => $this->schedule,
                ));
            } else {
                echo 'OK';
            }
        } else {
            echo 'OK';
        }
    }

    public function actionRecheck($id) {
        /* @var $application ExamApplication */
        $application = ExamApplication::model()->findByPk($id);
        $application->checkApplyCondition();
        $this->redirect(array('register'));
    }

    /**
     * สมัครสอบ จากบัญชีที่มีอยู่เดิม
     * @param int $id Account ID
     */
    public function actionAccountApply($id) {
        $application = new ExamApplication('bulk');
        $application->account_id = $id;
        $application->office_user_id = $this->account->id;
        $application->exam_schedule_id = $this->schedule->id;
        $application->exam_schedule_objective_id = $this->scheduleAccount->office_objective_id;
        $application->apply_type = ExamApplication::APPLY_OFFICE;
        $application->save();
        $application->checkApplyCondition();
        Yii::app()->user->setFlash('success', 'Register successful.');
        $this->redirect(array('registerChoice'));
    }

    public function actionResult() {
        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->office_user_id = $this->account->id;
        $application->is_applicable = ActiveRecord::YES;
        $dataProvider = $application->search();

        $this->render('result', array(
            'dataProvider' => $dataProvider,
            'account' => $this->account,
            'schedule' => $this->schedule,
        ));
    }

    public function actionProfile() {
        $profile = $this->account->getProfile();
        $profile->scenario = 'update';
        $data = Yii::app()->request->getPost(get_class($profile));
        if (isset($data)) {
            $profile->attributes = $data;
            $this->account->attributes = Yii::app()->request->getPost('Account');
            if (!Yii::app()->request->isAjaxRequest && $profile->save() && $this->account->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
                $this->redirect(array('profile'));
            }
        }

        switch (get_class($profile)) {
            case 'AccountProfileGeneralThai':
                Yii::app()->setLanguage('th');
                $view = '/register/createGeneralThai';
                break;
            case 'AccountProfileGeneralForeigner':
                Yii::app()->setLanguage('en');
                $view = '/register/createGeneralForeigner';
                break;
            case 'AccountProfileDiplomatThai':
                Yii::app()->setLanguage('th');
                $view = '/register/createDiplomatThai';
                break;
            case 'AccountProfileDiplomatForeigner':
                Yii::app()->setLanguage('en');
                $view = '/register/createDiplomatForeigner';
                break;
            case 'AccountProfileOfficeUser':
                Yii::app()->setLanguage('th');
                $view = '/register/updateOfficeUser';
                break;
        }

        $this->render('/my/profile', array(
            'model' => $this->account,
            'profile' => $profile,
            'view' => $view,
        ));
    }

    public function actionRegister() {

        $queueReady = array();
        $queueFail = array();

        $applications = ExamApplication::model()->findAllByAttributes(array(
            'office_user_id' => $this->account->id,
        ));
        foreach ($applications as $application) {
            if ($application->getIsApplicable()) {
                $queueReady[] = $application;
            } else {
                $queueFail[] = $application;
            }
        }

        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->office_user_id = $this->account->id;
        $dataProvider = $application->search();
        $this->render('register', array(
            'queueReady' => $queueReady,
            'queueFail' => $queueFail,
            'account' => $this->account,
            'schedule' => $this->schedule,
            'dataProvider' => $dataProvider,
            'scheduleAccount' => $this->scheduleAccount,
        ));
    }

    public function actionCreateGeneralThai() {
        $model = new AccountProfileGeneralThai('registerByOffice');
        $model->work_office_type = $this->scheduleAccount->office_department_type_id;
        $model->work_office_id = $this->scheduleAccount->office_department_id;
        $model->work_office_other = $this->scheduleAccount->office_department_name;
        $model->work_department = $this->scheduleAccount->office_office;
        Yii::app()->user->setState('current_language', 'th');
        Yii::app()->language = 'th';
        $this->create(1, $model, 'createBulkGeneralThai', '/office/createGeneralThai');
    }

    public function actionCreateGeneralForeigner() {
        $model = new AccountProfileGeneralForeigner('registerByOffice');
        $model->work_office_id = $this->scheduleAccount->office_department_id;
        $model->work_office_other = CHtml::value($this->account, 'profile.textDepartment');
        $model->work_department = $this->scheduleAccount->office_office;
        $model->contact_phone_country = '+';
        $model->contact_fax_country = '+';
        $model->contact_mobile_country = '+';
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $this->create(2, $model, 'createBulkGeneralForeigner', '/office/createGeneralForeigner');
    }

    public function create($type, $profile, $scenario, $view) {
        if ($this->scheduleAccount->isQuotaExceeded) {
            Yii::app()->user->setFlash('success', 'Quota exceeded.');
            $this->redirect(array('register'));
        }
        $model = new Account($scenario);
        $model->is_office_user = ActiveRecord::YES;
        $model->account_type_id = $type;

        if (Yii::app()->request->isPostRequest) {

            $model->attributes = Yii::app()->request->getPost('Account');
            $profile->attributes = Yii::app()->request->getPost(get_class($profile));
            $profile->account_id = 0;

            $valid = $profile->validate() & $model->validate();
            $model->cProfile = $profile;

            if (!Yii::app()->request->isAjaxRequest && $valid && $model->save(false)) {
                $profile->account_id = $model->id;
                $profile->save(false);

                // Auto Assign to Application
                $application = new ExamApplication('bulk');
                $application->apply_type = ExamApplication::APPLY_OFFICE;
                $application->account_id = $model->id;
                $application->office_user_id = $this->account->id;
                $application->exam_schedule_id = $this->schedule->id;
                $application->exam_schedule_objective_id = $this->scheduleAccount->office_objective_id;
                if ($application->save()) {
                    /* re-check apply condition after add new one. */
                    $application->checkApplyCondition();
                    Yii::app()->user->setFlash('success', 'You have successfully registered.');
                    $this->redirect(array('registerChoice', 'id' => $this->schedule->id));
                } else {
                    Yii::app()->user->setFlash('success', CHtml::errorSummary($application));
                }
            }
        }
        $this->render($view, array(
            'model' => $model,
            'profile' => $profile,
        ));
    }

    public function actionRegisterChoice() {
        $this->render('registerChoice', array(
        ));
    }

    public function actionRegisterConfirm() {
        if ($this->scheduleAccount->doConfirm()) {
            Yii::app()->user->setFlash('success', 'Your application has been confirmed.');
            $this->redirect(array('register', 'id' => $this->schedule->id));
        }
    }

    public function actionCancel($id) {
        $model = ExamApplication::model()->findByPk($id);
        if ($model->is_paid === ActiveRecord::YES) {
            Yii::app()->user->setFlash('success', 'You can not cancel paid examination.');
            $this->redirect(array('register', 'id' => $model->id));
        }
        if ($model->cancel()) {
            Yii::app()->user->setFlash('success', 'You had cancelled an examination.');
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('register'));
        }
    }

    public function actionPrintPayment($id) {
        $pdf = new PDFMaker;
        $pdf->addPagePaymentOffice($this->schedule, $this->scheduleAccount);
        $pdf->output();
    }

    public function actionPrintCardAll($id) {
        $applications = ExamApplication::model()->findAllByAttributes(array(
            'office_user_id' => $this->account->id,
            'is_applicable' => ActiveRecord::YES,
        ));
        $pdf = new PDFMaker;
        foreach ($applications as $model) {
            $pdf->addPageExamCard($model);
        }
        $pdf->output();
    }

    public function actionPrintCard($id) {
        $application = ExamApplication::model()->findByPk(Yii::app()->request->getQuery('exam_application_id'));
        $pdf = new PDFMaker();
        $pdf->addPageExamCard($application);
        $pdf->output();
    }

    public function actionPrepare() {
        $model = $this->scheduleAccount;
        $model->scenario = 'prepare';
        $data = Yii::app()->request->getPost('ExamScheduleAccount');
        if (isset($data)) {
            $model->attributes = $data;
            $model->office_suffix = Configuration::getKey('payment_suffix');
            if (!Yii::app()->request->isAjaxRequest && $model->doPrepare()) {
                Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
                $this->redirect(array('office/index'));
            }
        }
        $this->render('prepare', array(
            'model' => $model,
        ));
    }

    public function actionQuotaConfirmation() {
        $this->renderPartial('quotaConfirmation', array(
        ));
    }

}
