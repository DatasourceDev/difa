<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'รหัส',
            'name' => 'name',
        ),
         array(
            'header' => 'ชื่อรูปแบบ',
            'name' => 'desc',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{edit}',
            'buttons' => array(
                'edit' => array(
                    'label' => 'แก้ไข',
                    'icon' => 'pencil',
                    'url' => 'array("edit", "id" => CHtml::value($data, "id"))',
                    'visible' => 'CHtml::value($data, "id") === "custom" | CHtml::value($data, "id") === "custom02" | CHtml::value($data, "id") === "custom03" | CHtml::value($data, "id") === "custom04" | CHtml::value($data, "id") === "custom05" | CHtml::value($data, "id") === "custom06" | CHtml::value($data, "id") === "custom07" | CHtml::value($data, "id") === "custom08" | CHtml::value($data, "id") === "custom09" | CHtml::value($data, "id") === "custom10" ',
                ),
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{active} {inactive}',
            'buttons' => array(
                'active' => array(
                    'label' => 'กำลังใช้งาน',
                    'icon' => 'star',
                    'url' => 'array("active", "id" => CHtml::value($data, "id"))',
                    'visible' => 'CHtml::value($data, "id") === Configuration::getKey("web_template")',
                ),
                'inactive' => array(
                    'label' => 'ไม่ได้ใช้งาน',
                    'icon' => 'star-empty',
                    'url' => 'array("active", "id" => CHtml::value($data, "id"))',
                    'visible' => 'CHtml::value($data, "id") !== Configuration::getKey("web_template")',
                ),
            ),
        ),
    ),
));
?>
