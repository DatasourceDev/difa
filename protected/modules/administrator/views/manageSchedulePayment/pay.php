<?php echo Helper::htmlTopic('บันทึกรับชำระเงิน'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->textFieldGroup($model, 'ref1'); ?>
<?php echo $form->textFieldGroup($model, 'ref2'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'label' => 'บันทึกรายการ',
            'context' => 'primary',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'link',
            'label' => 'ย้อนกลับ',
            'icon' => 'arrow-left',
            'url' => array('index'),
        ));
        ?>

    </div>
</div>
<?php $this->endWidget(); ?>