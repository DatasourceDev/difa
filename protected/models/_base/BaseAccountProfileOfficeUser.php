<?php

/**
 * This is the model base class for the table "account_profile_office_user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountProfileOfficeUser".
 *
 * Columns in table "account_profile_office_user" available as properties of the model,
 * followed by relations of table "account_profile_office_user" available as properties of the model.
 *
 * @property string $account_id
 * @property string $title_th
 * @property string $firstname_th
 * @property string $lastname_th
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $contact_mobile
 * @property integer $work_office_type
 * @property integer $work_office_id
 * @property string $work_office
 * @property string $work_department
 * @property string $work_unit
 *
 * @property Account $account
 */
abstract class BaseAccountProfileOfficeUser extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'account_profile_office_user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AccountProfileOfficeUser|AccountProfileOfficeUsers', $n);
	}

	public static function representingColumn() {
		return 'title_th';
	}

	public function rules() {
		return array(
			array('account_id', 'required'),
			array('work_office_type, work_office_id', 'numerical', 'integerOnly'=>true),
			array('account_id', 'length', 'max'=>10),
			array('title_th, firstname_th, lastname_th, contact_email, contact_phone, contact_mobile, work_office, work_department, work_unit', 'length', 'max'=>60),
			array('title_th, firstname_th, lastname_th, contact_email, contact_phone, contact_mobile, work_office_type, work_office_id, work_office, work_department, work_unit', 'default', 'setOnEmpty' => true, 'value' => null),
			array('account_id, title_th, firstname_th, lastname_th, contact_email, contact_phone, contact_mobile, work_office_type, work_office_id, work_office, work_department, work_unit', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'account_id' => null,
			'title_th' => Yii::t('app', 'Title Th'),
			'firstname_th' => Yii::t('app', 'Firstname Th'),
			'lastname_th' => Yii::t('app', 'Lastname Th'),
			'contact_email' => Yii::t('app', 'Contact Email'),
			'contact_phone' => Yii::t('app', 'Contact Phone'),
			'contact_mobile' => Yii::t('app', 'Contact Mobile'),
			'work_office_type' => Yii::t('app', 'Work Office Type'),
			'work_office_id' => Yii::t('app', 'Work Office'),
			'work_office' => Yii::t('app', 'Work Office'),
			'work_department' => Yii::t('app', 'Work Department'),
			'work_unit' => Yii::t('app', 'Work Unit'),
			'account' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('account_id', $this->account_id);
		$criteria->compare('title_th', $this->title_th, true);
		$criteria->compare('firstname_th', $this->firstname_th, true);
		$criteria->compare('lastname_th', $this->lastname_th, true);
		$criteria->compare('contact_email', $this->contact_email, true);
		$criteria->compare('contact_phone', $this->contact_phone, true);
		$criteria->compare('contact_mobile', $this->contact_mobile, true);
		$criteria->compare('work_office_type', $this->work_office_type);
		$criteria->compare('work_office_id', $this->work_office_id);
		$criteria->compare('work_office', $this->work_office, true);
		$criteria->compare('work_department', $this->work_department, true);
		$criteria->compare('work_unit', $this->work_unit, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}