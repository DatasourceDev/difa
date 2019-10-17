<?php

class AdministratorController extends CController {

    public $title;
    public $description;

    public function accessRules() {
        return array(
            array(
                'allow',
                'users' => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function init() {
        parent::init();
        $this->widget('zii.widgets.jui.CJuiDatePicker', array('name' => 'fake', 'language' => ''), true);
    }

    public function xlsOutput($excel, $filename = null) {
        // Redirect output to a client’s web browser (Excel2007)
        Helper::sendFile(($filename ? $filename : time()) . '.xlsx');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
    }

}
