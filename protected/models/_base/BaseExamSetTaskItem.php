<?php

/**
 * This is the model base class for the table "exam_set_task_item".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ExamSetTaskItem".
 *
 * Columns in table "exam_set_task_item" available as properties of the model,
 * followed by relations of table "exam_set_task_item" available as properties of the model.
 *
 * @property string $exam_set_id
 * @property integer $task_no
 * @property integer $order_no
 * @property string $answer
 *
 * @property ExamSet $examSet
 */
abstract class BaseExamSetTaskItem extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'exam_set_task_item';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ExamSetTaskItem|ExamSetTaskItems', $n);
	}

	public static function representingColumn() {
		return 'exam_set_id';
	}

	public function rules() {
		return array(
			array('exam_set_id, task_no, order_no', 'required'),
			array('task_no, order_no', 'numerical', 'integerOnly'=>true),
			array('exam_set_id', 'length', 'max'=>10),
			array('answer', 'length', 'max'=>32),
			array('answer', 'default', 'setOnEmpty' => true, 'value' => null),
			array('exam_set_id, task_no, order_no, answer', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'examSet' => array(self::BELONGS_TO, 'ExamSet', 'exam_set_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'exam_set_id' => null,
			'task_no' => Yii::t('app', 'Task No'),
			'order_no' => Yii::t('app', 'Order No'),
			'answer' => Yii::t('app', 'Answer'),
			'examSet' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('exam_set_id', $this->exam_set_id);
		$criteria->compare('task_no', $this->task_no);
		$criteria->compare('order_no', $this->order_no);
		$criteria->compare('answer', $this->answer, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}