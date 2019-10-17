<?php

class WebPaymentForm extends CFormModel {

    public $ref1;
    public $ref2;

    public function rules() {
        return array_merge(parent::rules(), array(
            array('ref1, ref2', 'required'),
            array('ref1', 'length', 'min' => 15, 'max' => 15),
            array('ref2', 'length', 'min' => 14, 'max' => 14),
        ));
    }

    /**
     * @return boolean
     */
    public function doPay() {
        /* @var $application ExamApplication */
        if ($this->validate()) {

            $application = ExamApplication::model()->findByRef($this->ref1, $this->ref2);
            if (!isset($application)) {
                $this->addError('ref2', 'ไม่พบรายการใดๆ ที่ตรงกับหมายเลขอ้างอิงที่ระบุ');
                return false;
            }

            if ($application->getIsPaid()) {
                $this->addError('ref2', 'ไม่สามารถดำเนินการได้ เนื่องจากเป็นรายการที่ชำระเงินเรียบร้อยแล้ว');
                return false;
            }

            if ($application->getIsExpired()) {
                $this->addError('ref2', 'ไม่สามารถดำเนินการได้ เนื่องจากหมดเขตรับชำระเงิน');
                return false;
            }

            if ($application->doPaid()) {
                return true;
            } else {
                $this->addError('ref2', 'ไม่สามารถดำเนินการได้');
            }
            return true;
        }
    }

}
