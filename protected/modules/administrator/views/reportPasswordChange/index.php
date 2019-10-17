<?php
$this->renderPartial('/report/search/account', array(
    'model' => $model,
));
?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'username',
            'value' => 'CHtml::link($data->username,array("manageMember/goto","id" => $data->id))',
            'type' => 'raw',
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'value' => 'CHtml::value($data,"profile.fullname")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-left',
            ),
        ),
        array(
            'header' => 'อีเมล์',
            'value' => 'CHtml::value($data,"profile.contact_email")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-left',
            ),
        ),
        array(
            'header' => 'เบอร์ติดต่อ',
            'value' => 'CHtml::value($data,"profile.textAnyPhone")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'is_legacy_update',
            'type' => 'raw',
            'value' => '$data->is_legacy_update ? "<span class=\"text-success\">เปลี่ยนแล้ว</span>" : "<span class=\"text-muted\">ยังไม่เปลี่ยน</span>"',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'วันที่เปลี่ยนรหัสผ่าน',
            'name' => 'legacy_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
    ),
));
?>