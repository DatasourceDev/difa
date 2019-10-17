<?php

class HomeController extends ManagerController {

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
        $this->render('index', array(
        ));
    }

    public function actionSelectExamSchedule() {
        $this->layout = 'manager.views.layouts.login';

        $model = new ExamSchedule('search');
        $model->unsetAttributes();
        $dataProvider = $model->sortBy('db_date DESC')->search();

        $this->render('selectExamSchedule', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionJoinExamSchedule($id) {
        Yii::app()->user->setState('current_exam_schedule_id', $id);
        $this->redirect(array('index'));
    }

    public function actionLogin() {
        $this->layout = 'manager.views.layouts.login';
        $model = new User('loginByManager');
        $data = Yii::app()->request->getPost('User');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->validate() && $model->loginByManager()) {
                $this->redirect(array('home/index'));
            }
        }
        $this->render('login', array(
            'model' => $model,
        ));
    }

    public function actionAutoLogin($id) {
        Yii::app()->user->setState('current_exam_schedule_id', $id);
        $this->redirect(array('index'));
    }

    public function actionQuit() {
        $this->redirect(array('/administrator/manageSchedule/view', 'id' => Yii::app()->user->getState('current_exam_schedule_id')));
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

}
