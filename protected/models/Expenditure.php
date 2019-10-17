<?php

Yii::import('application.models._base.BaseExpenditure');

class Expenditure extends BaseExpenditure {

    public $m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8, $m9, $m10, $m11, $m12, $y;
    public $year;
    public $month;
    public $date_start;
    public $date_end;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'expenditure_type_id' => 'ประเภทรายจ่าย',
            'amount' => 'จำนวนเงิน',
            'comment' => 'หมายเหตุ',
            'expenditure_date' => 'วันที่บันทึกรายการ',
            'description' => 'รายละเอียด',
        ));
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

    public function relations() {
        return array_merge(parent::relations(), array(
            'expenditureType' => array(self::BELONGS_TO, 'ExpenditureType', 'expenditure_type_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('expenditure_type_id, amount, expenditure_date', 'required'),
            array('amount', 'numerical', 'min' => 0),
            array('year, month', 'safe'),
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public function search() {
        $dataProvider = parent::search();

        if (!empty($this->search['date_start'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(expenditure_date)', '>=' . $this->search['date_start']);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['date_end'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(expenditure_date)', '<=' . $this->search['date_end']);
            $dataProvider->criteria->mergeWith($criteria);
        }

        return $dataProvider;
    }

    public function monthly() {
        $criteria = new CDbCriteria();
        $criteria->select = array(
            '*',
        );
        for ($i = 1; $i <= 12; $i++) {
            $criteria->select[] = 'SUM(IF(MONTH(expenditure_date)=' . $i . ',amount,0)) as m' . $i;
        }
        $criteria->select[] = 'SUM(amount) as y';

        $criteria->group = 'YEAR(expenditure_date), MONTH(expenditure_date)';
        $criteria->compare('YEAR(expenditure_date)', $this->year);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function summary() {
        $criteria = new CDbCriteria();
        $criteria->select = array(
            '*',
        );
        for ($i = 1; $i <= 12; $i++) {
            $criteria->select[] = 'SUM(IF(MONTH(expenditure_date)=' . $i . ',amount,0)) as m' . $i;
        }
        $criteria->select[] = 'SUM(amount) as y';
        $criteria->compare('YEAR(expenditure_date)', $this->year);
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function reportDaily() {
        $this->reportSummary();
        $criteria = new CDbCriteria();
        $criteria->group = 'DATE(t.expenditure_date)';
        $this->dbCriteria->mergeWith($criteria);
        return $this;
    }

    public function reportSummary() {
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'DATE(t.expenditure_date) as expenditure_date',
            'SUM(t.amount) as amount',
        );
        $this->dbCriteria->mergeWith($criteria);

        if (isset($this->search['date_range'])) {
            list($this->date_start, $this->date_end) = array_pad(explode(' - ', $this->search['date_range']), 2, date('Y-m-d'));
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition('DATE(t.expenditure_date)', $this->date_start, $this->date_end);
            $this->dbCriteria->mergeWith($criteria);
        }
        return $this;
    }

}
