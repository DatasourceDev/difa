<?php $this->beginContent('application.views.mail._layout'); ?>
<h1>DVIFA Reset Member Password</h1>
<p>Hello, <?php echo CHtml::value($model, 'profile.firstname_th', CHtml::value($model, 'profile.firstname_en')); ?> <?php echo CHtml::value($model, 'profile.lastname_th', CHtml::value($model, 'profile.lastname_en')); ?></p>
<p>Link to reset password : <?php echo CHtml::link($this->createAbsoluteUrl('site/resetPassword', array('key' => $model->tmp_password, 'id' => $model->id)), $this->createAbsoluteUrl('site/resetPassword', array('key' => $model->tmp_password, 'id' => $model->id))); ?></p>
<?php $this->endContent(); ?>