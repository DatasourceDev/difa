<?php $this->beginContent('_layout', array('model' => $account,)); ?>
<h3><?php echo Helper::t('Change member type', 'เปลี่ยนประเภทสมาชิก'); ?></h3>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'id' => 'frm-type',
    ),
        ));
?>
<?php
echo $form->textFieldGroup($account, 'account_type_id_new', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'value' => CHtml::value($account, 'accountTypeNew.name_th'),
            'disabled' => true,
        ),
    ),
));
?>
<?php
echo $form->hiddenField($account, 'account_type_id_new');
?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'บันทึกข้อมูล',
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("ยืนยันการบันทึกข้อมูล?")',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>