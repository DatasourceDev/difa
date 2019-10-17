<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'sec-modal',
    'autoOpen' => true,
    'options' => array(
        'backdrop' => 'static',
        'keyboard' => false,
    ),
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="modal-header bg-primary">
    <h4 class="modal-title"><?php echo Helper::t('Change Password', 'เปลี่ยนรหัสผ่าน'); ?></h4>
</div>
<div class="modal-body">
    <?php
    echo $form->textFieldGroup($model, 'username', array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'disabled' => true,
            ),
        ),
        'labelOptions' => array(
            'label' => Helper::t('Username', 'ชื่อผู้ใช้'),
        ),
    ));
    ?>
    <?php
    echo $form->passwordFieldGroup($model, 'password_input', array(
        'labelOptions' => array(
            'label' => Helper::t('Password', 'รหัสผ่าน (ใหม่)'),
        ),
    ));
    ?>
    <?php
    echo $form->passwordFieldGroup($model, 'password_confirm', array(
        'labelOptions' => array(
            'label' => Helper::t('Confirm Password', 'ยืนยันรหัสผ่าน (ใหม่)'),
            'style' => 'white-space:nowrap;'
        ),
    ));
    ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Save Change', 'บันทึกรหัสผ่านใหม่'),
        'context' => 'primary',
        'buttonType' => 'submit',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sec-modal .modal-dialog').addClass('modal-lg');
    });
</script>