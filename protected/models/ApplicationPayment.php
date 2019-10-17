<?php

Yii::import('application.models._base.BaseApplicationPayment');

class ApplicationPayment extends BaseApplicationPayment {

    const TESTCASE_NORMAL = '0';
    const TESTCASE_FAILED = '999';
    const TESTCASE_FAILED_CUSID = '104';
    const TESTCASE_FAILED_TESTID = '104';
    const TESTCASE_FAILED_APPID = '104';
    const TESTCASE_FAILED_DUEDATE = '104';
    const TESTCASE_FAILED_AMOUNT = '108';
    const TESTCASE_FAILED_EXPIRED = '107';
    const TESTCASE_FAILED_PAIDED = '106';
    const TESTCASE_FAILED_PROCEED = '100';
    const TESTCASE_FAILED_AUTHENTICATE = '101';
    const STATUS_SUCCESS = '00';
    const STATUS_FAILED = '90';
    const STATUS_EXPIRED = '91';
    const STATUS_DUPLICATED = '92';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        ));
    }

    public function createTestCase($status) {
        $this->com_code = Configuration::getKey('payment_compcode');
        $this->is_test = 1;
        $this->issue_date = date('Y-m-d');
        $this->due_date = date('Y-m-d', strtotime('+14 days'));
        switch ($status) {
            case self::TESTCASE_NORMAL:
                $this->test_expect_result = self::STATUS_SUCCESS;
                break;
            case self::TESTCASE_FAILED_EXPIRED:
                $this->issue_date = date('Y-m-d', strtotime('-14 days'));
                $this->due_date = date('Y-m-d', strtotime('-7 days'));
                $this->test_expect_result = self::STATUS_FAILED;
                break;
            default:
                $this->test_expect_result = self::STATUS_FAILED;
                break;
        }
        $this->amount = 1500.00;
        $this->ref1 = '990' . str_pad(mt_rand(0, 2000000000), 10, '0', STR_PAD_LEFT) . '99';
        $this->ref2 = $status . str_pad(Yii::app()->db->createCommand('SELECT MAX(COALESCE(id,0))+1 FROM application_payment')->queryScalar(), 5, '0', 0) . date('dmy', strtotime($this->due_date));
        $this->payment_log .= date('Y-m-d H:i:s') . "\t" . 'create payment slip (test)';
        if ($this->save()) {
            return true;
        }
    }

    public function getDeskCode() {
        if (isset($this->examApplication)) {
            return $this->examApplication->desk_code;
        }
        return '0000000000000 000 000000-000';
    }

    public function getPaymentCode() {
        if (isset($this->examApplication)) {
            return $this->examApplication->payment_code;
        }
        return '|' . Configuration::getKey('payment_tax') . ' ' .
                str_pad(CHtml::value($this, 'ref1'), 15, '0', STR_PAD_LEFT) . ' ' .
                str_pad(CHtml::value($this, 'ref2'), 14, '0', STR_PAD_LEFT) . ' ' .
                str_pad((int) CHtml::value($this, 'amount') . '00', 10, '0', STR_PAD_LEFT);
    }

}
