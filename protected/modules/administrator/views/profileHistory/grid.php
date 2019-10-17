<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'รหัส',
            'name' => 'account_id',
            'value' => 'CHtml::link(CHtml::value($data,"account.username"),array("manageMember/goto","id" => $data->account_id))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'account_id',
            'value' => 'CHtml::value($data,"account.profile.fullname")',
            'type' => 'text',
        ),
        array(
            'header' => Helper::t('Date', 'วันที่ทำรายการ'),
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => 'array("manageMember/changeName","id" => $data->account_id)',
        ),
    ),
));
?>