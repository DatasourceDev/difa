<div class="topic"><?php echo Yii::t('app', 'Take control your account'); ?></div>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->textFieldGroup($model, 'entry_code', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
    'labelOptions' => array(
        'label' => 'Account ID',
    ),
));
?>
<?php
echo $form->textFieldGroup($model->accountType, 'name_th', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
    'labelOptions' => array(
        'label' => 'Account Type',
    ),
));
?>
<?php
echo $form->textFieldGroup($profile, 'fullnameEn', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
    'labelOptions' => array(
        'label' => 'Name',
    ),
));
?>
<?php
echo $form->textFieldGroup($profile, 'textDepartment', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
    'labelOptions' => array(
        'label' => 'Department',
    ),
));
?>
<?php
echo $form->emailFieldGroup($model, 'email', array(
    'prepend' => Helper::glyphicon('envelope'),
    'labelOptions' => array(
        'label' => 'Your email',
    ),
    'hint' => 'We will send confirmation mail to resetting account to this email address.',
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'Reset Password',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'Back',
            'buttonType' => 'link',
            'url' => Yii::app()->homeUrl,
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
