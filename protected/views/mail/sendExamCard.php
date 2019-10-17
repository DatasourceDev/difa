<?php $this->beginContent('application.views.mail._layout'); ?>
We've sending you a payment slip.
<hr/>
<pre><?php echo Configuration::getKey('email_signature'); ?></pre>
<?php $this->endContent(); ?>