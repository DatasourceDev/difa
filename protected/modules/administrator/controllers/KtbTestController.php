<?php

class KtbTestController extends AdministratorController {

    public function init() {
        parent::init();
        Yii::import('application.models.ktb.*');
    }

    public function actionIndex() {
        $model = new ExamApplication('ktbPayment');
        $model->unsetAttributes();
        $data = Yii::app()->request->getPost('ExamApplication');
        if (isset($data)) {
            $params = $model->parsePaymentCode($data['payment_code']);
            $soap = new SoapClient($this->createAbsoluteUrl('/ktb/ws'), array('trace' => 1, 'exceptions' => 1));

            $request = new ApproveRequest;
            $request->User = Configuration::getKey('payment_username');
            $request->Password = Configuration::getKey('payment_password');
            $request->ComCode = Configuration::getKey('payment_compcode');
            $request->ProdCode = Configuration::getKey('payment_compcode');
            $request->Command = 'Approval';
            $request->BankCode = 1;
            $request->BankRef = 'KTB';
            $request->DateTime = date('Y-m-d H:i:s');
            $request->EffDate = date('Y-m-d H:i:s');
            $request->Channel = '1';
            $request->Amount = CHtml::value($params, 'amount');
            $request->CusName = CHtml::value($params, 'entry_code');
            $request->Ref1 = CHtml::value($params, 'ref1');
            $request->Ref2 = CHtml::value($params, 'ref2');
            $request->Ref3 = CHtml::value($params, 'ref1');
            $request->Ref4 = CHtml::value($params, 'ref2');

            try {
                $result = $soap->doApprove(array('ApproveRequest' => $request));
                if ($result->doApproveResult->RespCode == 0) {
                    $paymentRequest = new PaymentRequest;
                    $paymentRequest->TranxId = $result->doApproveResult->TranxId;
                    $paymentRequest->User = Configuration::getKey('payment_username');
                    $paymentRequest->Password = Configuration::getKey('payment_password');
                    $paymentRequest->ComCode = Configuration::getKey('payment_compcode');
                    $paymentRequest->ProdCode = Configuration::getKey('payment_compcode');
                    $paymentRequest->Command = 'Payment';
                    $paymentRequest->BankCode = 1;
                    $paymentRequest->BankRef = 'KTB';
                    $paymentRequest->DateTime = date('Y-m-d H:i:s');
                    $paymentRequest->EffDate = date('Y-m-d H:i:s');
                    $paymentRequest->Channel = '1';
                    $paymentRequest->Amount = CHtml::value($params, 'amount');
                    $paymentRequest->CusName = CHtml::value($params, 'entry_code');
                    $paymentRequest->Ref1 = CHtml::value($params, 'ref1');
                    $paymentRequest->Ref2 = CHtml::value($params, 'ref2');
                    $paymentRequest->Ref3 = CHtml::value($params, 'ref1');
                    $paymentRequest->Ref4 = CHtml::value($params, 'ref2');
                    $result = $soap->doPayment(array('PaymentRequest' => $paymentRequest));
                    if ($result->doPaymentResult->RespCode == 0) {
                        return true;
                    } else {
                        echo '<pre>';
                        var_dump($result);
                        exit;
                    }
                } else {
                    echo '<pre>';
                    var_dump($result);
                    exit;
                }
            } catch (SoapFault $e) {
                echo '<pre>';

                echo "Request :<br>", htmlentities($soap->__getLastRequest()), "<br>";
                echo "Response :<br>", htmlentities($soap->__getLastResponse()), "<br>";
                exit;
            }
        }
        $model = new ExamApplication;
        $model->unsetAttributes();
        $dataProvider = $model->search();

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionCheckRef() {
        echo '<pre>';
        $code = ExamApplication::model()->parsePaymentCode('|099400016006290 579949305005451 16100156220316 0000150000');
        var_dump($code);
        var_dump((int) substr($code['ref1'], 13, 2));
        $model = ExamApplication::model()->findByRef($code['ref1'], $code['ref2']);
        var_dump($model);
    }

}
