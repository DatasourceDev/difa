<div class="thumbnail">
    <?php echo CHtml::link(CHtml::image(CHtml::value($data, 'coverFile.fileUrl')), array('webContent/view', 'id' => $data->id)); ?>
    <h4 class="fancy"><?php echo CHtml::link(CHtml::value($data, 'name'), array('webContent/view', 'id' => $data->id)); ?></h4>
    <?php echo CHtml::value($data, 'brief'); ?>
</div>