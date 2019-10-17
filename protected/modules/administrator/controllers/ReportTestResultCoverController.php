<?php

class ReportTestResultCoverController extends AdministratorController {

    public function actionIndex() {
        $model = new Account('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('Account');
        $dataProvider = $model->scopeOfficeUser()->search();

        $cover = new TestCoverForm();

        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examScheduleAccount' => array(
                'together' => true,
            ),
        );
        $criteria->addCondition('examScheduleAccount.exam_schedule_id IS NOT NULL');
        $dataProvider->criteria->mergeWith($criteria);

        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'cover' => $cover,
        ));
    }

    public function actionPrint() {
        $cover = new TestCoverForm();
        $data = Yii::app()->request->getPost('TestCoverForm');
        if (isset($data)) {
            $cover->attributes = $data;
        }

        Yii::import('ext.php-word.vendor.PhpWord.PhpWord', true);
        Yii::setPathOfAlias('PhpOffice', Yii::getPathOfAlias('ext.php-word.vendor'));
        $items = CHtml::value($cover, 'items', array());
        if (!is_array($cover->items)) {
            $items = explode(',', $cover->items);
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $accounts = Account::model()->findAll($criteria);

        //$file = tempnam(Yii::getPathOfAlias('webroot.assets.tmpzip'), "zip");
        //$zip = new ZipArchive;
        //$zip->open($file, ZipArchive::CREATE);

        foreach ($accounts as $count => $model) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getPathOfAlias('application.data.template.docx') . '/cover_final.docx');
            $templateProcessor->setValue('doc_no', htmlspecialchars('.................', ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('ref_no', htmlspecialchars('...............................', ENT_COMPAT, 'UTF-8'));

            $templateProcessor->setValue('ref_text', htmlspecialchars('', ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('to', htmlspecialchars(CHtml::value($model, 'profile.fullname'), ENT_COMPAT, 'UTF-8'));

            $templateProcessor->setValue('doc_date', htmlspecialchars($cover->approve_date, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('skill', htmlspecialchars(CHtml::value($model, 'examScheduleAccount.examSchedule.textSkillWithPrefix'), ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('date', htmlspecialchars(Yii::app()->format->formatDate(CHtml::value($model, 'examSchedule.db_date')), ENT_COMPAT, 'UTF-8'));
            //$templateProcessor->setValue('account_profile_name', htmlspecialchars(CHtml::value($model, 'profile.fullname'), ENT_COMPAT, 'UTF-8'));
            //$templateProcessor->setValue('department', htmlspecialchars(CHtml::value($model, 'profile.textDepartment'), ENT_COMPAT, 'UTF-8'));
            //$templateProcessor->setValue('address', htmlspecialchars(CHtml::value($model, 'examScheduleAccount.officeAddress'), ENT_COMPAT, 'UTF-8'));

            $templateProcessor->setValue('name', htmlspecialchars($cover->approve_name, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('position', htmlspecialchars($cover->approve_position, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('footer1', htmlspecialchars($cover->approve_footer1, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('footer2', htmlspecialchars($cover->approve_footer2, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('footer3', htmlspecialchars($cover->approve_footer3, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('footer4', htmlspecialchars($cover->approve_footer4, ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('footer5', htmlspecialchars($cover->approve_footer5, ENT_COMPAT, 'UTF-8'));
            //$zip->addFromString('cover_' . CHtml::value($model, 'examScheduleAccount.office_tax') . '_' . ($count + 1) . '.docx', file_get_contents($templateProcessor->save()));
            Yii::app()->request->sendFile(time() . '.docx', file_get_contents($templateProcessor->save()));
        }

        //$zip->close();
        //Yii::app()->request->sendFile(time() . '.zip', file_get_contents($file));
    }

}
