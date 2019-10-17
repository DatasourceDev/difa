<?php

class ReportTestResultReplyController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->scopeValid()->with(array('examSchedule' => array('together' => true)))->sortBy('examSchedule.exam_code DESC, t.desk_no')->scopeSelfRegister()->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row', 20);
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPrint() {
        $items = Yii::app()->request->getQuery('items', array());
        if (!is_array($items)) {
            $items = explode(',', $items);
        }
        Yii::import('ext.php-word.vendor.PhpWord.PhpWord', true);
        Yii::setPathOfAlias('PhpOffice', Yii::getPathOfAlias('ext.php-word.vendor'));

        $file = tempnam(Yii::getPathOfAlias('webroot.assets.tmpzip'), "zip");
        $zip = new ZipArchive;
        $zip->open($file, ZipArchive::CREATE);

        foreach ($items as $item) {
            $model = ExamApplication::model()->findByPk($item);
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getPathOfAlias('application.data.template.docx') . '/predoc.docx');
            $templateProcessor->setValue('doc_no', htmlspecialchars('กต 0204/', ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('doc_date', htmlspecialchars(Yii::app()->format->formatDateThai(CHtml::value($model, 'db_date')), ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('exam_skills', htmlspecialchars(CHtml::value($model, 'examSchedule.textSkillWithPrefix'), ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('exam_date', htmlspecialchars(Yii::app()->format->formatDate(CHtml::value($model, 'examSchedule.db_date')), ENT_COMPAT, 'UTF-8'));
            $templateProcessor->setValue('account_profile_name', htmlspecialchars(CHtml::value($model, 'account.profile.fullname'), ENT_COMPAT, 'UTF-8'));
            $zip->addFromString(str_replace(' ', '', CHtml::value($model, 'desk_code')) . '.docx', file_get_contents($templateProcessor->save()));
        }
        $zip->close();
        Yii::app()->request->sendFile(time() . '.zip', file_get_contents($file));
    }

}
