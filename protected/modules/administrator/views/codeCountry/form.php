<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลประเทศ / สัญชาติ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'id'); ?>
<?php echo $form->textFieldGroup($model, 'name_th'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php echo $form->textFieldGroup($model, 'alpha2'); ?>
<?php echo $form->textFieldGroup($model, 'alpha3'); ?>
<?php echo $form->textFieldGroup($model, 'nationality'); ?>
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
