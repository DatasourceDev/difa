<?php

/**
 * This is the model base class for the table "account_inquiry".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountInquiry".
 *
 * Columns in table "account_inquiry" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property integer $account_id
 * @property string $name
 * @property string $email
 * @property string $topic
 * @property string $message
 * @property string $created
 * @property string $modified
 * @property integer $is_done
 * @property string $reply_message
 * @property string $reply_datetime
 * @property integer $user_id
 * @property string $title
 * @property string $firstname
 * @property string $midname
 * @property string $lastname
 * @property string $place_of_birth
 *
 */
abstract class BaseAccountInquiry extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'account_inquiry';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AccountInquiry|AccountInquiries', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('account_id, is_done, user_id', 'numerical', 'integerOnly'=>true),
			array('name, email, title, midname', 'length', 'max'=>60),
			array('topic', 'length', 'max'=>150),
			array('firstname, lastname, place_of_birth', 'length', 'max'=>160),
			array('message, created, modified, reply_message, reply_datetime', 'safe'),
			array('account_id, name, email, topic, message, created, modified, is_done, reply_message, reply_datetime, user_id, title, firstname, midname, lastname, place_of_birth', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, account_id, name, email, topic, message, created, modified, is_done, reply_message, reply_datetime, user_id, title, firstname, midname, lastname, place_of_birth', 'safe', 'on'=>'search'),
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
			'account_id' => Yii::t('app', 'Account'),
			'name' => Yii::t('app', 'Name'),
			'email' => Yii::t('app', 'Email'),
			'topic' => Yii::t('app', 'Topic'),
			'message' => Yii::t('app', 'Message'),
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'is_done' => Yii::t('app', 'Is Done'),
			'reply_message' => Yii::t('app', 'Reply Message'),
			'reply_datetime' => Yii::t('app', 'Reply Datetime'),
			'user_id' => Yii::t('app', 'User'),
			'title' => Yii::t('app', 'Title'),
			'firstname' => Yii::t('app', 'Firstname'),
			'midname' => Yii::t('app', 'Midname'),
			'lastname' => Yii::t('app', 'Lastname'),
			'place_of_birth' => Yii::t('app', 'Place Of Birth'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('account_id', $this->account_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('topic', $this->topic, true);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('is_done', $this->is_done);
		$criteria->compare('reply_message', $this->reply_message, true);
		$criteria->compare('reply_datetime', $this->reply_datetime, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('firstname', $this->firstname, true);
		$criteria->compare('midname', $this->midname, true);
		$criteria->compare('lastname', $this->lastname, true);
		$criteria->compare('place_of_birth', $this->place_of_birth, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}