<?php

/**
 * This is the model base class for the table "code_department".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CodeDepartment".
 *
 * Columns in table "code_department" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name_th
 * @property string $name_en
 * @property integer $department_type_id
 *
 */
abstract class BaseCodeDepartment extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'code_department';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'CodeDepartment|CodeDepartments', $n);
	}

	public static function representingColumn() {
		return 'name_th';
	}

	public function rules() {
		return array(
			array('id, department_type_id', 'required'),
			array('department_type_id', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('name_th, name_en', 'length', 'max'=>150),
			array('name_th, name_en', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name_th, name_en, department_type_id', 'safe', 'on'=>'search'),
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
			'name_th' => Yii::t('app', 'Name Th'),
			'name_en' => Yii::t('app', 'Name En'),
			'department_type_id' => Yii::t('app', 'Department Type'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name_th', $this->name_th, true);
		$criteria->compare('name_en', $this->name_en, true);
		$criteria->compare('department_type_id', $this->department_type_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}