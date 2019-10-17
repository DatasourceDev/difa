<div class="topic">บันทึกข้อมูลหน่วยงาน ก่อนเริ่มใช้งานระบบ</div>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->dropDownListGroup($model, 'office_department_type_id', array(
    'widgetOptions' => array(
        'data' => CodeDepartment::getDepartmentTypeOptions(),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'class' => 'input-update',
            'data-target' => '#ExamScheduleAccount_office_department_id',
            'disabled' => true,
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'office_department_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(CodeDepartment::model()->withIn($model->office_department_type_id)->sortBy('name_en')->findAll(), 'id', 'name_en'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'disabled' => true,
        ),
    ),
));
?>
<div id="dep_pane" style="display:<?php echo $model->office_department_id === '9999' ? 'block' : 'none' ?>;">
    <?php
    echo $form->textFieldGroup($model, 'office_department_name', array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'disabled' => true,
            ),
        ),
        'labelOptions' => array(
            'required' => true,
            'label' => 'โปรดระบุ',
        ),
    ));
    ?>
</div>
<?php
echo $form->textFieldGroup($model, 'office_office', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
        ),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'office_tax'); ?>
<?php echo $form->textAreaGroup($model, 'office_address'); ?>
<?php echo $form->textFieldGroup($model, 'office_co_user'); ?>
<?php echo $form->textFieldGroup($model, 'office_phone'); ?>
<?php echo $form->textFieldGroup($model, 'office_doc_no'); ?>
<?php echo $form->datePickerGroup($model, 'office_doc_date'); ?>
<?php
echo $form->dropDownListGroup($model, 'office_objective_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamScheduleObjective::model()->findAllByAttributes(array(
                    'exam_schedule_id' => $this->schedule->id,
                )), 'id', 'name_th') + array('0' => Helper::t('Other', 'อื่นๆ')),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
        ),
    ),
));
?>
<div id="objective-pane" style="display:<?php echo $model->office_objective_id === '0' ? 'block' : 'none'; ?>;">
    <?php
    echo $form->textFieldGroup($model, 'office_objective', array(
        'labelOptions' => array(
            'label' => Helper::t('Objective', 'ระบุวัตถุประสงค์'),
            'required' => true,
        ),
    ));
    ?>
</div>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ExamScheduleAccount_office_department_id').change(function () {
            if ($(this).val() === '9999') {
                $('#dep_pane').show();
            } else {
                $('#dep_pane').hide();
            }
        });
        $('#ExamScheduleAccount_office_objective_id').change(function () {
            if ($(this).val() === '0') {
                $('#objective-pane').show();
            } else {
                $('#objective-pane').hide();
            }
        });
        $('#ExamScheduleAccount_office_department_id').trigger('change');
    });
</script>