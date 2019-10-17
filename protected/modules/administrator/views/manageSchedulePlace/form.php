<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลสถานที่สอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php if ($model->placeFile->fileUrl): ?>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php echo CHtml::link(CHtml::image($model->placeFile->fileUrl . '?t=' . time()), array('#'), array('class' => 'thumbnail')); ?>
        </div>
    </div>
<?php endif; ?>
<?php echo $form->fileFieldGroup($model, 'place_file'); ?>
<?php if ($model->placeEnFile->fileUrl): ?>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php echo CHtml::link(CHtml::image($model->placeEnFile->fileUrl . '?t=' . time()), array('#'), array('class' => 'thumbnail')); ?>
        </div>
    </div>
<?php endif; ?>
<?php echo $form->fileFieldGroup($model, 'place_file_en'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>