<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="topic"><?php echo Helper::t('Change Password', 'เปลี่ยนรหัสผ่าน'); ?></div>
<div class="row">
    <div class="col-md-6">
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
                'label' => Helper::t('Password', 'รหัสผ่าน'),
            ),
        ));
        ?>
        <?php
        echo $form->passwordFieldGroup($model, 'password_confirm', array(
            'labelOptions' => array(
                'label' => Helper::t('Confirm Password', 'ยืนยันรหัสผ่าน'),
                'style' => 'white-space:nowrap;'
            ),
        ));
        ?>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => Helper::t('Save Change', 'Save Change'),
                    'context' => 'primary',
                    'buttonType' => 'submit',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>