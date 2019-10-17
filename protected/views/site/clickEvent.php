<?php
$this->renderPartial('/shared/event', array(
    'model' => $model,
))
?>
<?php if ($application = $model->getIsAccountJoined(Yii::app()->user->id)): ?>
    <div class="well well-sm">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => Helper::t('Joined', 'สมัครแล้ว'),
            'block' => true,
            'context' => 'success',
            'url' => array('exam/view', 'id' => $application->id),
            'buttonType' => 'link',
            'icon' => 'ok',
        ));
        ?>
    </div>
<?php else: ?>
    <?php if ($model->getIsApplicable()): ?>
        <div class="well well-sm">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => Helper::t('Apply', 'สมัคร'),
                'block' => true,
                'context' => 'primary',
                'url' => array('exam/apply', 'id' => $model->id),
                'buttonType' => 'link',
                'icon' => 'share',
            ));
            ?>
        </div>
    <?php else: ?>
        <?php echo CHtml::errorSummary($model, Helper::t('Remark', 'หมายเหตุ')); ?>
    <?php endif; ?>
<?php endif; ?>
