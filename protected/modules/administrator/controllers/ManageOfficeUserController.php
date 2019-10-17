<?php

Yii::import('administrator.controllers.ManageMemberController');

class ManageOfficeUserController extends ManageMemberController {

    public $layout = '/manageUser/_layout';
    public $title = 'จัดการบัญชีตัวแทนหน่วยงาน';
    public $countCurrent;

    public function init() {
        parent::init();
        $this->countCurrent = ExamApplication::model()->countByAttributes(array(
            'office_user_id' => Yii::app()->request->getQuery('id'),
        ));
    }

    public function actionIndex() {
        $model = new ExamScheduleAccount('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamScheduleAccount');
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreateOfficeUser() {
        Yii::app()->user->setState('current_language', 'th');
        Yii::app()->language = 'th';
        $this->create(5, new AccountProfileOfficeUser('register'), 'createOfficeUser', '/manageOfficeUser/create');
    }

    public function actionDoPaid($id) {
        $model = Account::model()->findByPk($id);
        $esa = $model->examScheduleAccount;
        if (isset($esa)) {
            $esa->doPaid();
        }
    }

    public function actionUndoPaid($id) {
        $model = Account::model()->findByPk($id);
        $esa = $model->examScheduleAccount;
        if (isset($esa)) {
            $esa->undoPaid();
        }
    }

    public function actionDoConfirm($id) {
        $model = Account::model()->findByPk($id);
        $esa = $model->examScheduleAccount;
        if (isset($esa)) {
            $esa->doConfirm();
        }
    }

    public function actionUndoConfirm($id) {
        $model = Account::model()->findByPk($id);
        $esa = $model->examScheduleAccount;
        if (isset($esa)) {
            $esa->undoConfirm();
        }
    }

    public function actionProfile($id) {
        $model = Account::model()->findByPk($id);
        $profile = $model->getProfile();
        $profile->scenario = 'update';

        Helper::setLaguageByClass(get_class($profile));
        $model->scenario = 'updateOfficeUser';
        $view = '/manageOfficeUser/create';

        $data = Yii::app()->request->getPost(get_class($profile));
        if (isset($data)) {
            $profile->attributes = $data;
            $model->attributes = Yii::app()->request->getPost('Account');
            if (!Yii::app()->request->isAjaxRequest && $profile->save() && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('profile', 'id' => $model->id));
            }
        }

        $this->render('profile', array(
            'model' => $model,
            'profile' => $profile,
            'view' => $view,
        ));
    }

    public function actionSchedule($id) {
        $model = Account::model()->findByPk($id);
        $this->render('schedule', array(
            'account' => $model,
            'schedule' => $model->examScheduleAccount->examSchedule,
        ));
    }

    public function actionRegister($id) {
        $model = Account::model()->findByPk($id);
        $queueReady = array();
        $queueFail = array();

        $applications = ExamApplication::model()->findAllByAttributes(array(
            'office_user_id' => $model->id,
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
        $application->office_user_id = $model->id;
        $dataProvider = $application->search();
        $this->render('register', array(
            'queueReady' => $queueReady,
            'queueFail' => $queueFail,
            'account' => $model,
            'schedule' => $model->examScheduleAccount->examSchedule,
            'dataProvider' => $dataProvider,
            'scheduleAccount' => $model->examScheduleAccount,
        ));
    }

    public function actionResult($id) {
        $model = Account::model()->findByPk($id);
        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->office_user_id = $model->id;
        $dataProvider = $application->search();

        $this->render('result', array(
            'dataProvider' => $dataProvider,
            'account' => $model,
            'schedule' => $model->examScheduleAccount->examSchedule,
        ));
    }

    public function actionPrintPayment($id) {
        $model = Account::model()->findByPk($id);
        $pdf = new PDFMaker;
        $pdf->addPagePaymentOffice($model->examScheduleAccount->examSchedule, $model->examScheduleAccount);
        $pdf->output();
    }

    public function actionPrintCardAll($id) {
        $applications = ExamApplication::model()->findAllByAttributes(array(
            'office_user_id' => $id,
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

    public function actionCancel($id) {
        $model = ExamApplication::model()->findByPk($id);
        if ($model->is_paid === ActiveRecord::YES) {
            Yii::app()->user->setFlash('success', 'ไม่สามารถยกเลิกรายการที่ชำระเงินแล้ว');
            $this->redirect(array('register', 'id' => $model->office_user_id));
        }
        if ($model->cancel()) {
            Yii::app()->user->setFlash('success', 'ยกเลิกการสมัครเรียบร้อย');
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('register', 'id' => $model->office_user_id));
        }
    }

    public function actionRecheck($id) {
        /* @var $application ExamApplication */
        $application = ExamApplication::model()->findByPk($id);
        $application->checkApplyCondition();
        $this->redirect(array('register', 'id' => $application->office_user_id));
    }

}
