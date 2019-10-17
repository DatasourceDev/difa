<?php

Yii::import('application.models._base.BaseKeyCounter');

class KeyCounter extends BaseKeyCounter {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getNewKey($id) {
        $model = KeyCounter::model()->findByPk($id);
        if (!isset($model)) {
            $model = new KeyCounter();
            $model->id = $id;
            $model->num = 0;
        }
        $model->num = $model->num + 1;
        $model->save();
        return $model->num;
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

}
