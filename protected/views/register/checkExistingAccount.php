<div class="modal-header">
    <h3 class="fancy modal-title">เราพบข้อมูลบัญชีเดิมของคุณ</h3>
</div>
<div class="modal-body">
    <dl class="dl-horizontal">
        <dt>ชื่อบัญชี</dt>
        <dd class="text-primary"><?php echo CHtml::value($account, 'username'); ?></dd>
        <dt>ชื่อ-นามสกุล</dt>
        <dd class="text-primary"><?php echo CHtml::value($account, 'profile.fullname'); ?></dd>
        <dt>วันเกิด</dt>
        <dd class="text-primary"><?php echo Yii::app()->format->formatDateText(CHtml::value($account, 'profile.birth_date')); ?></dd>
    </dl>

</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Yii::t('app', 'Login with existing account'),
        'context' => 'primary',
        'icon' => 'log-in',
        'buttonType' => 'link',
        'url' => array('site/login', 'LoginForm' => array(
                'username' => $account->username,
            )),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Yii::t('app', 'Close'),
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>