<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="topic"><?php echo Yii::t('profile', 'Reset Password'); ?></div>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->textFieldGroup($model, 'username', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'disabled' => true,
                ),
            ),
        ));
        ?>
        <?php echo $form->passwordFieldGroup($model, 'password_input'); ?>
        <?php echo $form->passwordFieldGroup($model, 'password_confirm',array(
            'labelOptions' => array(
                'class' => 'nowrap',
            ),
        )); ?>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'Save Change',
                    'context' => 'primary',
                    'buttonType' => 'submit',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>