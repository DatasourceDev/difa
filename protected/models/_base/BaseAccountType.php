<?php

/**
 * This is the model base class for the table "account_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountType".
 *
 * Columns in table "account_type" available as properties of the model,
 * followed by relations of table "account_type" available as properties of the model.
 *
 * @property string $id
 * @property string $name_th
 * @property string $name_en
 * @property string $table_name
 * @property integer $is_foreigner
 * @property integer $is_diplomat
 * @property integer $is_registrable
 * @property string $display_name
 * @property string $view_name
 * @property string $color
 * @property string $key_name
 *
 * @property Account[] $accounts
 * @property ExamType[] $examTypes
 * @property ExamType[] $examTypes1
 */
abstract class BaseAccountType extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'account_type';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AccountType|AccountTypes', $n);
	}

	public static function representingColumn() {
		return 'name_th';
	}

	public function rules() {
		return array(
			array('id', 'required'),
			array('is_foreigner, is_diplomat, is_registrable', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('name_th, name_en, table_name, display_name, view_name, key_name', 'length', 'max'=>60),
			array('color', 'length', 'max'=>7),
			array('name_th, name_en, table_name, is_foreigner, is_diplomat, is_registrable, display_name, view_name, color, key_name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name_th, name_en, table_name, is_foreigner, is_diplomat, is_registrable, display_name, view_name, color, key_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'accounts' => array(self::HAS_MANY, 'Account', 'account_type_id'),
			'examTypes' => array(self::MANY_MANY, 'ExamType', 'exam_account_type(account_type_id, exam_type_id)'),
			'examTypes1' => array(self::MANY_MANY, 'ExamType', 'exam_type_account(account_type_id, exam_type_id)'),
		);
	}

	public function pivotModels() {
		return array(
			'examTypes' => 'ExamAccountType',
			'examTypes1' => 'ExamTypeAccount',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name_th' => Yii::t('app', 'Name Th'),
			'name_en' => Yii::t('app', 'Name En'),
			'table_name' => Yii::t('app', 'Table Name'),
			'is_foreigner' => Yii::t('app', 'Is Foreigner'),
			'is_diplomat' => Yii::t('app', 'Is Diplomat'),
			'is_registrable' => Yii::t('app', 'Is Registrable'),
			'display_name' => Yii::t('app', 'Display Name'),
			'view_name' => Yii::t('app', 'View Name'),
			'color' => Yii::t('app', 'Color'),
			'key_name' => Yii::t('app', 'Key Name'),
			'accounts' => null,
			'examTypes' => null,
			'examTypes1' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name_th', $this->name_th, true);
		$criteria->compare('name_en', $this->name_en, true);
		$criteria->compare('table_name', $this->table_name, true);
		$criteria->compare('is_foreigner', $this->is_foreigner);
		$criteria->compare('is_diplomat', $this->is_diplomat);
		$criteria->compare('is_registrable', $this->is_registrable);
		$criteria->compare('display_name', $this->display_name, true);
		$criteria->compare('view_name', $this->view_name, true);
		$criteria->compare('color', $this->color, true);
		$criteria->compare('key_name', $this->key_name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}