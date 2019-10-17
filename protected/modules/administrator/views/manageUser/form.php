<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'username',array(
    'hint' => 'กรุณากรอกข้อความขนาดไม่เกิน 60 ตัวอักษร',
)); ?>
<?php echo $form->passwordFieldGroup($model, 'password_input'); ?>
<?php echo $form->passwordFieldGroup($model, 'password_confirm'); ?>
<?php echo $form->emailFieldGroup($model, 'email'); ?>
<?php if (!$model->isSuperUser): ?>
    <?php
    echo $form->dropDownListGroup($model, 'role_id', array(
        'widgetOptions' => array(
            'data' => CHtml::listData(Role::model()->sortBy('name')->findAll(), 'id', 'name'),
            'htmlOptions' => array(
                'prompt' => '(กรุณาเลือก)',
            ),
        ),
    ));
    ?>
<?php endif; ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(Yii::app()->request->getQuery('returnUrl', array('index'))); ?>
    </div>
</div>
<?php $this->endWidget(); ?>