<?php

class CustomerController extends AdministratorController {

    public $title = 'Customers';

    public function actionIndex() {
        $this->description = 'List';
        $model = new Member('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

}
