<?php

class ReportPasswordChangeController extends AdministratorController {

    public $layout = '/reportPasswordChange/_layout';

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->sortBy('legacy_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
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

}
