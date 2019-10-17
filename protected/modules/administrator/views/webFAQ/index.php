<?php echo Helper::htmlTopic('คำถามที่พบบ่อย'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มคำถาม',
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
            'name' => 'question',
        ),
        //array(
            //'name' => 'content',
            //'type'=>'raw'
        //),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>