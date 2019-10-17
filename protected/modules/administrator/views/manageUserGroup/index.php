<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มกลุ่มผู้ใช้งาน',
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
            'value' => 'CHtml::link(CHtml::encode($data->name),array("update","id" => $data->id))',
            'type' => 'raw',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
        ),
    ),
));
?>