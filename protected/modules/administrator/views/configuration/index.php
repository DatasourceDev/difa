<?php echo Helper::htmlTopic('ตั้งค่าระบบ'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การตั้งค่าทั่วไป',
));
?>
<?php
echo $form->textFieldGroup($model, 'grid_display_row', array(
    'widgetOptions' => array(
    ),
    'append' => 'แถว',
));
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การสอบ',
));
?>
<?php
echo $form->textFieldGroup($model, 'exam_retry_month', array(
    'widgetOptions' => array(
    ),
    'append' => 'เดือน',
));
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ผลการสอบ',
));
?>
<?php
echo $form->textFieldGroup($model, 'certificate_expire_month', array(
    'widgetOptions' => array(
    ),
    'append' => 'เดือน',
));
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การชำระเงิน',
));
?>
<?php
echo $form->textFieldGroup($model, 'payment_username', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'payment_password', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'payment_tax', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'payment_suffix', array(
))
?>
<?php
echo $form->textFieldGroup($model, 'payment_compcode', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->timePickerGroup($model, 'payment_due_time', array(
    'widgetOptions' => array(
    ),
));
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การพิมพ์บาร์โค้ดสำหรับติดกระดาษคำตอบ',
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
echo $form->textFieldGroup($model, 'barcode_height', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'barcode_text_height', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'barcode_text_width', array(
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
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การรับสมัคร',
));
?>
<?php
echo $form->textFieldGroup($model, 'register_before_day', array(
    'widgetOptions' => array(
    ),
    'append' => 'วัน',
));
?>
<?php
echo $form->textFieldGroup($model, 'register_presubmit_day', array(
    'widgetOptions' => array(
    ),
    'append' => 'วัน',
));
?>
<?php
echo $form->redactorGroup($model, 'web_office_index', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->redactorGroup($model, 'web_register_term_en', array(
    'widgetOptions' => array(
    ),
));
?>
<?php
echo $form->redactorGroup($model, 'web_register_term_th', array(
    'widgetOptions' => array(
    ),
));
?>
<?php $this->endWidget(); ?>
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