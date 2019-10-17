<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มหน่วยงาน',
        'context' => 'primary',
        'url' => array('departmentAdd', 'id' => $model->id),
        'buttonType' => 'link',
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ชื่อหน่วยงาน',
            'name' => 'code_department',
            'value' => 'CHtml::value($data,"codeDepartment.name_th")',
            'type' => 'text',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("departmentDelete","exam_schedule_id" => $data->exam_schedule_id, "code_department_id" => $data->code_department_id)',
        ),
    ),
));
?>
<?php $this->endContent(); ?>