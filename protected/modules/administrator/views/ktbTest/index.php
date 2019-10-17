<div class="topic">ทดสอบการชำระเงิน</div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->textFieldGroup($model, 'payment_code'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ชำระเงิน',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'payment_code',
        ),
        array(
            'name' => 'payment_amount',
        ),
        array(
            'name' => 'payment_date',
        ),
        array(
            'name' => 'due_date',
        ),
        array(
            'name' => 'is_paid',
        ),
    ),
));
?>