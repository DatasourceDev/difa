<h4 class="fancy"><?php echo $content->name; ?></h4>
<div>
    <small class="text-muted"><?php echo Helper::glyphicon('time'); ?> <?php echo Yii::app()->format->formatDatetime(CHtml::value($content, 'created')); ?></small>
</div>
<div class="web-content-body">
    <?php echo $content->content; ?>
</div>
<div class="well well-sm btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Back', 'ย้อนกลับ'),
        'icon' => 'arrow-left',
        'buttonType' => 'link',
        'url' => Yii::app()->homeUrl,
    ));
    ?>
</div>