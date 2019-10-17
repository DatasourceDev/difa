<?php

return array(
    'label' => $this->module->getMenuIcon('icon/storage') . 'ประมวลผล/จัดเก็บ',
    'items' => array(
        array(
            'label' => 'ระบบประมวลผลสอบ',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/process') . '01. ประมวลผลการสอบ',
            'url' => array('examProcess/index'),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.examProcess',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/process') . '02. รายการตรวจข้อสอบ',
            'url' => array('examProcessExamSet/index'),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.examProcessExamSet',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/validate') . '03. รายชื่อผู้ที่ได้คะแนนเท่ากับ Border Line',
            'url' => array('examProcessBorderLine/index'),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.examProcessBorderLine',
            )),
        ),
        array(
            'label' => 'ระบบจัดเก็บและสืบค้นกระดาษคำตอบ',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/storage') . '04. นำเข้าข้อมูลกระดาษคำตอบ',
            'url' => array('omrStorage/import'),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.omrStorage.import',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/search') . '05. ค้นหากระดาษคำตอบ',
            'url' => array('omrStorage/index'),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.omrStorage.index',
            )),
        ),
        array(
            'label' => 'ข้อมูลจากระบบเดิม',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/mdb') . '06. ข้อมูลจากระบบเดิม',
            'url' => array('legacy/index'),
            'active' => in_array($this->id, array(
                'legacy',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'process.legacy',
            )),
        ),
    ),
    'active' => in_array($this->id, array(
        'legacy',
        'omrStorage',
        'examProcess',
        'examProcessExamSet',
        'examProcessBorderLine',
    )),
    'visible' => Yii::app()->user->checkPermission(array(
        'process.examProcess',
        'process.examProcessExamSet',
        'process.examProcessBorderLine',
        'process.omrStorage.import',
        'process.omrStorage.index',
        'process.legacy',
    )),
);


