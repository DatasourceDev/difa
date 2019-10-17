<?php

class ManageUserGroupController extends AdministratorController {

    public $layout = '/manageUserGroup/_layout';

    public function actionIndex() {
        $model = new Role('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCreate() {
        $model = new Role;
        $data = Yii::app()->request->getPost('Role');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('index'));
            }
        }
        $groups = Permission::getGroups();
        $this->render('form', array(
            'model' => $model,
            'groups' => $groups,
        ));
    }

    public function actionUpdate($id) {
        $model = Role::model()->findByPk($id);
        $data = Yii::app()->request->getPost('Role');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        $groups = Permission::getGroups();
        $this->render('form', array(
            'model' => $model,
            'groups' => $groups,
        ));
    }

    public function actionDelete($id) {
        $model = Role::model()->findByPk($id);
        $model->delete();
    }

    public function actionView($id) {
        
    }

}
