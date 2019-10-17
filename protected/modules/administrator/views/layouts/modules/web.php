<?php

return array(
    'label' => $this->module->getMenuIcon('icon/web') . 'จัดการเว็บไซต์',
    'items' => array(
        array(
            'label' => 'ระบบบริหารเว็บไซต์',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_config') . '01. ตั้งค่าเว็บไซต์',
            'url' => array('webConfiguration/index'),
            'active' => in_array($this->id, array(
                'webConfiguration',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webConfiguration',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_menu') . '02. จัดการเมนูเว็บไซต์',
            'url' => array('webMenu/index'),
            'active' => in_array($this->id, array(
                'webMenu',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webMenu',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/manage') . '03. จัดการรูปแบบเว็บไซต์',
            'url' => array('webTemplate/index'),
            'active' => in_array($this->id, array(
                'webTemplate',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webTemplate',
            )),
        ),
        array(
            'label' => 'ระบบประชาสัมพันธ์เนื้อหาข่าวสาร',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '04. เอกสารดาวน์โหลด',
            'url' => array('webDownload/index'),
            'active' => in_array($this->id, array(
                'webDownload',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webDownload',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '05. จัดการเนื้อหาข่าวสาร',
            'url' => array('webContent/index'),
            'active' => in_array($this->id, array(
                'webContent',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webContent',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '06. ส่งข่าวสารทางอีเมล์',
            'url' => array('webContentMail/index'),
            'active' => in_array($this->id, array(
                'webContentMail',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webContentMail',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '07. ส่งข่าวสารทาง SMS',
            'url' => array('webContentSms/index'),
            'active' => in_array($this->id, array(
                'webContentSms',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webContentSms',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '08. จัดการตัววิ่งประชาสัมพันธ์',
            'url' => array('webNewsTicker/index'),
            'active' => in_array($this->id, array(
                'webNewsTicker',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webNewsTicker',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '09. จัดการรูปภาพหรือวีดีโอ',
            'url' => array('webSlider/index'),
            'active' => in_array($this->id, array(
                'webSlider',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webSlider',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '10. จัดการคำถามที่พบบ่อย',
            'url' => array('webFAQ/index'),
            'active' => in_array($this->id, array(
                'webFAQ',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webFAQ',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '11. จัดการที่อยู่ติดต่อ',
            'url' => array('WebContactUs/index'),
            'active' => in_array($this->id, array(
                'WebContactUs',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.WebContactUs',
            )),
        ),
    ),
    'active' => in_array($this->id, array(
        'webConfiguration',
        'webMenu',
        'webTemplate',
        'webDownload',
        'webContent',
        'webContentMail',
        'webContentSms',
        'webNewsTicker',
        'webSlider',
        'webFAQ',
        'WebContactUs',
    )),
    'visible' => Yii::app()->user->checkPermission(array(
        'web.webContentMail',
        'web.webContent',
        'web.webTemplate',
        'web.webMenu',
        'web.webDownload',
        'web.webContent',
        'web.webConfiguration',
        'web.webContentSms',
        'web.webNewsTicker',
        'web.webSlider',
        'web.webFAQ',
        'web.WebContactUs',
    )),
);
