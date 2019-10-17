<?php echo Helper::htmlTopic($this->title); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มประเภทรายรับ',
        'buttonType' => 'link',
        'url' => array('create'),
        'context' => 'primary',
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:80px;',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'name',
        ),
        array(
            'name' => 'comp_code',
            'value' => '$data->getCompanyCode()',
            'type' => 'text',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>