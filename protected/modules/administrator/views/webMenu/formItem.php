<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'เมนูเว็บไซต์',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php echo $form->textFieldGroup($model, 'url'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
            'config' => array(
                'action' => array('upload'),
                'allowedExtensions' => Helper::getAllowedFileExtension(),
                'sizeLimit' => Helper::getMaxFileSize(),
                'onComplete' => 'js:function(id, fileName, responseJSON){
                    console.log("uploaded a file.");
                    $("#WebMenuItem_url").val("' . Yii::app()->baseUrl . '/uploads/tmp/" + fileName);
                }',
            ),
        ));
        ?>
    </div>
</div>
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