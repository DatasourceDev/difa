<?php

Yii::import('application.models._base.BaseConfiguration');

class Configuration extends BaseConfiguration {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getKey($name, $default = null) {
        $config = Configuration::model()->findByAttributes(array(
            'name' => $name,
        ));
        if (!isset($config)) {
            $config = new Configuration;
            $config->name = $name;
            $config->data = $default;
            $config->save();
        }
        return CHtml::value($config, 'data', $default);
    }

    public static function setKey($name, $data) {
        $config = Configuration::model()->findByAttributes(array(
            'name' => $name,
        ));
        if (!isset($config)) {
            $config = new Configuration;
            $config->name = $name;
        }
        $config->data = $data;
        $config->save();
    }

}
