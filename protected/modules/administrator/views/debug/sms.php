<div class="topic">ทดสอบการส่ง SMS</div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="form-group">
    <label class="control-label col-sm-3">MSISDN</label>
    <div class="col-sm-9">
        <?php echo CHtml::textField('sms[msisdn]', '', array('class' => 'form-control')); ?>
        <small>หมายเลข 11 หลัก เช่น 66850703426</small>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3">ข้อความ</label>
    <div class="col-sm-9">
        <?php echo CHtml::textField('sms[message]', '', array('class' => 'form-control')); ?>    
    </div>
</div>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ทดสอบส่ง SMS',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
