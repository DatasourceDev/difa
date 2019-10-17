<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลประเภทการสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->textFieldGroup($model, 'id', array());
?>
<?php
echo $form->textFieldGroup($model, 'code', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => 'รหัส 2 หลัก เช่น ET , IH',
        ),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<?php echo $form->textAreaGroup($model, 'description'); ?>
<?php
echo $form->textFieldGroup($model, 'default_register_fee', array(
    'append' => 'บาท',
));
?>
<?php
echo $form->dropDownListGroup($model, 'income_type_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(IncomeType::model()->findAll(), 'id', 'textName'),
        'htmlOptions' => array(
            'prompt' => '(ไม่ต้องบันทึกเป็นรายรับ)',
        ),
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php echo CHtml::image($model->coverFile->getFileUrl('thumbnail') . '?t=' . time()); ?>
    </div>
</div>
<?php echo $form->fileFieldGroup($model, 'cover_file'); ?>
<?php
echo $form->colorPickerGroup($model, 'badge_color', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'color-picker',
            'style' => 'background-color:' . CHtml::value($model, 'badge_color', '#ffffff') . ';',
        ),
    ),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'is_active', array(
    'widgetOptions' => array(
        'data' => array(
            ActiveRecord::YES => 'เปิดใช้งาน',
            ActiveRecord::NO => 'ปิด',
        ),
    ),
));
?>
<?php
echo $form->checkBoxListGroup($model, 'account_types', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(AccountType::model()->onlyUser()->findAll(), 'id', 'name_th'),
    ),
))
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php echo CHtml::image($model->infoFile->getFileUrl('thumbnail') . '?t=' . time()); ?>
    </div>
</div>
<?php echo $form->fileFieldGroup($model, 'info_file'); ?>
<?php
echo $form->redactorGroup($model, 'html_page', array(
    'editorOptions' => array(
        'imageUpload' => $this->createUrl('upload'),
    ),
))
?>
<?php
echo $form->radioButtonListGroup($model, 'is_special_info', array(
    'widgetOptions' => array(
        'data' => array(
            ActiveRecord::YES => 'แสดงรายละเอียด',
            ActiveRecord::NO => 'ไม่แสดง',
        ),
    ),
));
?>
<div id="special-pane" style="display:<?php echo $model->is_special_info === ActiveRecord::YES ? 'block' : 'none' ?>;">
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php echo CHtml::image($model->specialFile->getFileUrl('thumbnail') . '?t=' . time(), '', array('class' => 'thumbnail')); ?>
        </div>
    </div>
    <?php echo $form->fileFieldGroup($model, 'special_info_file'); ?>
</div>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php
        Helper::buttonBack('บันทึกข้อมูล', array(
            'url' => array('manageExam/index'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type='text/javascript'>
    $(document).ready(function () {
        $('#color-picker').colorpicker().on('changeColor', function (event) {
            $(this).css("backgroundColor", event.color.toHex());
        });

        $('input[name="ExamType[is_special_info]"]').click(function () {
            if ($('input[name="ExamType[is_special_info]"]:checked').val() === "1") {
                $('#special-pane').show();
            } else {
                $('#special-pane').hide();
            }
            console.log($(this).val());
        });
    });
</script>