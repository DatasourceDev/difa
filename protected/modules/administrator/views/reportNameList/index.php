<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายชื่อสำหรับติดหน้าห้องสอบ'); ?>
<?php

$this->renderPartial('/report/search/examScheduleByRange', array(
    'model' => $model,
));
?>