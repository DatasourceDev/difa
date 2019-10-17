<?php

Yii::import('application.models._base.BaseYiiSession');

class YiiSession extends BaseYiiSession
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}