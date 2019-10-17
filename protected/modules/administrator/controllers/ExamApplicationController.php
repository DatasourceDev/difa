<?php

class ExamApplicationController extends AdministratorController {

    public function actionConfirm($code) {
        $data = CJSON::decode(base64_decode($code));
        $model = ExamApplication::model()->findByAttributes(array(
            'id' => CHtml::value($data, 'id'),
        ));
        if (isset($model)) {
            if ($model->doConfirm()) {
                Yii::app()->user->setFlash('success', 'ลงทะเบียนเข้าสอบสำหรับ คุณ <span="text-success">' . CHtml::value($model, 'account.profile.fullname') . '</span> (' . CHtml::value($model, 'account.entry_code') . ')  เรียบร้อย');
            } else {
                Yii::app()->user->setFlash('success', 'ไม่สามารถดำเนินการได้');
            }
        } else {
            Yii::app()->user->setFlash('success', 'ไม่พบข้อมูล');
        }
        $this->redirect(array('manageSchedule/viewAttendee', 'id' => $model->exam_schedule_id));
    }

    public function actionPrintCard($id) {
       require Yii::getPathOfAlias('application.vendors.mpdf60') . '/mpdf.php';
        $model = ExamApplication::model()->findByPk($id);
        $pdf = new mPDF;
        $pdf->WriteHTML($this->renderPartial('//pdf/printCard', array(
                    'model' => $model,
                        ), true));
        $pdf->Output();
    }

}
