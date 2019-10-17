<div class="modal-header">
    <h3 class="fancy modal-title"><?php echo $title; ?></h3>
</div>
<div class="modal-body">
    <?php echo $content; ?>
</div>
<div class="modal-footer">
    <?php if (isset($buttons)): ?>
        <?php foreach ($buttons as $options): ?>
            <?php
            $this->widget('booster.widgets.TbButton', $options);
            ?>
        <?php endforeach ?>
    <?php endif; ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Yii::t('app', 'Close'),
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>