<div class="modal-body">
    <?php if (CHtml::value($model, 'specialFile.fileUrl')): ?>
        <?php echo CHtml::link(CHtml::image(CHtml::value($model, 'specialFile.fileUrl')), array('#'), array('class' => 'thumbnail', 'data-dismiss' => 'modal')); ?>
    <?php endif; ?>
    <div>
        <?php echo $model->special_info; ?>
    </div>
</div>