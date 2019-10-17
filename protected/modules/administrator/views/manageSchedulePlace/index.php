<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มสถานที่',
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
            'header' => 'TH',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{map}',
            'buttons' => array(
                'map' => array(
                    'label' => 'แผนที่',
                    'icon' => 'picture',
                    'url' => 'array("view","id" => $data->id,"type" => "th")',
                    'options' => array(
                        'class' => 'btn-ajax-modal',
                        'data-modal-size' => 'large',
                    ),
                ),
            ),
        ),
        array(
            'header' => 'EN',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{map}',
            'buttons' => array(
                'map' => array(
                    'label' => 'Map',
                    'icon' => 'picture',
                    'url' => 'array("view","id" => $data->id,"type" => "en")',
                    'options' => array(
                        'class' => 'btn-ajax-modal',
                        'data-modal-size' => 'large',
                    ),
                ),
            ),
        ),
        array(
            'name' => 'name',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>