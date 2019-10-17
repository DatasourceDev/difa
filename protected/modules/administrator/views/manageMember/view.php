<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="topic"><?php echo Yii::t('profile', 'Account Information'); ?></div>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->textFieldGroup($model, 'username', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'disabled' => true,
                ),
            ),
            'labelOptions' => array(
                'label' => 'บัญชีผู้ใช้งาน',
            ),
        ));
        ?>
        <?php echo $form->passwordFieldGroup($model, 'password_input'); ?>
        <?php echo $form->passwordFieldGroup($model, 'password_confirm'); ?>
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
<?php $this->endContent(); ?>