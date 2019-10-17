<?php $this->beginContent('application.views.mail._layout'); ?>
<p><?php echo CHtml::value($model, 'profile.fullnameEn'); ?></p>
<p>(<?php echo CHtml::value($model, 'profile.textDepartment'); ?>, <?php echo CHtml::value($model, 'profile.textWorkOffice'); ?>)</p>

<?php if ($examApplication->payment_amount > 0): ?>
<p>Thank you for applying. Please print the attached pay-in slip to make a payment.</p>
<p>Please bring the pay-in slip and your ID for registration on the test day.
</p>
<?php else: ?>
<p>Please print the exam card.</p>
<?php endif; ?>

<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $examApplication,
    'attributes' => array(
        array(
            'label' => 'Test Code',
            'name' => 'exam_type_id',
            'value' => $examApplication->examSchedule->examType->name,
        ),
        array(
            'label' => 'Applicants',
            'name' => 'payment_amount',
            'type' => 'moneyRoundText',
            'visible' => $examApplication->payment_amount > 0,
        ),
    ),
));
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $examApplication->examSchedule,
    'attributes' => $examApplication->examSchedule->getSkillDetailArray(),
));
?>

<p>For those with visual impairments, please provide further details at the following link so we can prepare the relevant format for you. <a href="https://goo.gl/forms/WWF4Ys3JpkOArTKZ2" target="_blank">https://goo.gl/forms/WWF4Ys3JpkOArTKZ2</a></p>
<p>Thank you for applying</p>
<?php $this->endContent(); ?>