<?php

Yii::import('application.models._base.BaseReceipt');

class Receipt extends BaseReceipt {

    const TYPE_INDIVIDUAL = '0';
    const TYPE_OFFICE = '1';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getTypeOptions($code = null) {
        $ret = array(
            self::TYPE_INDIVIDUAL => 'บุคคล',
            self::TYPE_OFFICE => 'หน่วยงาน',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'doc_name' => 'เลขที่ใบเสร็จ',
            'payer_name' => 'ผู้ชำระเงิน',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public function getTextType() {
        return self::getTypeOptions($this->is_office);
    }

    public function search() {

        $dataProvider = parent::search();

        if (!empty($this->search['date_range'])) {
            list($start, $end) = array_pad(explode(' - ', $this->search['date_range'], 2), 2, null);
            if (isset($start, $end)) {
                $criteria = new CDbCriteria();
                $criteria->addBetweenCondition('DATE(t.payment_date)', $start, $end);
                $dataProvider->criteria->mergeWith($criteria);
            }
        }

        return $dataProvider;
    }

}
