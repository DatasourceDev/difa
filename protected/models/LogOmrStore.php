<?php

Yii::import('application.models._base.BaseLogOmrStore');

class LogOmrStore extends BaseLogOmrStore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}