<?php

/**
 * This is the model base class for the table "exam_subject_topic".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ExamSubjectTopic".
 *
 * Columns in table "exam_subject_topic" available as properties of the model,
 * followed by relations of table "exam_subject_topic" available as properties of the model.
 *
 * @property string $exam_subject_id
 * @property string $exam_topic_code
 * @property string $name
 *
 * @property ExamSubject $examSubject
 */
abstract class BaseExamSubjectTopic extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'exam_subject_topic';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ExamSubjectTopic|ExamSubjectTopics', $n);
	}

	public static function representingColumn() {
		return 'exam_topic_code';
	}

	public function rules() {
		return array(
			array('exam_subject_id, exam_topic_code', 'required'),
			array('exam_subject_id', 'length', 'max'=>10),
			array('exam_topic_code', 'length', 'max'=>2),
			array('name', 'length', 'max'=>60),
			array('name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('exam_subject_id, exam_topic_code, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'examSubject' => array(self::BELONGS_TO, 'ExamSubject', 'exam_subject_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'exam_subject_id' => null,
			'exam_topic_code' => Yii::t('app', 'Exam Topic Code'),
			'name' => Yii::t('app', 'Name'),
			'examSubject' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('exam_subject_id', $this->exam_subject_id);
		$criteria->compare('exam_topic_code', $this->exam_topic_code, true);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}