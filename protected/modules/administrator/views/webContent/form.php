<?php echo Helper::htmlTopic('จัดการเนื้อหาข่าวสาร', 'เพิ่ม/แก้ไข เนื้อหา'); ?>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'เนื้อหาข่าวสาร',
));
?>
<?php
echo $form->radioButtonListGroup($model, 'lang', array(
    'widgetOptions' => array(
        'data' => WebContent::getLanguageOptions(),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php echo CHtml::image($model->coverFile->getFileUrl('thumbnail')); ?>
    </div>
</div>
<?php echo $form->fileFieldGroup($model, 'cover_file'); ?>
<?php if (isset($model->vdo)): ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">    
        <video width="300" height="150" controls>
            <source src="<?php echo $model->getVDOFile() ?>">
        </video>
    </div>
</div>
<?php endif; ?>
<?php
echo $form->fileFieldGroup($model, 'vdo_file', array(
    'hint' => 'mp4, ogg, webm',
));
?>
<?php
echo $form->textAreaGroup($model, 'brief', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'rows' => 5,
        ),
    ),
));
?>
<?php
echo $form->colorPickerGroup($model, 'brief_color', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'color-picker',
            'style' => 'background-color:' . CHtml::value($model, 'brief_color', '#000000') . ';',
        ),
    ),
));
?>

<?php echo $form->textFieldGroup($model, 'custom_link'); ?>
<?php
echo $form->redactorGroup($model, 'content', array(
    'widgetOptions' => array(
        'editorOptions' => array(
            'imageUpload' => $this->createUrl('upload'),
            'fileUpload' => $this->createUrl('upload'),
        ),
    ),
));
?>
<?php
echo $form->datePickerGroup($model, 'date_start', array(
    'widgetOptions' => array(
    ),
    'prepend' => Helper::glyphicon('calendar'),
));
?>
<?php
echo $form->datePickerGroup($model, 'date_end', array(
    'widgetOptions' => array(),
    'prepend' => Helper::glyphicon('calendar'),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'is_visible', array(
    'widgetOptions' => array(
        'data' => WebContent::getIsVisibleOptions(),
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
            'icon' => 'floppy-save',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php echo Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type='text/javascript'>
    $(document).ready(function () {
        $('#color-picker').colorpicker().on('changeColor', function (event) {
            $(this).css("backgroundColor", event.color.toHex());
        });
    });
</script>