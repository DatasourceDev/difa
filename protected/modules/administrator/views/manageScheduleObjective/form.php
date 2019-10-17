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
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('manageSchedule/viewObjective', 'id' => $model->exam_schedule_id)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>