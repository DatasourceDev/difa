<?php echo Helper::htmlTopic('ข้อมูลจากระบบเดิม', 'นำเข้าฐานข้อมูล'); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'รายละเอียดฐานข้อมูล',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->textFieldGroup($model, 'name', array(
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
