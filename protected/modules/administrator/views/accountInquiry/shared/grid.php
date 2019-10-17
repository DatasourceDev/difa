<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'rowCssClassExpression' => '$data->is_done === ActiveRecord::YES ? "bg-success" : ""',
    'columns' => array(
        array(
            'header' => 'ตอบกลับแล้ว',
            'value' => '$data->is_done === ActiveRecord::YES ? Helper::htmlSignSuccess() : Helper::htmlSignFail()',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'Case ID#',
            'name' => 'id',
            'value' => 'str_pad($data->id,6,"0",STR_PAD_LEFT)',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'วันที่แจ้ง',
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        'fullname:text:ชื่อ-นามสกุล',
        'email:text:อีเมล์',
        'topic:text:หัวเรื่อง',
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => 'array("accountInquiry/view","id" => $data->id)',
            'deleteButtonUrl' => 'array("accountInquiry/delete","id" => $data->id)',
        ),
    ),
));
