<?php
$this->renderPartial('//shared/event', array(
    'model' => $model,
    'showTitle' => true,
))
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'สถานะ',
            'name' => 'is_close',
            'value' => $model->htmlAdminStatus,
            'type' => 'raw',
        ),
    ),
));
?>
<div class="well well-sm">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ไปยังหน้าจัดการข้อมูล',
        'block' => true,
        'context' => 'primary',
        'url' => array('view', 'id' => $model->id),
        'buttonType' => 'link',
        'icon' => 'share',
    ));
    ?>
</div>