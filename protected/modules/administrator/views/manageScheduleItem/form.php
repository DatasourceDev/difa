<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลชุดข้อสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_subject_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->findAllByAttributes(array('exam_type_id' => $examSchedule->exam_type_id)), 'id', 'textName'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'class' => 'input-update',
            'data-target' => '#ExamScheduleItem_exam_set_id',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_set_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSet::model()->findAllByAttributes(array(
                    'exam_type_id' => $examSchedule->exam_type_id,
                    'exam_subject_id' => $model->exam_subject_id,
                )), 'id', 'id'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
        ),
    ),
));
?>
<?php echo $form->datePickerGroup($model, 'db_date'); ?>
<?php echo $form->timePickerGroup($model, 'time_start'); ?>
<?php echo $form->timePickerGroup($model, 'time_end'); ?>
<?php
echo $form->dropDownListGroup($model, 'code_place_id', array(
    'widgetOptions' => array(
        'prompt' => '(กรุณาเลือก)',
        'data' => CHtml::listData(CodePlace::model()->findAll(), 'id', 'name'),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'place_remark'); ?>
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