<style>
.item p
{
text-align:justify;
padding-left:7px;
padding-right:7px;
}
</style>

<?php if(isset($data->custom_link) && CHtml::value($data, 'custom_link') !== ''): ?>
<div class="item align-center Carousel-Item"
   onclick="location.href='<?php echo CHtml::value($data, 'custom_link') ?>'">
   <div class="thumbnail">
      <?php if(isset($data->vdo) && CHtml::value($data, 'vdo') !== ''): ?>
      <video width="300" height="150" controls>
         <source src="<?php echo $data->getVDOFile() ?>">
      </video>
      <?php else: ?>
      <?php echo CHtml::link(CHtml::image($data->coverFile->getFileUrl('thumbnail')), CHtml::value($data, 'custom_link')); ?>
      <?php endif; ?>
   </div>
   <h5 class="fancy">
      <?php echo CHtml::link(CHtml::value($data, 'name'), CHtml::value($data, 'custom_link')); ?>
      <br />
      <?php if(isset($data->brief) && CHtml::value($data, 'brief') !== ''): ?>
         <p><?php echo CHtml::value($data, 'brief'); ?></p>
      <br />
      <?php endif; ?>

      <small class="text-muted">
         <?php echo Helper::glyphicon('time'); ?><?php echo Yii::app()->format->formatDateTime(CHtml::value($data, 'created')); ?>
      </small>
   </h5>
</div>
<?php else: ?>
<div class="item align-center Carousel-Item" onclick="location.href='<?php echo Yii::app()->createAbsoluteUrl('/webContent/view', array('id' => $data->id)); ?>'">
   <div class="thumbnail">
      <?php if(isset($data->vdo) && CHtml::value($data, 'vdo') !== ''): ?>
      <video width="300" height="150" controls>
         <source src="<?php echo $data->getVDOFile() ?>">
      </video>
      <?php else: ?>
      <?php echo CHtml::link(CHtml::image($data->coverFile->getFileUrl('thumbnail')), array('webContent/view', 'id' => $data->id)); ?>
      <?php endif; ?>
   </div>
   <h5 class="fancy">
      <?php echo CHtml::link(CHtml::value($data, 'name'), array('webContent/view', 'id' => $data->id)); ?>
      <br />
      <?php if(isset($data->brief) && CHtml::value($data, 'brief') !== ''): ?>
      <p><?php echo CHtml::value($data, 'brief'); ?></p>
      <br />
      <?php endif; ?>
      <small class="text-muted">
         <?php echo Helper::glyphicon('time'); ?> <?php echo Yii::app()->format->formatDateTime(CHtml::value($data, 'created')); ?>
      </small>
   </h5>
</div>
<?php endif; ?>



<style>
   .align-center {
      text-align: center;
   }

      .align-center h5 {
         font-size: 16px;
      }
</style>
