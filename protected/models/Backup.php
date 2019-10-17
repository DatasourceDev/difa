<?php

Yii::import('application.models._base.BaseBackup');

class Backup extends BaseBackup
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}