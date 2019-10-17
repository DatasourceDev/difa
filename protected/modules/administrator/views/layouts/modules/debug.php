<?php

return array(
    'label' => $this->module->getMenuIcon('icon/bug') . 'Debugger',
    'items' => array(
        array(
            'label' => 'จัดการข้อมูล',
            'items' => array(
                array(
                    'label' => 'ตัวแทนหน่วยงาน',
                    'url' => array('debugOfficeUser/index'),
                ),
            ),
        ),
        array(
            'label' => 'ลบข้อมูล',
            'items' => array(
                array(
                    'label' => 'ผู้สมัครทั้งหมด',
                    'url' => array('debug/memberClear'),
                ),
            ),
        ),
        array(
            'label' => 'ทดสอบส่งอีเมล์',
            'url' => array('debug/mail'),
        ),
        array(
            'label' => 'ทดสอบการชำระเงิน',
            'url' => array('debugPayment/index'),
        ),
        array(
            'label' => 'สร้างตารางสิทธิการใช้งาน',
            'url' => array('debug/generatePermission'),
        ),
    ),
    //'visible' => YII_DEBUG && Yii::app()->user->getModel()->getIsSuperUser(),
    'visible' => false,
);
