<?php

Yii::import('application.models._base.BaseTimeDimension');

class TimeDimension extends BaseTimeDimension
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}