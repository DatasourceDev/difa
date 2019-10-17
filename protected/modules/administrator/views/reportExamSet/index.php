<?php echo Helper::htmlTopic('ระบบรายงาน', 'ประวัติการจัดชุดข้อสอบ'); ?>
<?php

$this->renderPartial('/report/search/examScheduleExamSetByRange', array(
    'model' => $model,
));
?>