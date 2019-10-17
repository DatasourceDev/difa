<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มชุดข้อสอบ',
        'context' => 'primary',
        'url' => array('create'),
        'buttonType' => 'link',
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ประเภท',
            'name' => 'exam_type_id',
            'value' => 'CHtml::value($data,"examType.name")',
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        array(
            'header' => 'ทักษะ',
            'name' => 'exam_subject_id',
            'value' => 'CHtml::value($data,"examSubject.name")',
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        array(
            'header' => 'รหัสชุดข้อสอบ',
            'name' => 'id',
            'value' => 'CHtml::link(CHtml::value($data,"id"),array("view","id" => $data->id))',
            'type' => 'html',
        ),
        array(
            'header' => 'จำนวน Task',
            'name' => 'countExamSetTask',
            'type' => 'number',
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        array(
            'header' => 'จำนวนข้อ',
            'name' => 'countExamSetTaskItem',
            'type' => 'number',
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        array(
            'header' => 'พร้อมใช้งาน',
            'value' => '$data->getIsReady() ? Helper::htmlSignSuccess() : Helper::htmlSignFail()',
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
        ),
    ),
));
?>