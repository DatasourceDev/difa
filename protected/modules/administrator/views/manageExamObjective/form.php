<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลวัตถุประสงค์การสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name_th'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name_th'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php
echo $form->radioButtonListGroup($model, 'is_private', array(
    'widgetOptions' => array(
        'data' => CodeObjective::getIsPrivateObtions(),
    ),
));
?>
<?php
echo $form->datePickerGroup($model, 'period_start', array(
    'widgetOptions' => array(
    ),
    'prepend' => Helper::glyphicon('calendar'),
));
?>
<?php
echo $form->datePickerGroup($model, 'period_end', array(
    'widgetOptions' => array(
    ),
    'prepend' => Helper::glyphicon('calendar'),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>