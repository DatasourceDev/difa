<?php

Yii::import('application.models._base.BaseCodeHoliday');

class CodeHoliday extends BaseCodeHoliday {

    public $search;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function isWorkingDay($date) {
        if (in_array(date('D', strtotime($date)), array('Sun', 'Sat'))) {
            return false;
        }
        $holiday = CodeHoliday::model()->findByPk($date);
        if (isset($holiday)) {
            return false;
        }
        return true;
    }

    public static function getYearList() {
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'YEAR(id) as id'
        );
        $criteria->group = 'YEAR(id)';
        $criteria->order = 'id DESC';
        return CHtml::listData(CodeHoliday::model()->findAll($criteria), 'id', 'id');
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'วันที่',
            'name_th' => 'ชื่อวัน',
            'name_en' => 'Day Name',
            'search[year]' => 'ปี',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('name_th, name_en', 'required', 'on' => array('insert', 'update')),
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public function search() {
        $dataProvider = parent::search();
        if (!empty($this->search['year'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('YEAR(id)', $this->search['year']);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['date_start'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(id)', '>=' . $this->search['date_start']);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['date_end'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(id)', '<=' . $this->search['date_end']);
            $dataProvider->criteria->mergeWith($criteria);
        }
        return $dataProvider;
    }

}
