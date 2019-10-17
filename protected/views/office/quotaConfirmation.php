<div class="modal-header">
    <h3 class="modal-title">ข้อความแจ้งเตือน</h3>
</div>
<div class="modal-body">คุณได้รับสิทธิในการสมัคร <span class="text-primary"><?php echo CHtml::value($this, 'scheduleAccount.preserved_quota'); ?></span> คน แต่ได้ยืนยันการสมัครเพียง <span class="text-success"><?php echo CHtml::value($this, 'scheduleAccount.countApplication'); ?></span> คน</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ยืนยันการสมัคร',
        'buttonType' => 'link',
        'context' => 'primary',
        'icon' => 'ok',
        'url' => array('registerConfirm'),
        'htmlOptions' => array(
            'onclick' => 'return confirm("You could not register more application after this confirmation.\nDo you want to confirm ?")',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'แก้ไขข้อมูล',
        'context' => 'warning',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>