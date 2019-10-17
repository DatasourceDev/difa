<?php $this->beginContent('_layout', array('model' => $account,)); ?>
<h3><?php echo Helper::t('List of name changes', 'สถานะบัญชี'); ?></h3>
<div class="form form-horizontal">
    <div class="form-group">
        <label class="col-sm-3 control-label">สถานะ</label>
        <div class="col-sm-9">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เปิดให้สมัครสอบได้',
                'context' => $account->isEnable ? 'success' : 'default',
                'buttonType' => 'link',
                'url' => $account->isEnable ? array('#') : array('doAccountEnable', 'id' => $account->id),
                'htmlOptions' => array(
                    'onclick' => $account->isEnable ? '' : 'return confirm("ต้องการเปิดให้บัญชีนี้ สามารถสมัครสอบได้?")',
                ),
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ยกเลิกให้สมัครสอบ',
                'context' => $account->isEnable ? 'default' : 'danger',
                'buttonType' => 'link',
                'url' => !$account->isEnable ? array('#') : array('doAccountDisable', 'id' => $account->id),
                'htmlOptions' => array(
                    'onclick' => !$account->isEnable ? '' : 'return confirm("ต้องการยกเลิกให้สมัครสอบ?")',
                ),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>