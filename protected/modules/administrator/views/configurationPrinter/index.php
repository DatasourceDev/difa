<?php echo Helper::htmlTopic('ตั้งค่าระบบ'); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ตั้งค่าเครื่องพิมพ์',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'barcode_x', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'barcode_y', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'barcode_amount', array(
    'widgetOptions' => array(
    ),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>