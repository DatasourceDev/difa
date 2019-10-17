<div class="modal-header">
    <h3 class="modal-title fancy">พบบัญเดิมในระบบ</h3>
</div>
<div class="modal-body">
    <p>พบบัญชีของ <span class="text-primary"><?php echo CHtml::value($model, 'profile.fullname'); ?></span> <small>(<span class="text-info"><?php echo CHtml::value($model, 'entry_code'); ?></span>)</small></p>
    <p>คุณต้องการลงทะเบียน เพื่อเข้าสอบรอบ <span class="text-primary"><?php echo CHtml::value($examSchedule, 'exam_code'); ?> ?</span></p>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ปิด',
        'htmlOptions' => array(
            'class' => 'pull-left',
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ลงทะเบียนเข้าสอบ',
        'buttonType' => 'link',
        'url' => array('accountApply', 'id' => $model->id),
        'context' => 'success',
        'icon' => 'pencil',
    ));
    ?>
</div>