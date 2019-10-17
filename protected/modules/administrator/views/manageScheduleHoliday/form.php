<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลวันหยุดนักขัตฤกษ์',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->datePickerGroup($model, 'id', array(
    'widgetOptions' => array(
    ),
    'prepend' => Helper::glyphicon('calendar'),
));
?>
<?php
echo $form->textFieldGroup($model, 'name_th', array(
    'prepend' => Helper::image('lang_th'),
));
?>
<?php
echo $form->textFieldGroup($model, 'name_en', array(
    'prepend' => Helper::image('lang_en'),
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
