<?php

return array(
    'label' => $this->module->getMenuIcon('icon/administrator') . 'สำหรับผู้ดูแลระบบ',
    'items' => array(
        array(
            'label' => 'ระบบจัดการผู้ใช้งาน (Backend)',
            'visible' => Yii::app()->user->checkPermission(array(
                'admin.manageUser',
                'admin.manageUserGroup',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/user_backend') . '01. จัดการข้อมูลผู้ใช้งาน',
            'url' => array('manageUser/index'),
            'active' => in_array($this->id, array(
                'manageUser',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageUser'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/user_role') . '02. จัดการกลุ่มผู้ใช้งาน',
            'url' => array('manageUserGroup/index'),
            'active' => in_array($this->id, array(
                'manageUserGroup',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageUserGroup'),
        ),
        array(
            'label' => 'ระบบจัดการผู้ใช้งาน (Frontend)',
            'visible' => Yii::app()->user->checkPermission(array(
                'admin.manageMemberGeneralThai',
                'admin.manageMemberGeneralForeigner',
                'admin.manageMemberDiplomatThai',
                'admin.manageMemberDiplomatForeigner',
                'admin.manageOfficeUser',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/user_frontend') . '03. สมาชิกสัญชาติไทย',
            'url' => array('manageMemberGeneralThai/index'),
            'active' => in_array($this->id, array(
                'manageMemberGeneralThai',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageMemberGeneralThai'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/user_frontend') . '04. สมาชิกชาวต่างชาติ',
            'url' => array('manageMemberGeneralForeigner/index'),
            'active' => in_array($this->id, array(
                'manageMemberGeneralForeigner',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageMemberGeneralForeigner'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/diplomatic') . '05. นักการทูตไทย และ นักวิเทศสหการ',
            'url' => array('manageMemberDiplomatThai/index'),
            'active' => in_array($this->id, array(
                'manageMemberDiplomatThai',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageMemberDiplomatThai'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/diplomatic') . '06. นักการทูตต่างชาติ',
            'url' => array('manageMemberDiplomatForeigner/index'),
            'active' => in_array($this->id, array(
                'manageMemberDiplomatForeigner',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageMemberDiplomatForeigner'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/user_department') . '07. ตัวแทนหน่วยงาน',
            'url' => array('manageOfficeUser/index'),
            'active' => in_array($this->id, array(
                'manageOfficeUser',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.manageOfficeUser'),
        ),
        array(
            'label' => 'จัดการระบบ (Management)',
            'visible' => Yii::app()->user->checkPermission(array(
                'admin.configuration',
                'admin.configuration.sms',
                'admin.configuration.mail',
                'admin.backup',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '08. ตั้งค่าระบบ',
            'url' => array('configuration/index'),
            'active' => CHtml::value($this, 'action.id') === 'index' && in_array($this->id, array(
                'configuration',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.configuration'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '09. ตั้งค่าการแจ้งข้อความ SMS',
            'url' => array('configuration/sms'),
            'active' => CHtml::value($this, 'action.id') === 'sms' && in_array($this->id, array(
                'configuration',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.configuration'),
        ), array(
            'label' => $this->module->getMenuIcon('icon/master') . '10. ตั้งค่าการแจ้งข้อความผ่าน email',
            'url' => array('configuration/mail'),
            'active' => CHtml::value($this, 'action.id') === 'mail' && in_array($this->id, array(
                'configuration',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.configuration'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '11. ระบบสำรองข้อมูล',
            'url' => array('backup/index'),
            'active' => in_array($this->id, array(
                'backup',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.backup'),
        ),
        array(
            'label' => 'ข้อมูลหลัก (Master Data)',
            'visible' => Yii::app()->user->checkPermission(array(
                'admin.codeDepartment',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '12. ข้อมูลหน่วยงาน/กระทรวง',
            'url' => array('codeDepartment/index'),
            'active' => in_array($this->id, array(
                'codeDepartment',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.codeDepartment'),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/master') . '13. ข้อมูลประเทศ/สัญชาติ',
            'url' => array('codeCountry/index'),
            'active' => in_array($this->id, array(
                'codeCountry',
            )),
            'visible' => Yii::app()->user->checkPermission('admin.codeCountry'),
        ),
        array(
            'label' => 'ตรวจสอบข้อมูล (Logger)',
            'visible' => Yii::app()->user->checkPermission(array(
                'log.logSms',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/log') . '14. ข้อมูลการส่ง SMS',
            'url' => array('logSms/index'),
            'active' => in_array($this->id, array(
                'logSms',
            )),
            'visible' => Yii::app()->user->checkPermission('log.logSms'),
        ),
    ),
    'active' => in_array($this->id, array(
        'manageUser',
        'manageUserGroup',
        'manageMember',
        'manageMemberGeneralThai',
        'manageMemberGeneralForeigner',
        'manageMemberDiplomatThai',
        'manageMemberDiplomatForeigner',
        'manageOfficeUser',
        'configuration',
        'backup',
        'codeDepartment',
        'codeCountry',
    )),
    'visible' => Yii::app()->user->checkPermission(array(
        'admin.manageUser',
        'admin.manageUserGroup',
        'admin.manageMember',
        'admin.manageMemberGeneralThai',
        'admin.manageMemberGeneralForeigner',
        'admin.manageMemberDiplomatThai',
        'admin.manageMemberDiplomatForeigner',
        'admin.manageOfficeUser',
        'admin.configuration',
        'admin.configuration.sms',
        'admin.configuration.mail',
        'admin.backup',
        'admin.codeDepartment',
        'admin.codeCountry',
    )),
);
