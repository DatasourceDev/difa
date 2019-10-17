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
            'label' => $this->module->getMenuIcon('icon/web_content') . '04. จัดการเนื้อหาข่าวสาร',
            'url' => array('webContent/index'),
            'active' => in_array($this->id, array(
                'webContent',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webContent',
            )),
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/web_content') . '05. ส่งข่าวสารทางอีเมล์',
            'url' => array('webContentMail/index'),
            'active' => in_array($this->id, array(
                'webContentMail',
            )),
            'visible' => Yii::app()->user->checkPermission(array(
                'web.webContentMail',
            )),
        ),
    ),
    'active' => in_array($this->id, array(
        'webConfiguration',
        'webMenu',
        'webTemplate',
    )),
    'visible' => Yii::app()->user->checkPermission(array(
        'web.webContentMail',
        'web.webContent',
        'web.webTemplate',
        'web.webMenu',
        'web.webConfiguration',
    )),
);
