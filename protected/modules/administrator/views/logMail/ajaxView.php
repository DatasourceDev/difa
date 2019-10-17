<div class="modal-header bg-primary">
    <h4 class="modal-title"><?php echo CHtml::value($model, 'title'); ?></h4>
</div>
<div class="modal-body">
    <?php
    $this->widget('booster.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'name' => 'mail_from',
            ),
            array(
                'name' => 'mail_to',
            ),
            array(
                'name' => 'is_sent',
                'value' => $model->htmlIsSent,
                'type' => 'html',
            ),
        ),
    ));
    ?>
    <?php echo CHtml::value($model, 'content'); ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'icon' => 'refresh',
        'label' => 'ส่งอีกครั้ง',
        'context' => 'primary',
        'buttonType' => 'link',
        'url' => array('resend', 'id' => $model->id),
        'htmlOptions' => array(
            'class' => 'pull-left',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'icon' => 'trash',
        'label' => 'ลบข้อความ',
        'context' => 'danger',
        'buttonType' => 'link',
        'url' => array('delete', 'id' => $model->id),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => 'ปิด',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>