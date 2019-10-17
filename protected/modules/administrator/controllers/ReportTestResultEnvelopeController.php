<?php

class ReportTestResultEnvelopeController extends AdministratorController {

    public function actionIndex() {
        $model = new ExamApplication('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->request->getQuery('ExamApplication');
        $dataProvider = $model->scopeValid()->with(array('examSchedule' => array('together' => true)))->sortBy('examSchedule.exam_code DESC, t.desk_no')->search();
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
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $items);
        $applications = ExamApplication::model()->scopeValid()->findAll($criteria);
        $mode = Yii::app()->request->getQuery('mode');
        switch ($mode) {
            case 'doc':
            case 'doc-name-only':
                Yii::import('ext.php-word.vendor.PhpWord.PhpWord', true);
                Yii::setPathOfAlias('PhpOffice', Yii::getPathOfAlias('ext.php-word.vendor'));

                $file = tempnam(Yii::getPathOfAlias('webroot.assets.tmpzip'), "zip");
                $zip = new ZipArchive;
                $zip->open($file, ZipArchive::CREATE);

                foreach ($applications as $application) {
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getPathOfAlias('application.data.template.docx') . '/envelope.docx');
                    $templateProcessor->setValue('name', htmlspecialchars($application->fullnameTh, ENT_COMPAT, 'UTF-8'));
                    if ($mode == 'doc-name-only') {
                        $templateProcessor->setValue('address1', '');
                        $templateProcessor->setValue('address2', '');
                        $templateProcessor->setValue('address3', '');
                        $templateProcessor->setValue('address4', '');
                    } else {
                        $templateProcessor->setValue('address1', htmlspecialchars(CHtml::value($application, 'account.profile.replyAddressLine1'), ENT_COMPAT, 'UTF-8'));
                        $templateProcessor->setValue('address2', htmlspecialchars(CHtml::value($application, 'account.profile.replyAddressLine2'), ENT_COMPAT, 'UTF-8'));
                        $templateProcessor->setValue('address3', htmlspecialchars(CHtml::value($application, 'account.profile.replyAddressLine3'), ENT_COMPAT, 'UTF-8'));
                        $templateProcessor->setValue('address4', htmlspecialchars(CHtml::value($application, 'account.profile.replyAddressLine4'), ENT_COMPAT, 'UTF-8'));
                    }
                    if (count($applications) == 1) {
                        Yii::app()->request->sendFile(time() . '.docx', file_get_contents($templateProcessor->save()));
                        Yii::app()->end();
                    } else {
                        $zip->addFromString(str_replace(' ', '-', $application->desk_code) . '.docx', file_get_contents($templateProcessor->save()));
                    }
                }
                $zip->close();
                Yii::app()->request->sendFile(time() . '.zip', file_get_contents($file));
                break;
            case 'pdf':
            case 'pdf-name-only':
                $pdf = new PDFMaker;
                foreach ($applications as $application) {
                    $pdf->pdf->AddPage('L', '', '', '', '', 5, 5, 5, '', 0, '', '', '', '', '', '', '', '', '', '', 'A5-L');
                    $pdf->writeHTML($this->renderPartial('print', array(
                                'application' => $application,
                                'mode' => Yii::app()->request->getQuery('mode'),
                                    ), true));
                }
                $pdf->output();
                break;
        }
    }

}
