<?php

Yii::import('application.models._base.BaseExamOmrStore');

class ExamOmrStore extends BaseExamOmrStore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}