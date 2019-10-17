<h4 class="fancy">จัดรอบสอบใหม่ ในวันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')) ?></span></h4>
<div class="well well-sm">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'จัดการสอบ',
        'block' => true,
        'context' => 'primary',
        'url' => array('create', 'd' => $model->db_date),
        'buttonType' => 'link',
    ));
    ?>
</div>