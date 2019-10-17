<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลเว็บไซต์',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php echo $form->textFieldGroup($model, 'title'); ?>
<?php echo $form->textFieldGroup($model, 'title_en'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php echo CHtml::image(WebConfigurationForm::getLogoUrl() . '?_=' . time()); ?>
    </div>
</div>
<?php
echo $form->fileFieldGroup($model, 'logo_file', array(
    'hint' => 'ขนาดความสูง 88px',
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>