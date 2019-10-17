<div class="modal-header">
    <h3 class="fancy modal-title"><?php echo Helper::t('Your account is existing in DIFA-TES', 'พบข้อมูลเดิมในระบบ'); ?></h3>
</div>
<div class="modal-body">
    <dl class="dl-horizontal">
        <dt><?php echo Helper::t('Username', 'รหัสประจำตัว'); ?></dt>
        <dd class = "text-primary"><?php echo CHtml::value($model, 'username'); ?></dd>
        <dt><?php echo Helper::t('Name', 'ชื่อ-นามสกุล'); ?></dt>
        <dd class="text-primary"><?php echo CHtml::value($model, 'profile.fullname'); ?></dd>
        <dt><?php echo Helper::t('Account Type', 'ประเภทบัญชี'); ?></dt>
        <dd class="text-primary"><?php echo CHtml::value($model, 'accountType.name_th'); ?></dd>
        <dt><?php echo Helper::t('Registered By', 'สมัครโดย'); ?></dt>
        <dd class="text-primary"><?php echo CHtml::value($model, 'profile.textDepartment', '-'); ?></dd>
        <dt><?php echo Helper::t('Current email', 'อีเมล์ปัจจุบัน'); ?></dt>
        <dd class="text-primary"><?php echo CHtml::value($model, 'profile.contact_email', '-'); ?></dd>
    </dl>

</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Yii::t('app', 'Take control your account'),
        'context' => 'primary',
        'icon' => 'log-in',
        'buttonType' => 'link',
        'url' => array('site/takeback', 'entry_code' => $model->entry_code),
    ));
    ?>
</div>