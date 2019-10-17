<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มชุดข้อสอบ',
        'context' => 'primary',
        'url' => array('manageScheduleItem/create', 'id' => $model->id),
        'buttonType' => 'link',
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'exam_set_id',
        ),
        array(
            'name' => 'db_date',
            'type' => 'dateText',
        ),
        array(
            'name' => 'time_start',
            'type' => 'time',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'time_end',
            'type' => 'time',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'place_name',
        ),
        array(
            'name' => 'place_remark',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'array("manageScheduleItem/update","id" => array("exam_set_id" => $data->exam_set_id, "exam_schedule_id" => $data->exam_schedule_id, "exam_subject_id" => $data->exam_subject_id))',
            'deleteButtonUrl' => 'array("manageScheduleItem/delete","id" => array("exam_set_id" => $data->exam_set_id, "exam_schedule_id" => $data->exam_schedule_id, "exam_subject_id" => $data->exam_subject_id))',
        ),
    ),
));
?>
<?php $this->endContent(); ?>