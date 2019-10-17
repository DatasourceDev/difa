<?php

Yii::import('application.models._base.BaseOmrSource');

class OmrSource extends BaseOmrSource
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}