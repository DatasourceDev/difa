<?php

Yii::import('application.models._base.BaseUserActivityLog');

class UserActivityLog extends BaseUserActivityLog {

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

    public function relations() {
        return array_merge(parent::relations(), array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        ));
    }

}
