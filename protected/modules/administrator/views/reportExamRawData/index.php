<?php echo Helper::htmlTopic('ระบบรายงาน', 'ข้อมูลการทำข้อสอบ'); ?>
<?php

$this->renderPartial('/report/search/examScheduleByRange', array(
    'model' => $model,
));
?>