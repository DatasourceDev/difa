<?php

class MemberAccountDuplicateController extends AdministratorController {

    public $layout = '/memberAccountDuplicate/_layout';
    public $title = 'รายการผู้สมัครชาวต่างชาติที่มีแนวโน้มที่จะมีบัญชีซ้ำซ้อน';

    public function actionIndex() {
        $dataProvider = Helper::query('member/list_foreigner_duplicate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($src_id, $des_id, $solve = false) {
        $src = Account::model()->findByPk($src_id);
        $des = Account::model()->findByPk($des_id);

        $this->render('view', array(
            'src' => $src,
            'des' => $des,
            'solve' => $solve,
        ));
    }

    /**
     * ยกเลิก บัญชีที่สมัครใหม่ และ แจ้งผู้สมัครให้ใช้บัญชีเดิม โดยใช้รหัสผ่านที่สมัครใหม่
     * @param type $id
     */
    public function actionSolution1($src_id, $des_id) {
        $src = Account::model()->findByPk($src_id);
        $des = Account::model()->findByPk($des_id);
        if ($src->disable()) {
            $des->secret = $src->secret;
            $des->save();
            Mailer::send('accountDuplicateSolution1', array(
                'subject' => 'Your DVIFA account has been confirmed',
                'to' => CHtml::value($src, 'profile.contact_email'),
                'data' => array(
                    'src' => $src,
                    'des' => $des,
                ),
            ));
            Yii::app()->user->setFlash('success', 'ทำการยกเลิกบัญชี <span class="text-primary">' . ($src->username) . '</span> เรียบร้อย');
            $this->redirect(array('manageMember/goto', 'id' => $des->id));
        }
    }

    /**
     * กรณีที่ข้อมูลเดิมไม่มี ชื่อบัญชี 13 หลัก ให้ใช้บัญชีที่สมัครเข้ามาใหม่
     * @param type $id
     */
    public function actionSolution2($src_id, $des_id) {
        $src = Account::model()->findByPk($src_id);
        $des = Account::model()->findByPk($des_id);
        if ($src->confirm()) {
            Yii::app()->user->setFlash('success', 'ยืนยันการสมัครของบัญชี <span class="text-primary">' . ($src->username) . '</span> เรียบร้อย');
            Mailer::sendConfirmation(CHtml::value($src, 'profile.contact_email'));
            $this->redirect(array('manageMember/goto', 'id' => $src->id));
        } else {
            $this->redirect(array('view', 'src_id' => $src->id, 'des_id' => $des->id));
        }
    }

    /**
     * ไม่ใช่ข้อมูลที่ตรงกัน อนุญาติให้ใช้ข้อมูลที่สมัครมาใหม่
     * @param type $id
     */
    public function actionSolution3($src_id, $des_id) {
        $src = Account::model()->findByPk($src_id);
        $des = Account::model()->findByPk($des_id);
        if ($src->confirm()) {
            Yii::app()->user->setFlash('success', 'ยืนยันการสมัครของบัญชี <span class="text-primary">' . ($src->username) . '</span> เรียบร้อย');
            Mailer::sendConfirmation(CHtml::value($src, 'profile.contact_email'), array(
                'data' => array(
                    'model' => $src,
                ),
            ));
            $this->redirect(array('manageMember/goto', 'id' => $src->id));
        } else {
            $this->redirect(array('view', 'src_id' => $src->id, 'des_id' => $des->id));
        }
    }

}
