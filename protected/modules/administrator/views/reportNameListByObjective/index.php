<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายชื่อผู้เข้าสอบแยกตามวัตถุประสงค์ในการสอบ'); ?>
<?php

$this->renderPartial('/report/search/examScheduleByRange', array(
    'model' => $model,
    'exportDoc' => true,
));
?>