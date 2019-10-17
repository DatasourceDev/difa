<?php

/**
 * This is the model base class for the table "configuration".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Configuration".
 *
 * Columns in table "configuration" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $name
 * @property string $data
 * @property string $description
 * @property string $group_name
 * @property integer $order_no
 *
 */
abstract class BaseConfiguration extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'configuration';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Configuration|Configurations', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('order_no', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('group_name', 'length', 'max'=>60),
			array('data, description', 'safe'),
			array('data, description, group_name, order_no', 'default', 'setOnEmpty' => true, 'value' => null),
			array('name, data, description, group_name, order_no', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'name' => Yii::t('app', 'Name'),
			'data' => Yii::t('app', 'Data'),
			'description' => Yii::t('app', 'Description'),
			'group_name' => Yii::t('app', 'Group Name'),
			'order_no' => Yii::t('app', 'Order No'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('name', $this->name, true);
		$criteria->compare('data', $this->data, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('group_name', $this->group_name, true);
		$criteria->compare('order_no', $this->order_no);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}