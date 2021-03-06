<?php

/**
 * This is the model base class for the table "web_download".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "WebDownload".
 *
 * Columns in table "web_download" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name_th
 * @property string $name_en
 * @property string $created
 * @property string $modified
 * @property integer $order_no
 *
 */
abstract class BaseWebDownload extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'web_download';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'WebDownload|WebDownloads', $n);
	}

	public static function representingColumn() {
		return 'name_th';
	}

	public function rules() {
		return array(
			array('order_no', 'numerical', 'integerOnly'=>true),
			array('name_th, name_en', 'length', 'max'=>120),
			array('created, modified', 'safe'),
			array('name_th, name_en, created, modified, order_no', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name_th, name_en, created, modified, order_no', 'safe', 'on'=>'search'),
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
			'created' => Yii::t('app', 'Created'),
			'modified' => Yii::t('app', 'Modified'),
			'order_no' => Yii::t('app', 'Order No'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name_th', $this->name_th, true);
		$criteria->compare('name_en', $this->name_en, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('order_no', $this->order_no);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}