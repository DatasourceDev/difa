<?php echo Helper::htmlTopic('ระบบรายงาน', 'พิมพ์ใบรับรองจากไฟล์ Excel'); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
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
echo $form->datePickerGroup($model, 'test_date', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'วันที่สอบ',
    ),
));
?>
<?php
echo $form->fileFieldGroup($model, 'excel_file', array(
    'widgetOptions' => array(
    ),
    'labelOptions' => array(
        'label' => 'ไฟล์ Excel',
    ),
    'hint' => 'เฉพาะไฟล์ .xls หรือ .xlsx เท่านั้น (' . CHtml::link('ตัวอย่างไฟล์', array('download')) . ')',
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'พิมพ์ใบรับรอง',
            'icon' => 'print',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>