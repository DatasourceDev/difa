<?php

return array(
    'label' => $this->module->getMenuIcon('icon/expenditure') . 'บันทึกรายรับ/รายจ่าย',
    'items' => array(
        array(
            'label' => 'ระบบบันทึกรายรับ (Income)',
            'visible' => Yii::app()->user->checkPermission(array(
                'income.incomeType',
                'income.incomeOverview',
                'income.income',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/chart') . '01. ภาพรวมการบันทึกรายรับ',
            'url' => array('incomeOverview/index'),
            'active' => in_array($this->id, array(
                'incomeOverview',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'income.incomeOverview',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/expenditure') . '02. บันทึกรายรับ',
            'url' => array('income/index'),
            'active' => in_array($this->id, array(
                'income',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'income.income',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '03. ข้อมูลประเภทรายรับ',
            'url' => array('incomeType/index'),
            'active' => in_array($this->id, array(
                'incomeType',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'income.incomeType',
            )),
        ),
        array(
            'label' => 'ระบบบันทึกรายจ่าย (Expenditure)',
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureType',
                'expenditure.expenditureOverview',
                'expenditure.expenditure',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/chart') . '04. ภาพรวมการบันทึกรายจ่าย',
            'url' => array('expenditureOverview/index'),
            'active' => in_array($this->id, array(
                'expenditureOverview',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureOverview',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/expenditure') . '05. บันทึกรายจ่าย',
            'url' => array('expenditure/index'),
            'active' => in_array($this->id, array(
                'expenditure',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditure',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '06. ข้อมูลประเภทรายจ่าย',
            'url' => array('expenditureType/index'),
            'active' => in_array($this->id, array(
                'expenditureType',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureType',
            )),
        ),
    ),
    'visible' => Yii::app()->user->checkPermission(array(
        'income.incomeOverview',
        'income.income',
        'income.incomeType',
        'expenditure.expenditureOverview',
        'expenditure.expenditure',
        'expenditure.expenditureType',
    )),
);
