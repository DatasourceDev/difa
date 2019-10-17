<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบเซ็นต์ชื่อ'); ?>
<?php

$this->renderPartial('/report/search/examScheduleByRange', array(
    'model' => $model,
));
?>