<div class="topic"><?php echo Helper::t('Forgot Password?', 'ลืมรหัสผ่าน?'); ?></div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'username', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
    'labelOptions' => array(
        'label' => Helper::t('Username', 'รหัสประจำตัว'),
    ),
));
?>
<?php
$data = $model->getSecureQuestionOptions();
echo $form->textFieldGroup($model, 'verifyCode', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
            'value' => CHtml::value($data, CHtml::value($model, 'secure_question_' . $quiz)),
        ),
    ),
    'labelOptions' => array(
        'label' => Helper::t('Question', 'คำถาม'),
    ),
));
?>
<?php echo $form->hiddenField($model, 'secure_question_' . $quiz); ?>
<?php
echo $form->textFieldGroup($model, 'secure_answer_input', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => Helper::t('Answer', 'คำตอบ'),
    ),
));
?>
<?php echo $form->hiddenField($model, 'secure_answer_num'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => Helper::t('Submit', 'ตรวจสอบ'),
            'icon' => 'search',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>