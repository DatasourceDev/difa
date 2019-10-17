<?php $this->beginContent($this->module->layout); ?>
<div class="topic">
    รายงานแจ้งข้อมูลการทำรายการเปลี่ยน Password ของผู้ใช้งาน
    <?php if (isset($this->title)): ?>
        <small>:: <?php echo CHtml::value($this, 'title'); ?></small>
    <?php endif; ?>
</div>
<?php echo $content; ?>
<?php $this->endContent(); ?>