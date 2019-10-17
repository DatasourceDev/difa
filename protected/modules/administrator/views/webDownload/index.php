<?php echo Helper::htmlTopic('เอกสารดาวน์โหลด'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มเอกสาร',
        'buttonType' => 'link',
        'url' => array('create'),
        'context' => 'primary',
    ));
    ?>
</div> 

<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ลำดับ',
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{up} {down}',
            'buttons' => array(
                'up' => array(
                    'icon' => 'arrow-up',
                    'url' => 'array("moveUp","id" => $data->id)',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                ),
                'down' => array(
                    'icon' => 'arrow-down',
                    'url' => 'array("moveDown","id" => $data->id)',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                ),
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{download}',
            'buttons' => array(
                'download' => array(
                    'icon' => 'download',
                    'label' => 'ดาวน์โหลดเอกสาร',
                    'url' => 'array("download","id" => $data->id)',
                ),
            ),
        ),
        array(
            'name' => 'name_th',
        ),
        array(
            'name' => 'name_en',
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
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>