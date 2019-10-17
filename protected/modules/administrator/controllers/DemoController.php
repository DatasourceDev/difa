<?php

class DemoController extends AdministratorController {

    public function actionWebMenu() {
        $this->title = 'จัดการเมนูเว็บไซต์';
        $this->render('webMenu');
    }

    public function actionWebMenuCreate() {
        $this->title = 'จัดการเมนูเว็บไซต์';
        $this->render('webMenuCreate');
    }

    public function actionWebMenuView() {
        $this->title = 'จัดการเมนูเว็บไซต์';
        $this->render('webMenuView');
    }

    public function actionWebContent() {
        $this->title = 'จัดการเนื้อหาเว็บไซต์';
        $this->render('webContent');
    }

    public function actionWebContentCreate() {
        $this->title = 'จัดการเนื้อหาเว็บไซต์';
        $this->render('webContentCreate');
    }

    public function actionWebContentView() {
        $this->title = 'จัดการเนื้อหาเว็บไซต์';
        $this->render('webContentView');
    }

    public function actionWebTemplate() {
        $this->title = 'จัดการรูปแบบเว็บไซต์';
        $this->render('webTemplate');
    }

    public function actionAdminMember() {
        $this->title = 'จัดการสมาชิก';
        $this->render('adminMember');
    }

    public function actionAdminMemberCreate() {
        $this->title = 'จัดการสมาชิก';
        $this->render('adminMemberCreate');
    }

    public function actionAdminUser() {
        $this->title = 'จัดการผู้ใช้งาน';
        $this->render('adminUser');
    }

}
