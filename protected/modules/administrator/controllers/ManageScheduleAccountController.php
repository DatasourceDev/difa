<?php

class ManageScheduleAccountController extends AdministratorController {

    public function actionAdd($id) {
        $model = new ExamScheduleAccount();
        $model->exam_schedule_id = $id;

        $account = new Account;
        $account->account_type_id = AccountType::getId('accountProfileOfficeUser');
        $accountData = Yii::app()->request->getPost('Account');
        $scheduleData = Yii::app()->request->getPost('ExamScheduleAccount');

        if (isset($accountData)) {
            $account->attributes = $accountData;
            $model->attributes = $scheduleData;
            if ($account->save()) {
                $model->account_id = $account->id;
                $model->save();
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('manageSchedule/viewUser', 'id' => $model->exam_schedule_id));
            }
        }
        $this->render('add', array(
            'model' => $model,
            'account' => $account,
        ));
    }

    public function actionDelete() {
        $model = ExamScheduleAccount::model()->findByPk(Yii::app()->request->getQuery('id'));
        $model->delete();
    }

    public function actionCreate() {
        $this->render('form');
    }

    
}
