<?php $this->beginContent('application.views.mail._layout'); ?>
<h1>Hello, <span style="color:#279dff;"><?php echo CHtml::value($src, 'profile.fullname'); ?></span></h1>
<p>We had found previous account with same information as your account : <span style="color:#279dff;"><?php echo CHtml::value($src, 'username'); ?></span></p>
<p>This is your account information:</p> 
<table>
    <tr>
        <th>Username</th>
        <td style="color:#279dff;"><?php echo CHtml::value($des, 'username'); ?></td>
    </tr>
</table>
<?php $this->endContent(); ?>