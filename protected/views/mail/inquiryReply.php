<?php $this->beginContent('application.views.mail._layout'); ?>
<h1>Hello, 
    <span style="color:#279dff;">
        <?php echo CHtml::value($model, 'title'); ?>
        <?php echo CHtml::value($model, 'firstname'); ?> 
        <?php echo CHtml::value($model, 'midname'); ?>
        <?php echo CHtml::value($model, 'lastname'); ?>
    </span>
</h1>
<?php echo $model->reply_message; ?>
<hr/>
<h4>Original Message:</h4>
<div><?php echo $model->topic; ?></div>
<?php echo $model->message; ?>
<?php $this->endContent(); ?>