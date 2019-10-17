<?php
$this->beginContent('_layout', array(
    'model' => $model,
    'showMenu' => false,
));
?>
<h4 class="text-center fancy">ตาราง :: <?php echo $table_name; ?></h4>
<div class="well well-sm">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ย้อนกลับ',
        'icon' => 'arrow-left',
        'url' => array('view', 'id' => $model->id),
        'buttonType' => 'link',
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'filter' => $tableModel,
    'dataProvider' => $dataProvider,
    'columns' => CHtml::value($tableModel, 'columnArray', array()),
));
?>
<?php $this->endContent(); ?>