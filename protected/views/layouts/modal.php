<div class="modal-header">
    <h3 class="modal-title fancy"><?php echo $title; ?></h3>
</div>
<div class="modal-body">
    <?php echo $content; ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Yii::t('app', 'Close'),
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>