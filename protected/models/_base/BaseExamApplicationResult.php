<?php

abstract class BaseExamApplicationResult extends ActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'exam_application_result';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ExamApplicationResult|ExamApplicationResults', $n);
	}

	public static function representingColumn() {
		return 'capital_name';
	}

	public function rules() {
		return array(
         array('exam_application_id,exam_schedule_id,id_card, name, tel, is_request, request_number, request_delivery_type, address', 'required'),
         array('request_number,request_delivery_type, id_card, tel', 'numerical', 'integerOnly'=>true),
         array('request_delivery_type' ,'length', 'max'=>2),
         array('request_number' ,'length', 'max'=>100),
         array('id_card' ,'length', 'max'=>13),
         array('address, name', 'length', 'max'=>500),
         //array('raw_data, created, modified, update_date, grade_expire, grade_confirm_date, all_data', 'safe'),
         //array('exam_subject_id, grade, score, raw_data, created, modified, is_border_line, score_update, grade_update, update_date, update_user_id, approve_id, is_approved, is_update, grade_expire, is_grade_confirm, grade_confirm_date, grade_confirm_user_id, all_data, teacher_1, teacher_2, teacher_1_name, teacher_2_name, exam_subject_extra', 'default', 'setOnEmpty' => true, 'value' => null),
         //array('exam_application_id, exam_schedule_id, exam_set_id, exam_subject_id, grade, score, raw_data, created, modified, is_border_line, score_update, grade_update, update_date, update_user_id, approve_id, is_approved, is_update, grade_expire, is_grade_confirm, grade_confirm_date, grade_confirm_user_id, all_data, teacher_1, teacher_2, teacher_1_name, teacher_2_name, exam_subject_extra', 'safe', 'on'=>'search'),
			);
	}

	public function relations() {
		return array(
				'examApplication' => array(self::BELONGS_TO, 'ExamApplication', 'exam_application_id'),
			   'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),

		);
	}

	public function pivotModels() {
		return array();
	}

	public function attributeLabels() {
		return array(
	      'id' => Yii::t('app', 'ID'),
	      'member_id' => null,
	      'exam_application_id' => null,
	      'exam_schedule_id' => null,
         'name' => Yii::t('app', 'Name'),
         'id_card' => Yii::t('app', 'ID Card'),
         'tel' => Yii::t('app', 'Tel'),
         'is_request' => Yii::t('app', 'Is Request'),
			'request_number' => Yii::t('app', 'Request Number'),
			'request_delivery_type' => Yii::t('app', 'Delivery Type'),
			'address' => Yii::t('app', 'Address'),
			'examSchedule' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
      $criteria->compare('id', $this->id, true);
      $criteria->compare('member_id', $this->member_id);
      $criteria->compare('exam_application_id', $this->exam_application_id);
      $criteria->compare('exam_schedule_id', $this->exam_schedule_id);
      $criteria->compare('is_request', $this->is_request);
      $criteria->compare('name', $this->name);
      $criteria->compare('id_card', $this->id_card);
      $criteria->compare('tel', $this->tel);
		$criteria->compare('request_number', $this->request_number);
		$criteria->compare('request_delivery_type', $this->request_delivery_type);
		$criteria->compare('address', $this->address);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}