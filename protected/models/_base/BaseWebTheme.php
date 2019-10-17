<?php

/**
 * This is the model base class for the table "web_theme".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "WebTheme".
 *
 * Columns in table "web_theme" available as properties of the model,
 * followed by relations of table "web_theme" available as properties of the model.
 *
 * @property string $id
 * @property string $name
 * @property integer $is_active
 * @property string $description
 * @property string $created
 * @property string $modified
 * @property string $user_id
 *
 * @property User $user
 */
abstract class BaseWebTheme extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'web_theme';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'WebTheme|WebThemes', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('is_active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('user_id', 'length', 'max'=>10),
			array('description, created, modified', 'safe'),
			array('name, is_active, description, created, modified, user_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, is_active, description, created, modified, user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'is_active' => Yii::t('app', 'Is Active'),
			'description' => Yii::t('app', 'Description'),
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'user_id' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}