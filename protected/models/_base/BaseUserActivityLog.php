<?php

/**
 * This is the model base class for the table "user_activity_log".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UserActivityLog".
 *
 * Columns in table "user_activity_log" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $user_id
 * @property string $created
 * @property string $modified
 * @property string $message
 *
 */
abstract class BaseUserActivityLog extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'user_activity_log';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'UserActivityLog|UserActivityLogs', $n);
	}

	public static function representingColumn() {
		return 'created';
	}

	public function rules() {
		return array(
			array('user_id', 'required'),
			array('user_id', 'length', 'max'=>10),
			array('created, modified, message', 'safe'),
			array('created, modified, message', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, user_id, created, modified, message', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app', 'ID'),
			'user_id' => Yii::t('app', 'User'),
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'message' => Yii::t('app', 'Message'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('message', $this->message, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}