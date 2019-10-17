<div class="topic">We are checking your data</div>
<p class="text-center">Your data has been saved. Now we are checking your data. This process might take 1-2 days long.</p>
<p class="text-center">We will sent you a confirmation mail to <span class="text-primary"><?php echo CHtml::value($model, 'profile.contact_email'); ?></span> after you data has been approve.</p>
<p class="text-center">Sorry for inconvenience.</p>
<div class="text-center">
    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/email-sent.png', '', array('height' => 150)); ?>
</div>