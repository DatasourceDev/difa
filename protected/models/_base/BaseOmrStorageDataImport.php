<?php

/**
 * This is the model base class for the table "omr_storage_data_import".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OmrStorageDataImport".
 *
 * Columns in table "omr_storage_data_import" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $hash_id
 * @property string $exam_set
 * @property string $dvifa_code
 * @property integer $exam_num
 * @property string $raw_data
 * @property string $json_data
 * @property integer $is_modified
 * @property string $import_date
 *
 */
abstract class BaseOmrStorageDataImport extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'omr_storage_data_import';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'OmrStorageDataImport|OmrStorageDataImports', $n);
	}

	public static function representingColumn() {
		return 'hash_id';
	}

	public function rules() {
		return array(
			array('hash_id, exam_set, dvifa_code, exam_num', 'required'),
			array('exam_num, is_modified', 'numerical', 'integerOnly'=>true),
			array('hash_id', 'length', 'max'=>64),
			array('exam_set', 'length', 'max'=>10),
			array('dvifa_code', 'length', 'max'=>13),
			array('raw_data, json_data, import_date', 'safe'),
			array('raw_data, json_data, is_modified, import_date', 'default', 'setOnEmpty' => true, 'value' => null),
			array('hash_id, exam_set, dvifa_code, exam_num, raw_data, json_data, is_modified, import_date', 'safe', 'on'=>'search'),
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
			'hash_id' => Yii::t('app', 'Hash'),
			'exam_set' => Yii::t('app', 'Exam Set'),
			'dvifa_code' => Yii::t('app', 'Dvifa Code'),
			'exam_num' => Yii::t('app', 'Exam Num'),
			'raw_data' => Yii::t('app', 'Raw Data'),
			'json_data' => Yii::t('app', 'Json Data'),
			'is_modified' => Yii::t('app', 'Is Modified'),
			'import_date' => Yii::t('app', 'Import Date'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('hash_id', $this->hash_id, true);
		$criteria->compare('exam_set', $this->exam_set, true);
		$criteria->compare('dvifa_code', $this->dvifa_code, true);
		$criteria->compare('exam_num', $this->exam_num);
		$criteria->compare('raw_data', $this->raw_data, true);
		$criteria->compare('json_data', $this->json_data, true);
		$criteria->compare('is_modified', $this->is_modified);
		$criteria->compare('import_date', $this->import_date, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}