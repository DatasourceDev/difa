<?php $this->beginContent('_layout', array('model' => $model)); ?>
<div class="row">
    <div class="col-sm-3">
        <div class="text-center" style="margin-bottom: 16px;">
            <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/report.png'), array('viewApReport', 'id' => $model->id, 'MdbNameAPList' => array('search' => array('room_testtype' => 'P')))); ?></div>
            <div>
                <?php echo CHtml::link('Practical Test', array('viewApReport', 'id' => $model->id, 'test_type' => 'P')); ?>
                <br/><small><?php echo Yii::app()->format->formatNumber(MdbNameAPList::model()->scopePractical()->count()); ?> รายการ</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="text-center" style="margin-bottom: 16px;">
            <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/report.png'), array('viewApReport', 'id' => $model->id, 'MdbNameAPList' => array('search' => array('room_testtype' => 'A')))); ?></div>
            <div>
                <?php echo CHtml::link('Academic Test', array('viewApReport', 'id' => $model->id, 'test_type' => 'A')); ?>
                <br/><small><?php echo Yii::app()->format->formatNumber(MdbNameAPList::model()->scopeAcademic()->count()); ?> รายการ</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="text-center" style="margin-bottom: 16px;">
            <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/report.png'), array('viewPtReport', 'id' => $model->id)); ?></div>
            <div>
                <?php echo CHtml::link('Placement Test', array('viewPtReport', 'id' => $model->id)); ?>
                <br/><small><?php echo Yii::app()->format->formatNumber(MdbNamePTList::model()->count()); ?> รายการ</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="text-center" style="margin-bottom: 16px;">
            <div><?php echo CHtml::link(CHtml::image($this->module->assetUrl . '/images/table.png', '', array('width' => 64, 'height' => 64)), array('viewRawTable', 'id' => $model->id)); ?></div>
            <div><?php echo CHtml::link('ตารางข้อมูลดิบ', array('viewRawTable', 'id' => $model->id)); ?></div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>