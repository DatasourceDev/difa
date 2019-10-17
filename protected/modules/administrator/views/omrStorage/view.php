<div class="modal-header">
    <h3 class="modal-title"><?php echo CHtml::value($model, 'exam_set'); ?> : <?php echo CHtml::value($model, 'dvifa_code'); ?> : <?php echo CHtml::value($model, 'exam_num'); ?></h3>
</div>
<div class="modal-body">
    <?php foreach ($model->getExamPhotos() as $photo): ?>
        <?php echo CHtml::link(CHtml::image('data:image/jpg;base64,' . base64_encode(file_get_contents($photo->filePath))), $photo->fileName, array('class' => 'thumbnail', 'target' => '_blank')); ?>
    <?php endforeach; ?>
</div>
<div class="modal-footer">
    <?php Helper::buttonModalClose(); ?>
</div>