<div class="topic">
    สำรองข้อมูล
</div>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'สำรองข้อมูลปัจจุบัน',
        'icon' => 'download',
        'url' => array('backup'),
        'buttonType' => 'link',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'btn-box-tool',
            'onclick' => 'return confirm("ต้องการสำรองข้อมูล?")',
        ),
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'รายการสำรองข้อมูล',
            'name' => 'name',
        ),
        array(
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'visible' => false,
        ),
        array(
            'header' => 'ผู้ดำเนินการ',
            'name' => 'account_id',
            'value' => 'CHtml::value($data,"user.username")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{save} {restore} {delete}',
            'buttons' => array(
                'save' => array(
                    'label' => 'ดาวน์โหลด',
                    'icon' => 'floppy-save',
                    'url' => 'array("download","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการดาวน์โหลดข้อมูล?")',
                    ),
                ),
                'restore' => array(
                    'label' => 'นำเข้า',
                    'icon' => 'download',
                    'url' => 'array("restore","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการนำเข้าข้อมูล ?\n*คำเตือน* การนำเข้าข้อมูลอาจจะทำให้ข้อมูลเดิมในระบบสูญหายได้")',
                    ),
                ),
            ),
        ),
    ),
));
?>