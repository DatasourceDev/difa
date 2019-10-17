<div class="topic"><?php echo Yii::t('app', 'Forgot Username'); ?></div>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->textFieldGroup($model, 'title', array(
));
?>
<?php
echo $form->textFieldGroup($model, 'firstname', array(
));
?>
<?php
echo $form->textFieldGroup($model, 'midname', array(
));
?>
<?php
echo $form->textFieldGroup($model, 'lastname', array(
));
?>
<?php
echo $form->textFieldGroup($model, 'topic', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'value' => 'I forgot my username.',
            'readonly' => true,
        ),
    ),
));
?>
<?php
echo $form->emailFieldGroup($model, 'email', array(
    'prepend' => Helper::glyphicon('envelope'),
));
?>
<?php
echo $form->textFieldGroup($model, 'place_of_birth', array(
));
?>
<?php
echo $form->fileFieldGroup($model, 'attachment_file', array(
    'hint' => 'Please attach copy version of your passport book.',
    'labelOptions' => array(
        'required' => true,
    ),
));
?>
<?php if (CCaptcha::checkRequirements()): ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label col-sm-3')); ?>
        <div class="col-sm-9">
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')); ?>
            <div class="hint">Please enter the letters as they are shown in the image above.
                <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
    </div>
<?php endif; ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => Yii::t('app', 'Submit'),
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>