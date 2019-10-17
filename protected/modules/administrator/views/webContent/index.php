<?php echo Helper::htmlTopic('จัดการเนื้อหาข่าวสาร', 'แสดงรายการข่าว'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'สร้างเนื้อหาใหม่',
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
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{pin} {unpin}',
            'buttons' => array(
                'pin' => array(
                    'icon' => 'star-empty',
                    'label' => 'ปักหมุด',
                    'url' => 'array("togglePin","id" => $data->id)',
                    'visible' => '!$data->isPin',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                ),
                'unpin' => array(
                    'icon' => 'star',
                    'label' => 'ถอนหมุด',
                    'url' => 'array("togglePin","id" => $data->id)',
                    'visible' => '$data->isPin',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                ),
            ),
        ),
        array(
            'value' => 'CHtml::image($this->grid->controller->module->assetUrl . "/images/lang_" . ($data->lang==="th" ? "th" : "en") . ".png" )',
            'type' => 'raw',
        ),
        array(
            'name' => 'name',
        ),
        array(
            'name' => 'date_start',
            'type' => 'date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'date_end',
            'type' => 'date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'is_visible',
            'value' => '$data->getHtmlIsVisible()',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
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
        ),
    ),
));
?>