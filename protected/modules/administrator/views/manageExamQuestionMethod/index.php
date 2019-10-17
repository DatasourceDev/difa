<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มชนิดของข้อสอบ',
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
            'name' => 'name',
        ),
        array(
            'header' => 'ตรวจโดยระบบ',
            'name' => 'is_auto_check',
            'value' => '$data->getIsAutoCheck() ? Helper::htmlSignSuccess("ตรวจคะแนนจากระบบ") : Helper::htmlSignFail("ตรวจคะแนนโดยมนุษย์")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
        ),
        /*
        array(
            'header' => 'การให้ระดับ',
            'name' => 'is_grade_set',
            'value' => '$data->getIsGradeSet() ? "กำหนดระดับ" : "คำนวณตามคะแนน"',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-2',
            ),
            'htmlOptions' => array(
                'class' => 'text-center col-sm-2',
            ),
        ),*/
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>