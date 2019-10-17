<?php

class ManageUserController extends AdministratorController {

    public $layout = '/manageUser/_layout';

    public function actionIndex() {

        $user = new User('search');
        $user->unsetAttributes();
        $dataProvider = $user->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'user' => $user,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new User;
        $data = Yii::app()->request->getPost('User');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = User::model()->findByPk($id);
        $data = Yii::app()->request->getPost('User');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = User::model()->findByPk($id);
        if (isset($model)) {
            $model->delete();
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index'));
        }
    }

    public function actionView($id) {
        $model = User::model()->findByPk($id);

        $activity = new UserActivityLog;
        $activity->unsetAttributes();
        $activity->user_id = $model->id;
        $dataProvider = $activity->sortBy('created DESC')->search();

        $groups = Permission::getGroups();

        $this->render('view', array(
            'model' => $model,
            'activity' => $activity,
            'dataProvider' => $dataProvider,
            'groups' => $groups,
        ));
    }

    /**
     * Reset user table.
     * @group debug
     */
    public function actionReset() {
        if (YII_DEBUG) {
            Yii::app()->db->createCommand('SET foreign_key_checks = 0')->execute();
            Yii::app()->db->createCommand('TRUNCATE TABLE user_activity_log')->execute();
            Yii::app()->db->createCommand('TRUNCATE TABLE user')->execute();
            Yii::app()->db
                    ->createCommand('INSERT INTO user (username, secret, email, created, modified, is_superuser) VALUES (:username, MD5(:secret), :email, NOW(), NOW(), :is_superuser)')
                    ->bindValue(':username', 'admin')
                    ->bindValue(':secret', 'admin')
                    ->bindValue(':email', 'wachira.d@cdg.co.th')
                    ->bindValue(':is_superuser', '1')
                    ->execute();
            Yii::app()->db->createCommand('SET foreign_key_checks = 1');
        }
        Yii::app()->user->setFlash('success', 'ลบตารางผู้ใช้งานเรียบร้อย');
        $this->redirect(array('index'));
    }

}
