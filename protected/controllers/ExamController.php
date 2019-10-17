<?php

class ExamController extends Controller {

    public function actionApply($id) {
        $exam = ExamSchedule::model()->findByPk($id);

        $model = new ExamApplication('apply');
        $model->apply_type = ExamApplication::APPLY_SELF;
        $model->exam_schedule_id = $exam->id;
        $model->account_id = Yii::app()->user->id;
        $data = Yii::app()->request->getPost('ExamApplication');
        if (isset($data)) {
            $model->attributes = $data;
            if ($model->apply(true)) {
                if ($model->is_sms === ExamApplication::YES) {
                    Sms::send(CHtml::value($model, 'account.msisdn'), Helper::t(Configuration::getKey('sms_template_confirmation_en'), Configuration::getKey('sms_template_confirmation_th')), array(
                        '{{exam_code}}' => CHtml::value($model, 'examSchedule.exam_code'),
                    ));
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
           
        }
        $this->render('apply', array(
            'exam' => $exam,
            'model' => $model,
        ));
    }

    public function actionComplete($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $model->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        $this->render('complete', array(
            'model' => $model,
        ));
    }

    public function actionPrintCard($id) {
        $application = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $application->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        $pdf = new PDFMaker;
        $pdf->addPageExamCard($application);
        $pdf->output();
    }

    public function actionPrintPaymentSlip($id) {
        $application = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $application->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        $pdf = new PDFMaker;
        $pdf->addPagePaymentSlip($application);
        $pdf->output();
    }

    public function actionPrintTest($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $model->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        $this->render('printTest', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $model->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        if (!$model->examSchedule->getIsAccountJoined(Yii::app()->user->id)) {
            Yii::app()->user->setFlash('success', 'You need to apply this examination first.');
            $this->redirect(array('/site/index'));
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionCancel($id) {
        $model = ExamApplication::model()->findByPk($id);
        if (Yii::app()->user->id !== $model->account_id) {
            throw new CHttpException(403, 'access denied.');
        }
        if (!$model->examSchedule->getIsAccountJoined(Yii::app()->user->id)) {
            Yii::app()->user->setFlash('success', 'You need to apply this examination first.');
            $this->redirect(array('/site/calendar'));
        }
        if ($model->is_paid === ActiveRecord::YES) {
            Yii::app()->user->setFlash('success', 'You can not cancel paid examination.');
            $this->redirect(array('view', 'id' => $model->id));
        }
        if ($model->cancel()) {
            Yii::app()->user->setFlash('success', 'You have cancelled your application.');
            $this->redirect(array('/site/calendar'));
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('/site/calendar'));
        }
    }

}
