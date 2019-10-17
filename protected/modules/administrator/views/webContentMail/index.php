<?php echo Helper::htmlTopic('จัดการข่าวสารทางอีเมล์', 'แสดงรายการข่าว'); ?>
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
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'title',
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