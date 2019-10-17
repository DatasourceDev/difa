<?php

/**
 * This is the model base class for the table "exam_schedule_item".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ExamScheduleItem".
 *
 * Columns in table "exam_schedule_item" available as properties of the model,
 * followed by relations of table "exam_schedule_item" available as properties of the model.
 *
 * @property string $exam_schedule_id
 * @property string $exam_subject_id
 * @property string $exam_set_id
 * @property string $time_start
 * @property string $time_end
 * @property string $db_date
 * @property string $place_name
 * @property string $place_remark
 * @property integer $order_no
 * @property integer $code_place_id
 *
 * @property ExamSchedule $examSchedule
 * @property ExamSubject $examSubject
 */
abstract class BaseExamScheduleItem extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'exam_schedule_item';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ExamScheduleItem|ExamScheduleItems', $n);
	}

	public static function representingColumn() {
		return 'exam_set_id';
	}

	public function rules() {
		return array(
			array('exam_schedule_id, exam_subject_id, exam_set_id', 'required'),
			array('order_no, code_place_id', 'numerical', 'integerOnly'=>true),
			array('exam_schedule_id, exam_subject_id, exam_set_id', 'length', 'max'=>10),
			array('place_name', 'length', 'max'=>150),
			array('time_start, time_end, db_date, place_remark', 'safe'),
			array('time_start, time_end, db_date, place_name, place_remark, order_no, code_place_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('exam_schedule_id, exam_subject_id, exam_set_id, time_start, time_end, db_date, place_name, place_remark, order_no, code_place_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
			'examSubject' => array(self::BELONGS_TO, 'ExamSubject', 'exam_subject_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'exam_schedule_id' => null,
			'exam_subject_id' => null,
			'exam_set_id' => Yii::t('app', 'Exam Set'),
			'time_start' => Yii::t('app', 'Time Start'),
			'time_end' => Yii::t('app', 'Time End'),
			'db_date' => Yii::t('app', 'Db Date'),
			'place_name' => Yii::t('app', 'Place Name'),
			'place_remark' => Yii::t('app', 'Place Remark'),
			'order_no' => Yii::t('app', 'Order No'),
			'code_place_id' => Yii::t('app', 'Code Place'),
			'examSchedule' => null,
			'examSubject' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('exam_schedule_id', $this->exam_schedule_id);
		$criteria->compare('exam_subject_id', $this->exam_subject_id);
		$criteria->compare('exam_set_id', $this->exam_set_id, true);
		$criteria->compare('time_start', $this->time_start, true);
		$criteria->compare('time_end', $this->time_end, true);
		$criteria->compare('db_date', $this->db_date, true);
		$criteria->compare('place_name', $this->place_name, true);
		$criteria->compare('place_remark', $this->place_remark, true);
		$criteria->compare('order_no', $this->order_no);
		$criteria->compare('code_place_id', $this->code_place_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}