<?php echo Helper::htmlTopic('ตั้งค่าระบบ'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ตั้งค่า email',
));
?>
<?php
echo $form->textFieldGroup($model, 'sys_admin_email', array(
    'prepend' => Helper::glyphicon('envelope'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sys_noreply_email', array(
    'prepend' => Helper::glyphicon('envelope'),
));
?>
<?php
echo $form->textAreaGroup($model, 'email_signature', array(
));
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'รูปแบบการแจ้งเตือนโดย email',
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_confirmation_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_confirmation_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_account_info_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_account_info_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_payment_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_payment_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_alert_schedule_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_alert_schedule_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_alert_result_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->redactorGroup($model, 'email_template_alert_result_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php $this->endWidget(); ?>
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