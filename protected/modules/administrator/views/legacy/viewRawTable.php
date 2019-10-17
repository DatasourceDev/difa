<?php $this->beginContent('_layout', array('model' => $model)); ?>
<div class="row">
    <div class="col-sm-2">
        <div class="text-center" style="margin-bottom: 16px;">
            <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/arrow-left.png'), array('view', 'id' => $model->id)); ?></div>
            <div><?php echo CHtml::link('Back to Report', array('view', 'id' => $model->id)); ?></div>
        </div>
    </div>
    <?php foreach ($tables as $table): ?>
        <?php
        try {
            $objName = 'Mdb' . $table;
            $obj = new $objName;
        } catch (Exception $e) {
            
        }
        ?>
        <div class="col-sm-2">
            <div class="text-center" style="margin-bottom: 16px;">
                <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/table.png'), array('viewTable', 'id' => $model->id, 'table_name' => $table)); ?></div>
                <div>
                    <?php echo CHtml::link($table, array('viewTable', 'id' => $model->id, 'table_name' => $table)); ?>
                    <br/><small><?php echo Yii::app()->format->formatNumber(isset($obj) ? $obj->model()->count() : 0); ?> รายการ</small>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php $this->endContent(); ?>