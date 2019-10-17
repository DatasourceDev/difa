<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class='form-group'>
    <label class="control-label col-sm-3">ผู้สมัคร</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($application, 'account.profile.fullname'); ?>
        </div>
    </div>
</div>
<div class='form-group'>
    <label class="control-label col-sm-3">รอบสอบ</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($application, 'examSchedule.exam_code'); ?>
        </div>
    </div>
</div>
<div class='form-group'>
    <label class="control-label col-sm-3">ทักษะ</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($application, 'examSchedule.textSkill'); ?>
        </div>
    </div>
</div>
<div class='form-group'>
    <label class="control-label col-sm-3">วันที่</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo Yii::app()->format->formatDateText(CHtml::value($application, 'examSchedule.db_date')); ?>
        </div>
    </div>
</div>
<?php
echo $form->radioButtonListGroup($application, 'exam_schedule_objective_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamScheduleObjective::model()->findAllByAttributes(array(
                    'exam_schedule_id' => $examSchedule->id,
                )), 'id', 'name_th'),
    ),
));
?>
<div class='form-group well well-sm'>
    <div class='col-sm-9 col-sm-offset-3'>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ย้อนกลับ',
            'icon' => 'arrow-left',
            'buttonType' => 'link',
            'url' => array('view', 'id' => $examSchedule->id),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'สมัครสอบ',
            'icon' => 'pencil',
            'context' => 'success',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>