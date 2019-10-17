<?php

/**
 * This is the model base class for the table "role_permission".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "RolePermission".
 *
 * Columns in table "role_permission" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $role_id
 * @property string $permission_id
 *
 */
abstract class BaseRolePermission extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'role_permission';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'RolePermission|RolePermissions', $n);
	}

	public static function representingColumn() {
		return array(
			'role_id',
			'permission_id',
		);
	}

	public function rules() {
		return array(
			array('role_id, permission_id', 'required'),
			array('role_id', 'numerical', 'integerOnly'=>true),
			array('permission_id', 'length', 'max'=>64),
			array('role_id, permission_id', 'safe', 'on'=>'search'),
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
			'role_id' => null,
			'permission_id' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('role_id', $this->role_id);
		$criteria->compare('permission_id', $this->permission_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}