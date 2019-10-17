<div class="topic">Forgot Password?</div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'username', array(
    'prepend' => Helper::glyphicon('user'),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => Yii::t('app', 'Check Account Name'),
            'icon' => 'search',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>