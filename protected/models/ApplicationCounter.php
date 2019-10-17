<?php

Yii::import('application.models._base.BaseApplicationCounter');

class ApplicationCounter extends BaseApplicationCounter {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getLastest($app_type, $app_year) {
        $model = ApplicationCounter::model()->findByAttributes(array(
            'app_type' => $app_type,
            'app_year' => $app_year,
        ));
        if (!isset($model)) {
            $model = new ApplicationCounter;
            $model->app_type = $app_type;
            $model->app_year = $app_year;
            $model->current_num = 0;
            if ($model->save()) {
                $model->isNewRecord = false;
            }
        }
        return $model;
    }

    public function getIncrement() {
        $this->current_num++;
        if ($this->save()) {
            return $this->current_num;
        }
    }

}
