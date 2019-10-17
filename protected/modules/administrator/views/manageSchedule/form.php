<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => $model->isNewRecord ? array('create', 'd' => $model->db_date) : array('update', 'id' => $model->id),
    'type' => 'horizontal',
    'htmlOptions' => array(
        'id' => 'exam-form',
    ),
        ));
?>
<h4 class="fancy">จัดรอบสอบใหม่ ในวันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')) ?></span></h4>
<div class="well well-sm">
    <h4>ข้อมูลรอบสอบ</h4>
    <?php
    echo $form->dropDownListGroup($model, 'exam_type_id', array(
        'widgetOptions' => array(
            'data' => CHtml::listData(ExamType::model()->scopeActive()->findAll(), 'id', 'name'),
            'htmlOptions' => array(
                'prompt' => '(กรุณาเลือก)',
                'disabled' => !$model->isNewRecord,
                'class' => 'input-update',
                'data-target' => '#ExamSchedule_register_fee, #color-picker-pane',
            ),
        ),
    ));
    ?>
    <div id="color-picker-pane">
        <?php
        echo $form->colorPickerGroup($model, 'calendar_color', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'color-picker',
                    'style' => 'background-color:' . CHtml::value($model, 'calendar_color') . ';',
                ),
            ),
        ));
        ?>
    </div>
    <?php
    echo $form->dropDownListGroup($model, 'code_place_id', array(
        'widgetOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'data' => CHtml::listData(CodePlace::model()->findAll(), 'id', 'name'),
        ),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'place_remark', array(
        'widgetOptions' => array(
        ),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'max_quota', array(
        'widgetOptions' => array(
        ),
    ));
    ?>
    <?php
    echo $form->textAreaGroup($model, 'remark', array(
        'widgetOptions' => array(
        ),
    ));
    ?>
    <?php
    echo $form->dropDownListGroup($model, 'is_private', array(
        'widgetOptions' => array(
            'data' => ExamSchedule::getIsPrivateOptions(),
        ),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'register_fee', array(
    ));
    ?>
    <?php
    echo $form->dropDownListGroup($model, 'is_close', array(
        'widgetOptions' => array(
            'data' => ExamSchedule::getIsCloseOptions(),
        ),
    ));
    ?>
    <div class="form-pane" style="display:<?php echo $model->is_close === ActiveRecord::YES ? 'block' : 'none'; ?>;">
        <?php
        echo $form->textAreaGroup($model, 'close_description', array(
        ));
        ?>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <hr/>
        <h4>กำหนดวันเปิด-ปิดรับสมัคร</h4>
        <?php if ($model->db_date <= date('Y-m-d')): ?>
            <div class="alert alert-danger">ไม่สามารถแก้ไขได้ เนื่องจากเลยกำหนดการสอบแล้ว</div>
        <?php endif; ?>
        <?php
        echo $form->datePickerGroup($model, 'exception_register_start_date', array(
            'prepend' => Helper::glyphicon('calendar'),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => $model->getRegisterDateStartOriginal(),
                    'disabled' => $model->db_date <= date('Y-m-d'),
                ),
            ),
        ));
        ?>
        <?php
        echo $form->datePickerGroup($model, 'exception_register_end_date', array(
            'prepend' => Helper::glyphicon('calendar'),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => $model->getRegisterDateEndOriginal(),
                    'disabled' => $model->db_date <= date('Y-m-d'),
                ),
            ),
        ));
        ?>
    <?php endif; ?>
    <div class="btn-toolbar text-right">
        <?php echo Helper::buttonBack($model->isNewRecord ? array('calendar') : array('view', 'id' => $model->id)); ?>
        <?php echo Helper::buttonSubmit(); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#color-picker').colorpicker().on('changeColor', function (event) {
            $(this).css("backgroundColor", event.color.toHex());
        });

        $('#ExamSchedule_is_close').change(function () {
            if ($(this).val() === '0') {
                $('#ExamSchedule_close_description').closest('.form-pane').hide();
            } else {
                $('#ExamSchedule_close_description').closest('.form-pane').show();
            }
        });

        $('#ExamSchedule_exam_type_id').on('afterInputUpdate', function () {
            $('#color-picker').colorpicker().on('changeColor', function (event) {
                $(this).css("backgroundColor", event.color.toHex());
            });
        });
    });
</script>