<div align="center"><strong><?php echo $title; ?></strong></div>
<div align="center">
    ประเภทการสอบ : <?php echo CHtml::value($examSchedule, 'examType.name'); ?> , 
    รอบสอบ : <?php echo CHtml::value($examSchedule, 'exam_code'); ?><br/>
    สถานที่สอบ: <?php echo CHtml::value($examSchedule, 'place_name'); ?><br/>
    <?php if (count($examSchedule->examScheduleItems) <= 1): ?>
        ห้อง : <?php echo CHtml::value($examSchedule, 'place_remark'); ?><br/>
    <?php endif; ?>
    <small><?php echo nl2br(CHtml::value($examSchedule, 'textSkillWithDate')); ?></small><br/>
</div>