<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php $this->renderPartial($view, array('model' => $model, 'profile' => $profile)); ?>
<?php $this->endContent(); ?>