<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลหัวข้อในการสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'exam_topic_code'),
        ));
?>
<div class="form-group">
    <label class="col-sm-3 control-label">ประเภทการสอบ</label>
    <div class="col-sm-9">
        <?php
        echo CHtml::textField('exam_subject_id', CHtml::value($model, 'examSubject.examType.name'), array(
            'class' => 'form-control',
            'disabled' => true,
        ));
        ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">ทักษะในการสอบ</label>
    <div class="col-sm-9">
        <?php
        echo CHtml::textField('exam_type_id', CHtml::value($model, 'examSubject.code') . ' - ' . CHtml::value($model, 'examSubject.name'), array(
            'class' => 'form-control',
            'disabled' => true,
        ));
        ?>
    </div>
</div>
<?php echo $form->textFieldGroup($model, 'exam_topic_code'); ?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('manageExam/index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>