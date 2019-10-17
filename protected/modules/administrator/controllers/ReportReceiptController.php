<?php

class ReportReceiptController extends AdministratorController {

    public function actionIndex() {
        $model = new Receipt('search');
        $model->unsetAttributes();
        $model->is_office = '0';
        $model->attributes = Yii::app()->request->getQuery('Receipt');
        $dataProvider = $model->sortBy('t.payment_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionOffice() {
        $model = new Receipt('search');
        $model->unsetAttributes();
        $model->is_office = '1';
        $model->attributes = Yii::app()->request->getQuery('Receipt');
        $dataProvider = $model->sortBy('t.payment_date DESC')->search();
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionRecipient() {

        $newModel = new ReceiptApprover;
        $data = Yii::app()->request->getPost('ReceiptApprover');
        if ($data) {
            $newModel->attributes = $data;
            if ($newModel->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('recipient'));
            }
        }

        $model = new ReceiptApprover('search');
        $model->unsetAttributes();
        $dataProvider = $model->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');
        $this->render('recipient', array(
            'model' => $model,
            'newModel' => $newModel,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionRecipientCreate() {
        $model = new ReceiptApprover;
        $data = Yii::app()->request->getPost('ReceiptApprover');
        if ($data) {
            $model->attributes = $data;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
                $this->redirect(array('recipient'));
            }
        }
        $this->render('recipientForm', array(
            'model' => $model,
        ));
    }

    public function actionRecipientUpdate() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $model = ReceiptApprover::model()->findByPk($pk);
        $model->{$name} = $value;
        $model->save();
    }

    public function actionRecipientDelete($id) {
        $model = ReceiptApprover::model()->findByPk($id);
        $model->delete();
    }

    public function actionPrint() {
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        $pdf = new PDFMaker;

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $receipts = Receipt::model()->findAll($criteria);
        foreach ($receipts as $receipt) {
            $pdf->addPage('receipt', array(
                'receipt' => $receipt,
            ));
            $pdf->addPage('receiptCopy', array(
                'receipt' => $receipt,
            ));
            $pdf->addPage('receiptCopy', array(
                'receipt' => $receipt,
            ));
        }
        $pdf->output();
    }

    public function actionUpdate() {
        $pk = Yii::app()->request->getPost('pk');
        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $model = Receipt::model()->findByPk($pk);

        $app = ReceiptApprover::model()->findByPk($value);
        if (isset($app)) {
            $model->approve_id = $app->id;
            $model->approve_name = $app->name;
            $model->approve_position = $app->position;
            $model->save();
        }
    }

    public function actionSetPrimary($id) {
        ReceiptApprover::model()->updateAll(array(
            'is_default' => ActiveRecord::NO,
        ));

        $model = ReceiptApprover::model()->findByPk($id);
        $model->is_default = ActiveRecord::YES;
        $model->save();
    }

}
