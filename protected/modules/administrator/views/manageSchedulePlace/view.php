<div class="modal-header">
    <h3 class="modal-title  text-center"><?php echo CHtml::value($model, 'name'); ?></h3>
</div>
<div class="modal-body text-center">
    <?php echo CHtml::link(CHtml::image($map), array('#'), array('class' => 'thumbnail')); ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ปิด',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>