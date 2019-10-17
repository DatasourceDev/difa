<?php

ini_set("soap.wsdl_cache_enabled", 0);
Yii::import('application.models.ktb.*');

class KtbController extends Controller {

    public function accessRules() {
        return array(
            array(
                'allow',
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'ws' => array(
                'class' => 'CWebServiceAction',
                'serviceOptions' => array(
                    'soapVersion' => '1.2',
                    'generatorConfig' => array(
                        'class' => 'CWsdlGenerator',
                        'bindingStyle' => 'document',
                        'operationBodyStyle' => array(
                            'use' => 'literal',
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * doTest
     * @param ApproveRequest Input
     * @return ApproveRequest Output
     * @soap
     */
    function doTest($ApproveRequest) {
        return array('ApproveRequest' => $ApproveRequest);
    }

    /**
     * doInquiry
     * @param InquiryRequest Input
     * @return InquiryResponse Output
     * @soap
     */
    function doInquiry($InquiryRequest) {
        /*
          $Toutput = new Toutput;
          $payment = TravelerPayment::model()->findByAttributes(array(
          'invoice_code' => $ConfirmTracking->TrackingNo,
          'invoice_temp' => $ConfirmTracking->VoucherNumber,
          ));

          switch ($ConfirmTracking->Status) {
          case 'V0': // ask exisited
          if (isset($payment)) {
          $payment->pay_log = $payment->pay_log . "---CHECKSTATUS---------------------------\r\n" . var_export($UpdateStatus, true) . "\r\n\r\n";
          $payment->save();
          $Toutput->ResponseCode = 'SUCCESS';
          $Toutput->ResponseDetail = '';
          } else {
          $Toutput->ResponseCode = 'FAILURE';
          $Toutput->ResponseDetail = '001Invoice Rejected';
          }
          break;

          case 'SUC': // paid
          $payment->pay_bank = 2; // BBL
          $payment->pay_amount = $payment->invoice_amount;
          $payment->pay_date = new CDbExpression('NOW()');
          $payment->pay_reference = $voucher->VoucherNumber;
          $payment->pay_invoice = $voucher->TrackingNumber;
          $payment->pay_log = $payment->pay_log . "---UPDATESTATUS---------------------------\r\n" . var_export($UpdateStatus, true) . "\r\n\r\n";
          $payment->pay_ip = Yii::app()->request->userHostAddress;
          $payment->pay_retry = $payment->pay_retry + 1;
          $payment->pay_status = $voucher->Status;
          $payment->pay_detail = $voucher->Remark;
          $payment->approve_code = $voucher->VoucherNumber;
          $payment->is_paid = ActiveRecord::YES;
          $payment->save();
          $UpdateStatusResponse->Output->ResponseCode = 'SUCCESS';
          $UpdateStatusResponse->Output->ResponseDetails[] = '';
          break;
          default:
          $Toutput->ResponseCode = 'FAILURE';
          $Toutput->ResponseDetail = '001Invoice Rejected';
          break;
          }
          return $Toutput; */
    }

    /**
     * doApprove
     * @param ApproveRequest Input
     * @return ApproveResponse Output
     * @soap
     */
    function doApprove($ApproveRequest) {
        $case = -1;
        $errMsg = 'error';
        $response = new ApproveResponse;
        $response->BankRef = $ApproveRequest->BankRef;
        $response->Balance = $ApproveRequest->Amount;
        $response->TranxId = '99' . date('ymd') . str_pad(time(), 12, '0', STR_PAD_LEFT);
        if (!$this->_checkAccess($ApproveRequest->User, $ApproveRequest->Password)) {
            $case = ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE;
        } elseif ($ApproveRequest->Command !== 'Approval') {
            $case = ApplicationPayment::TESTCASE_FAILED_PROCEED;
        } elseif (substr($ApproveRequest->Ref1, 0, 3) === '990') {
            $case = substr($ApproveRequest->Ref2, 0, 3);
            $response->CusName = 'Transaction for Test';
        } else {
            $application = ExamApplication::model()->findByRef($ApproveRequest->Ref1, $ApproveRequest->Ref2);
            if (isset($application)) {
                if ($application->getIsPaid()) {
                    $case = ApplicationPayment::TESTCASE_FAILED_PAIDED;
                } elseif ($application->getIsExpired()) {
                    $case = ApplicationPayment::TESTCASE_FAILED_EXPIRED;
                } elseif (!$application->validatePaymentAmount($ApproveRequest->Amount)) {
                    $case = ApplicationPayment::TESTCASE_FAILED_AMOUNT;
                } else {
                    $case = ApplicationPayment::TESTCASE_NORMAL;
                    $response->TranxId = date('YmdHis') . str_pad($application->id, 6, '0', STR_PAD_LEFT);
                    $response->CusName = CHtml::value($application, 'account.profile.fullname');
                }
            } else {
                $case = ApplicationPayment::TESTCASE_FAILED_APPID;
            }
        }
        switch ($case) {
            case ApplicationPayment::TESTCASE_NORMAL:
                $response->RespCode = 0;
                $response->RespMsg = 'Successful';
                break;
            case ApplicationPayment::TESTCASE_FAILED_CUSID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_TESTID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_APPID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_DUEDATE:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_AMOUNT:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_AMOUNT;
                $response->RespMsg = 'Invalid price or amount';
                break;
            case ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE;
                $response->RespMsg = 'Invalid username/password';
                break;
            case ApplicationPayment::TESTCASE_FAILED_PROCEED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_PROCEED;
                $response->RespMsg = 'Unable to process transaction';
                break;
            case ApplicationPayment::TESTCASE_FAILED_EXPIRED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Out of expiration date';
                break;
            case ApplicationPayment::TESTCASE_FAILED_PAIDED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Payment already';
                break;
            default:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Other error';
                break;
        }
        $response->Info = 'Info';
        $response->Print1 = 'Line1';
        $response->Print2 = 'Line2';
        $response->Print3 = 'Line3';
        $response->Print4 = 'Line4';
        $response->Print5 = 'Line5';
        $response->Print6 = 'Line6';
        $response->Print7 = 'Line7';

        $this->_logToFile('doApprove', $ApproveRequest, $response);

        return $response;
    }

    /**
     * doPayment
     * @param PaymentRequest Input
     * @return PaymentResponse Output
     * @soap
     */
    function doPayment($PaymentRequest) {
        $case = -1;

        $errMsg = 'error';
        $response = new PaymentResponse;
        $response->BankRef = $PaymentRequest->BankRef;
        $response->Balance = $PaymentRequest->Amount;
        $response->TranxId = '99' . date('ymd') . str_pad(time(), 12, '0', STR_PAD_LEFT);
        if (!$this->_checkAccess($PaymentRequest->User, $PaymentRequest->Password)) {
            $case = ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE;
        } elseif ($PaymentRequest->Command !== 'Payment') {
            ApplicationPayment::TESTCASE_FAILED_PROCEED;
        } elseif (substr($PaymentRequest->Ref1, 0, 3) === '990') {
            $case = substr($PaymentRequest->Ref2, 0, 3);
            $response->CusName = 'Transaction for Test';
        } else {
            $application = ExamApplication::model()->findByRef($PaymentRequest->Ref1, $PaymentRequest->Ref2);
            if (isset($application)) {
                if ($application->getIsPaid()) {
                    $case = ApplicationPayment::TESTCASE_FAILED_PAIDED;
                } elseif ($application->getIsExpired()) {
                    $case = ApplicationPayment::TESTCASE_FAILED_EXPIRED;
                } elseif (!$application->validatePaymentAmount($PaymentRequest->Amount)) {
                    $case = ApplicationPayment::TESTCASE_FAILED_AMOUNT;
                } else {
                    if ($application->doPaid()) {
                        $case = ApplicationPayment::TESTCASE_NORMAL;
                        $response->TranxId = $PaymentRequest->TranxId;
                        $response->CusName = $PaymentRequest->CusName;
                    } else {
                        $case = ApplicationPayment::TESTCASE_FAILED_PROCEED;
                    }
                }
            } else {
                $case = ApplicationPayment::TESTCASE_FAILED_APPID;
            }
        }
        switch ($case) {
            case ApplicationPayment::TESTCASE_NORMAL:
                $response->RespCode = 0;
                $response->RespMsg = 'Successful';
                break;
            case ApplicationPayment::TESTCASE_FAILED_CUSID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_TESTID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_APPID:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_DUEDATE:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_APPID;
                $response->RespMsg = 'Invalid reference';
                break;
            case ApplicationPayment::TESTCASE_FAILED_AMOUNT:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_AMOUNT;
                $response->RespMsg = 'Invalid price or amount';
                break;
            case ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_AUTHENTICATE;
                $response->RespMsg = 'Invalid username/password';
                break;
            case ApplicationPayment::TESTCASE_FAILED_PROCEED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED_PROCEED;
                $response->RespMsg = 'Unable to process transaction';
                break;
            case ApplicationPayment::TESTCASE_FAILED_EXPIRED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Out of expiration date';
                break;
            case ApplicationPayment::TESTCASE_FAILED_PAIDED:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Payment already';
                break;
            default:
                $response->RespCode = ApplicationPayment::TESTCASE_FAILED;
                $response->RespMsg = 'Other error';
                break;
        }
        $response->Info = 'Info';
        $response->Print1 = 'Test1';
        $response->Print2 = 'Test2';
        $response->Print3 = 'Test3';
        $response->Print4 = 'Test4';
        $response->Print5 = 'Test5';
        $response->Print6 = 'Test6';
        $response->Print7 = 'Test7';

        $this->_logToFile('doPayment', $PaymentRequest, $response);

        return $response;
    }

    /**
     * doReversal
     * @param ReversalRequest Input
     * @return ReversalResponse Output
     * @soap
     */
    function doReversal(ReversalRequest $ReversalRequest) {
        
    }

    private function _checkAccess($user, $password) {
        if ($user === Configuration::getKey('payment_username', 'ktb') && $password === Configuration::getKey('payment_password', 'ktb@1234')) {
            return true;
        }
    }

    private function _logToFile($type, $request, $response) {
        file_put_contents(Yii::getPathOfAlias('application.runtime') . '/payment_log', print_r(array('ip' => Yii::app()->request->getUserHostAddress(),
                    'type' => $type, 'request' => $request,
                    'response' => $response,
                    'date' => date('Y-m-d H:i:s'),
                        ), true) . "\n==========================================================\n\n", FILE_APPEND);
    }

}
