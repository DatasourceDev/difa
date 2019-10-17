<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มวัตถุประสงค์',
        'context' => 'primary',
        'url' => array('manageScheduleObjective/create', 'id' => $model->id),
        'buttonType' => 'link',
    ))
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ใช้ค่าเริ่มต้น',
        'context' => 'warning',
        'icon' => 'refresh',
        'url' => array('manageScheduleObjective/restore', 'id' => $model->id),
        'buttonType' => 'link',
        'htmlOptions' => array(
            'onclick' => 'return confirm("ต้องการคืนค่าวัตถุประสงค์การสอบ ให้เป็นค่าเริ่มต้น ?")',
        ),
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'name_th',
        ),
        array(
            'name' => 'name_en',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'array("manageScheduleObjective/update","id" => array("id" => $data->id, "exam_schedule_id" => $data->exam_schedule_id))',
            'deleteButtonUrl' => 'array("manageScheduleObjective/delete","id" => array("id" => $data->id, "exam_schedule_id" => $data->exam_schedule_id))',
        ),
    ),
));
?>
<?php $this->endContent(); ?>