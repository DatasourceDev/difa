<?php $this->beginContent($this->module->layout); ?>
<div class="topic">
    ระบบการสมัครสอบ
    <?php if (isset($this->title)): ?>
        <small>:: <?php echo CHtml::value($this, 'title'); ?></small>
    <?php endif; ?>
</div>
<?php echo $content; ?>
<?php $this->endContent(); ?>