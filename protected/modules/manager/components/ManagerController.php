<?php

/**
 * @property ExamSchedule $examSchedule ข้อมูลรอบสอบ
 */
class ManagerController extends CController {

    public $title;
    public $description;
    public $examSchedule;

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
        Yii::app()->qz->deploy();
        $this->widget('zii.widgets.jui.CJuiDatePicker', array('name' => 'fake', 'language' => ''), true);
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $this->examSchedule = ExamSchedule::model()->findByPk(Yii::app()->user->getState('current_exam_schedule_id'));
            if (!Yii::app()->user->isGuest && empty($this->examSchedule) && !in_array($action->id, array('selectExamSchedule', 'joinExamSchedule', 'error', 'login', 'logout'))) {
                $this->redirect(array('home/selectExamSchedule'));
            }
            return true;
        }
    }

    public function xlsOutput($excel, $filename = null) {
        // Redirect output to a client’s web browser (Excel2007)
        Helper::sendFile(($filename ? $filename : time()) . '.xlsx');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');
    }

}
