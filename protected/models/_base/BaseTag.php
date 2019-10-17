<?php

/**
 * This is the model base class for the table "tag".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Tag".
 *
 * Columns in table "tag" available as properties of the model,
 * followed by relations of table "tag" available as properties of the model.
 *
 * @property string $id
 * @property string $name
 *
 * @property Account[] $accounts
 */
abstract class BaseTag extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tag';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tag|Tags', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'length', 'max'=>160),
			array('name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'accounts' => array(self::MANY_MANY, 'Account', 'account_tag(tag_id, account_id)'),
		);
	}

	public function pivotModels() {
		return array(
			'accounts' => 'AccountTag',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'accounts' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}