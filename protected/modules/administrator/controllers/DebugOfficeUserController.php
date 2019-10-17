<?php

class DebugOfficeUserController extends AdministratorController {

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

}
