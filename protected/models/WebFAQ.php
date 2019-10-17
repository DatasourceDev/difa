<?php

Yii::import('application.models._base.BaseWebFAQ');

class WebFAQ extends BaseWebFAQ {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getMaxOrder() {
        return Yii::app()->db->createCommand('SELECT COALESCE(MAX(order_no),0) FROM web_faq LIMIT 1')->queryScalar();
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'question' => 'คำถาม',
            'content' => 'เนื้อหา',
            'order_no' => 'ลำดับ',
        ));
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (!isset($this->order_no)) {
                $this->order_no = self::getMaxOrder() + 1;
            }
            return true;
        }
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('question', 'required'),
            array('content', 'required'),
        ));
    }

    public function doMoveDown() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('order_no > :current');
        $criteria->order = '(order_no - :current)';
        $criteria->limit = 1;
        $criteria->params = array(
            ':current' => $this->order_no,
        );
        $model = WebFAQ::model()->find($criteria);
        if (isset($model)) {
            $tmp = $model->order_no;
            $model->order_no = $this->order_no;
            $this->order_no = $tmp;
            if ($model->save()) {
                $this->save();
                return true;
            }
        }
    }

    public function doMoveUp() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('order_no < :current');
        $criteria->order = '(:current - order_no)';
        $criteria->limit = 1;
        $criteria->params = array(
            ':current' => $this->order_no,
        );
        $model = WebFAQ::model()->find($criteria);
        if (isset($model)) {
            $tmp = $model->order_no;
            $model->order_no = $this->order_no;
            $this->order_no = $tmp;
            if ($model->save()) {
                $this->save();
                return true;
            }
        }
    }

}
