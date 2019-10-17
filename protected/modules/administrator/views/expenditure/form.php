<?php echo Helper::htmlTopic('บันทึกรายจ่าย'); ?>
<?php $form = $this->beginWidget('CodeskActiveForm'); ?>
<?php echo $form->datePickerGroup($model, 'expenditure_date'); ?>
<?php

echo $form->dropDownListGroup($model, 'expenditure_type_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExpenditureType::model()->findAll(), 'id', 'name'),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'amount'); ?>
<?php echo $form->textAreaGroup($model, 'description'); ?>
<?php echo $form->textAreaGroup($model, 'comment'); ?>
<div class="btn-toolbar well well-sm">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ย้อนกลับ',
        'icon' => 'arrow-left',
        'buttonType' => 'link',
        'url' => array('index'),
        'htmlOptions' => array(
            'class' => 'pull-left',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'บันทึกข้อมูล',
        'context' => 'primary',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'class' => 'pull-right',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>