<?php echo Helper::htmlTopic($this->title); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลประเภทรายจ่าย',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
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