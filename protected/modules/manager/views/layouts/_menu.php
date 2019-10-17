<?php echo Helper::htmlTopic('เมนู'); ?>
<?php

$this->widget('booster.widgets.TbMenu', array(
    'encodeLabel' => false,
    'type' => 'list',
    'items' => array(
        array(
            'label' => 'จัดการการสอบ',
        ),
        array(
            'label' => $this->module->getImage('icon/home') . ' รายละเอียดการสอบ',
            'url' => array('home/index'),
            'active' => in_array($this->id, array(
                'home',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/user_frontend') . ' รายชื่อผู้เข้าสอบ (' . Yii::app()->format->formatNumber($this->examSchedule->countAttendee) . ')',
            'url' => array('application/index'),
            'active' => in_array($this->id, array(
                'application',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/user_department') . ' รายชื่อตัวแทนหน่วยงาน (' . Yii::app()->format->formatNumber($this->examSchedule->countExamScheduleAccount) . ')',
            'url' => array('office/index'),
            'active' => in_array($this->id, array(
                'office',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/home') . ' จัดการชุดข้อสอบ',
            'url' => array('examSet/index'),
            'active' => in_array($this->id, array(
                'examSet',
            )),
        ),/*
        array(
            'label' => 'ข้อมูลการสอบ',
        ),
        array(
            'label' => $this->module->getImage('icon/home') . ' ข้อมูลกระดาษคำตอบ',
            'url' => array('omr/index'),
            'active' => in_array($this->id, array(
                'omr',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/home') . ' การประกาศผลสอบ',
            'url' => array('omr/index'),
            'active' => in_array($this->id, array(
                'omr',
            )),
        ),*/
        array(
            'label' => 'รายงาน',
        ),
        array(
            'label' => $this->module->getImage('icon/report') . ' รายชื่อสำหรับติดหน้าห้องสอบ',
            'url' => array('reportNameList/index'),
            'active' => in_array($this->id, array(
                'reportNameList',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/report') . ' รายชื่อแยกตามวัตถุประสงค์',
            'url' => array('reportNameListByObjective/index'),
            'active' => in_array($this->id, array(
                'reportNameListByObjective',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/report') . ' ใบเซ็นชื่อ',
            'url' => array('reportNameSignature/index'),
            'active' => in_array($this->id, array(
                'reportNameSignature',
            )),
        ),
        array(
            'label' => $this->module->getImage('icon/report') . ' รายงานสถานะการชำระเงิน',
            'url' => array('reportPaymentStatus/index'),
            'active' => in_array($this->id, array(
                'reportPaymentStatus',
            )),
        ),
    ),
));
?>