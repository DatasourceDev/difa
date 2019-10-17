<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'นำเข้าข้อมูลกระดาษคำตอบ',
    'headerIcon' => 'upload',
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
echo $form->fileFieldGroup($model, 'omr_file', array(
    'widgetOptions' => array(
    ),
    'hint' => 'ไฟล์นามสกุล (.zip) เท่านั้น',
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('อัพโหลดไฟล์', array(
            'icon' => 'upload',
        ));
        ?>    
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>