<?php echo Helper::htmlTopic('ตั้งค่าระบบ'); ?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'รูปแบบการแจ้งเตือนโดย SMS',
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_api_url', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_ivr', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_ivr_username', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_ivr_password', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_response_username', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_response_password', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_confirmation_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_confirmation_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_payment_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_payment_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_alert_schedule_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_alert_schedule_en', array(
    'labelOptions' => array(
        'label' => '',
    ),
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_en.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_alert_result_th', array(
    'prepend' => CHtml::image($this->module->assetUrl . '/images/lang_th.png'),
));
?>
<?php
echo $form->textFieldGroup($model, 'sms_template_alert_result_en', array(
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