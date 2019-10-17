<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลกระทรวง/หน่วยงาน',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'id'); ?>
<?php echo $form->textFieldGroup($model, 'name_th'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php if (CHtml::value($model, 'id') !== '9999'): ?>
    <?php
    echo $form->dropDownListGroup($model, 'department_type_id', array(
        'widgetOptions' => array(
            'data' => CodeDepartment::getDepartmentTypeOptions(),
        ),
    ));
    ?>
<?php endif; ?>
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