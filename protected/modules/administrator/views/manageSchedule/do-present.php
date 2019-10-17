<?php
$this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => array('doPresent', 'id' => $model->id),
));
?>
<div class="modal-header bg-primary">
    <h4>ยืนยันการลงทะเบียนเข้าห้องสอบ</h4>
</div>
<div class="modal-body">
    ต้องการลงทะเบียนเข้าห้องสอบ สำหรับ 
    <strong class="text-primary"><?php echo CHtml::encode(CHtml::value($model, 'fullnameTh')); ?> <small class="text-muted">(<?php echo CHtml::encode(CHtml::value($model, 'fullnameEn')); ?>)</small></strong> 
    เลขที่นั่งสอบ <strong class="text-primary"><?php echo CHtml::encode(CHtml::value($model, 'deskNo')); ?></strong> ?
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ยืนยันการลงทะเบียน',
        'icon' => 'pencil',
        'buttonType' => 'submit',
        'context' => 'success',
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ปิด',
        'icon' => 'remove',
        'buttonType' => 'button',
        'htmlOptions' => array(
            'class' => 'pull-left',
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>