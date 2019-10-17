<?php

class WebMenuController extends AdministratorController {

    public $layout = '/web/_layout';
    public $title = 'จัดการเมนูเว็บไซต์';

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder = Yii::getPathOfAlias('webroot.uploads.tmp') . DIRECTORY_SEPARATOR; // folder for uploaded files
        $allowedExtensions = Helper::getAllowedFileExtension();
        $sizeLimit = Helper::getMaxFileSize();
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $result = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result; // it's array
    }

    public function actionIndex() {
        $menu = WebMenu::model()->sortBy('order_no')->findAll();
        $this->render('index', array(
            'menu' => $menu,
        ));
    }

    public function actionCreate() {
        $model = new WebMenu;
        $data = Yii::app()->request->getPost('WebMenu');
        if (isset($data)) {
            $model->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = WebMenu::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebMenu');
        if (isset($data)) {
            $model->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = WebMenu::model()->findByPk($id);
        $model->delete();
        $this->redirect(array('index'));
    }

    public function actionAddItem($id) {
        $subMenu = new WebMenuItem;
        $subMenu->web_menu_id = $id;
        $data = Yii::app()->request->getPost('WebMenuItem');
        if (isset($data)) {
            $subMenu->attributes = $data;
            if ($subMenu->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('formItem', array(
            'model' => $subMenu,
        ));
    }

    public function actionUpdateItem($id) {
        $model = WebMenuItem::model()->findByPk($id);
        $data = Yii::app()->request->getPost('WebMenuItem');
        if (isset($data)) {
            $model->attributes = $data;
            if (!Yii::app()->request->isAjaxRequest && $model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $this->render('formItem', array(
            'model' => $model,
        ));
    }

    public function actionDeleteItem($id) {
        $model = WebMenuItem::model()->findByPk($id);
        $model->delete();
        $this->redirect(array('index'));
    }

}
