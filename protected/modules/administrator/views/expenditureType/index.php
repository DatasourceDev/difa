<?php echo Helper::htmlTopic($this->title); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มประเภทรายจ่าย',
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
            'header' => 'ลำดับ',
            'name' => 'id',
            'value' => 'CHtml::value($this, "grid.dataProvider.pagination.currentPage", 0) * (CHtml::value($this, "grid.dataProvider.pagination.pageSize")) + ($row + 1)',
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
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>