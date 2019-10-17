<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'เพิ่มผู้แทนหน่วยงาน',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->textFieldGroup($account, 'username'); ?>
<?php echo $form->passwordFieldGroup($account, 'password_input'); ?>
<?php echo $form->passwordFieldGroup($account, 'password_confirm'); ?>
<?php echo $form->textFieldGroup($model, 'max_quota'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('manageSchedule/viewExamSet', 'id' => $model->exam_schedule_id)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>