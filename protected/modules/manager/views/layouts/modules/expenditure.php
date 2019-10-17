<?php

return array(
    'label' => $this->module->getMenuIcon('icon/expenditure') . 'ระบบบันทึกรายจ่าย',
    'items' => array(
        array(
            'label' => 'ระบบบันทึกรายจ่าย (Expenditure)',
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureOverview',
                'expenditure.expenditure',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/chart') . '01. ภาพรวมการบันทึกรายจ่าย',
            'url' => array('expenditureOverview/index'),
            'active' => in_array($this->id, array(
                'expenditureOverview',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureOverview',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/expenditure') . '02. บันทึกรายจ่าย',
            'url' => array('expenditure/index'),
            'active' => in_array($this->id, array(
                'expenditure',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditure',
            )),
        ),
        array(
            'label' => 'ข้อมูลหลัก (Master Data)',
            'visible' => Yii::app()->user->checkPermission(array(
                'expenditure.expenditureType',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '03. ข้อมูลประเภทรายจ่าย',
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
        'expenditure.expenditureOverview',
        'expenditure.expenditure',
        'expenditure.expenditureType',
    )),
);
