<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลชนิดของข้อสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<?php
echo $form->radioButtonListGroup($model, 'is_auto_check', array(
    'widgetOptions' => array(
        'data' => ExamQuestionMethod::getIsAutoCheckOptions(),
    ),
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