<div class="topic">ทดสอบการส่งอีเมล์</div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->textFieldGroup($model, 'subject'); ?>
<?php echo $form->textFieldGroup($model, 'to'); ?>
<?php echo $form->redactorGroup($model, 'message'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ทดสอบส่งจดหมาย',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
