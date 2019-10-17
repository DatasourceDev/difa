<?php echo Helper::htmlTopic('ข้อมูลจากระบบเดิม', 'กรุณาเลือกฐานข้อมูล'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'นำเข้าข้อมูลจากไฟล์ MDB',
        'context' => 'primary',
        'icon' => 'import',
        'url' => array('import'),
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
            'name' => 'created',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'col-sm-2 text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view} {update} {delete}',
        ),
    ),
));
?>