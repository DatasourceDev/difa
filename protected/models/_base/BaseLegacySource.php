<?php

/**
 * This is the model base class for the table "legacy_source".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "LegacySource".
 *
 * Columns in table "legacy_source" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name
 * @property string $mdb_name
 * @property string $created
 * @property string $modified
 * @property integer $status
 * @property string $mdb_path
 *
 */
abstract class BaseLegacySource extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'legacy_source';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'LegacySource|LegacySources', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>160),
			array('mdb_name, mdb_path', 'length', 'max'=>250),
			array('created, modified', 'safe'),
			array('name, mdb_name, created, modified, status, mdb_path', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, mdb_name, created, modified, status, mdb_path', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('app', 'Name'),
			'mdb_name' => Yii::t('app', 'Mdb Name'),
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'status' => Yii::t('app', 'Status'),
			'mdb_path' => Yii::t('app', 'Mdb Path'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('mdb_name', $this->mdb_name, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('mdb_path', $this->mdb_path, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}