<?php

class HomeController extends AdministratorController {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'users' => array('?'),
                'actions' => array(
                    'login',
                ),
            ),
            array(
                'allow',
                'users' => array('*'),
                'actions' => array(
                    'error',
                ),
            ),
                ), parent::accessRules());
    }

    public function actionIndex() {

        $nextSchedule = ExamSchedule::model()->next()->find();

        $countAccount = Account::model()->countByAttributes(array(
            'status' => Account::STATUS_ACTIVED,
        ));

        $countBorderline = ExamApplicationExamSet::model()->countByAttributes(array(
            'is_border_line' => ExamApplicationExamSet::YES,
            'is_update' => ExamApplicationExamSet::NO,
            'is_approved' => ExamApplicationExamSet::NO,
            'score_update' => null,
        ));

        $countSchedule = ExamSchedule::model()->count();

        $account = new Account('search');
        $account->unsetAttributes();
        $account->attributes = Yii::app()->request->getQuery('Account');
        $accountProvider = $account->sortBy('created DESC')->search();
        $criteria = new CDbCriteria();
        $criteria->compare('status', '<>' . Account::STATUS_DELETED);
        $accountProvider->criteria->mergeWith($criteria);

        $application = new ExamApplication('search');
        $application->unsetAttributes();
        $application->attributes = Yii::app()->request->getQuery('ExamApplication');
        $applicationProvider = $application->scopeValid()->sortBy('created DESC')->search();

        $duplicateProvider = Helper::query('member/list_foreigner_duplicate');
        $duplicateProvider->pagination = false;
        $duplicateProvider->sql->limit = 3;

        $inquiry = new AccountInquiry('search');
        $inquiry->unsetAttributes();
        $inquiry->is_done = AccountInquiry::NO;
        $inquiryProvider = $inquiry->sortBy('created DESC')->search();

        $changeNameLog = new ProfileChangeName('search');
        $changeNameLog->unsetAttributes();
        $changeNameHistoryProvider = $changeNameLog->sortBy('created DESC')->search();
        $criteria = new CDbCriteria();
        $condition = 'account_id in (select id as account_id from account)';
        $criteria->addCondition($condition);
        $changeNameHistoryProvider->criteria->mergeWith($criteria);

        $changeDepartmentLog = new ProfileChangeDepartment('search');
        $changeDepartmentLog->unsetAttributes();
        $changeDepartmentHistoryProvider = $changeDepartmentLog->sortBy('created DESC')->search();
        $criteria = new CDbCriteria();
        $condition = 'account_id in (select id as account_id from account)';
        $criteria->addCondition($condition);
        $changeDepartmentHistoryProvider->criteria->mergeWith($criteria);

        $changeTypeLog = new ProfileChangeType('search');
        $changeTypeLog->unsetAttributes();
        $changeTypeHistoryProvider = $changeTypeLog->sortBy('created DESC')->search();
        $criteria = new CDbCriteria();
        $condition = 'account_id in (select id as account_id from account)';
        $criteria->addCondition($condition);
        $changeTypeHistoryProvider->criteria->mergeWith($criteria);

        $requestResult = new ExamApplicationResult('search');
        $requestResult->unsetAttributes();
        $requestResultProvider = $requestResult->with(array('examApplication' => array('together' => true)))->sortBy('t.id DESC')->search();
        //$criteria = new CDbCriteria();
        //$condition = 't.is_request=1';
        //$criteria->addCondition($condition);
        //$requestResultProvider->criteria->mergeWith($criteria);

        $this->render('index', array(
            'nextSchedule' => $nextSchedule,
            'countAccount' => $countAccount,
            'countBorderline' => $countBorderline,
            'countSchedule' => $countSchedule,
            'account' => $account,
            'accountProvider' => $accountProvider,
            'application' => $application,
            'applicationProvider' => $applicationProvider,
            'duplicateProvider' => $duplicateProvider,
            'inquiryProvider' => $inquiryProvider,
            'changeNameHistoryProvider' => $changeNameHistoryProvider,
            'changeDepartmentHistoryProvider' => $changeDepartmentHistoryProvider,
            'changeTypeHistoryProvider' => $changeTypeHistoryProvider,
            'requestResultProvider' => $requestResultProvider,
        ));
    }

    public function actionAcceptPrintResult($id) {
       $model = ExamApplicationResult::model()->findByPk($id);
       $model->doPrintRequestResult();

       $requestResult = new ExamApplicationResult('search');
       $requestResult->unsetAttributes();
       $requestResultProvider = $requestResult->search();
       $criteria = new CDbCriteria();
       $condition = 't.is_request=1 and t.exam_application_id = ' . $model->exam_application_id;
       $criteria->addCondition($condition);
       $requestResultProvider->criteria->mergeWith($criteria);
       if(count($requestResultProvider)){
          $appication = ExamApplication::model()->findByPk($model->exam_application_id);
          $appication->doPrintRequestResult();
       }

        if (!Yii::app()->request->isAjaxRequest) {
           Yii::app()->user->setFlash('success', Helper::MSG_SAVED);
            $this->redirect(array('index'));
        }
    }

    public function actionLogin() {
        $this->layout = 'administrator.views.layouts.login';
        $model = new User('login');
        $data = Yii::app()->request->getPost('User');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->validate() && $model->login()) {
                $this->redirect(array('home/index'));
            }
        }
        $this->render('login', array(
            'model' => $model,
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $this->title = 'Error ' . $error['code'];
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

    public function actionSignMessage() {
        $signature = null;
        $r = openssl_sign(Yii::app()->request->getQuery('request'), $signature, openssl_get_privatekey(file_get_contents(Yii::getPathOfAlias('application.data.certs') . '/ca.key')));
        if ($signature) {
            header("Content-type: text/plain");
            echo base64_encode($signature);
            exit(0);
        }
        echo '<h1>Error signing message</h1>';
        exit(1);
    }

    public function actionPrint() {
        Yii::app()->language = 'en';
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $pdf = new PDFMaker;
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);

        $models = ExamApplicationResult::model()->findAll($criteria);
        foreach ($models as $model) {
           $application = ExamApplication::model()->findByPk($model->exam_application_id);
           $pdf->addPage('testResultReplyFront', array(
               'application' => $application,
           ));
           $pdf->addPage('testResultReplyBack', array(
               'application' => $application,
           ));
        }
        $pdf->output();
    }

}
