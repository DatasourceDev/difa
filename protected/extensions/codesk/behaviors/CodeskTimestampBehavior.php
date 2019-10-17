<?php

Yii::import('zii.behaviors.CTimestampBehavior');

class CodeskTimestampBehavior extends CTimestampBehavior {

    public $createAttribute = 'created';
    public $updateAttribute = 'modified';
    public $setUpdateOnCreate = true;

}
