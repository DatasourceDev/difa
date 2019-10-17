<?php

return array(
    'label' => $this->module->getMenuIcon('icon/exam') . 'ข้อมูลการสอบ/จัดสอบ',
    'items' => array(
        array(
            'label' => 'ระบบจัดสอบ',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/schedule') . '01. ปฏิทินการสอบ',
            'url' => array('manageSchedule/calendar'),
            'active' => $this->action->id === 'calendar' && in_array($this->id, array(
                'manageSchedule',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageSchedule.calendar',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/schedule') . '02. ข้อมูลการจัดสอบ',
            'url' => array('manageSchedule/index'),
            'active' => $this->action->id !== 'calendar' && in_array($this->id, array(
                'manageSchedule',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageSchedule.index',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/manage_schedule_application') . '03. ข้อมูลการสมัครสอบ',
            'url' => array('manageScheduleApplication/index'),
            'active' => in_array($this->id, array(
                'manageScheduleApplication',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageScheduleApplication',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/expenditure') . '04. ข้อมูลการชำระเงิน',
            'url' => array('manageSchedulePayment/index'),
            'active' => in_array($this->id, array(
                'manageSchedulePayment',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageSchedulePayment',
            )),
        ),
        array(
            'label' => 'ระบบจัดการข้อมูลการสอบ',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/manage') . '05. จัดการชุดข้อสอบ',
            'url' => array('manageExamSet/index'),
            'active' => in_array($this->id, array(
                'manageExamSet',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageExamSet',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/manage') . '06. จัดการการสอบ',
            'url' => array('manageExam/index'),
            'active' => in_array($this->id, array(
                'manageExam',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageExam',
            )),
        ),
        array(
            'label' => 'ข้อมูลหลัก',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '07. ข้อมูลสถานที่จัดสอบ',
            'url' => array('manageSchedulePlace/index'),
            'active' => in_array($this->id, array(
                'manageSchedulePlace',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageSchedulePlace',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '08. ข้อมูลวันหยุดนักขัตฤกษ์',
            'url' => array('manageScheduleHoliday/index'),
            'active' => in_array($this->id, array(
                'manageScheduleHoliday',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageScheduleHoliday',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '09. ข้อมูลวัตถุประสงค์ในการสอบ',
            'url' => array('manageExamObjective/index'),
            'active' => in_array($this->id, array(
                'manageExamObjective',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageExamObjective',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '10. ข้อมูลชนิดของแบบทดสอบ',
            'url' => array('manageExamQuestionMethod/index'),
            'active' => in_array($this->id, array(
                'manageExamQuestionMethod',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'exam.manageExamQuestionMethod',
            )),
        ),
    ),
    'active' => in_array($this->id, array(
        'manageExamSet',
        'manageExam',
        'manageExamObjective',
        'manageExamQuestionMethod',
        'manageExamHoliday',
        'manageSchedule',
        'manageScheduleApplication',
        'manageSchedulePayment',
    )),
    'visible' => Yii::app()->user->checkPermission(array(
        'exam.manageExamSet',
        'exam.manageExam',
        'exam.manageExamObjective',
        'exam.manageExamQuestionMethod',
        'exam.manageExamHoliday',
        'exam.manageSchedule.index',
        'exam.manageSchedule.calendar',
        'exam.manageScheduleApplication',
        'exam.manageSchedulePayment',
    )),
);
