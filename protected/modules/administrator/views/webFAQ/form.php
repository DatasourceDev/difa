<?php echo Helper::htmlTopic('คำถามที่พบบ่อย', 'เพิ่ม/แก้ไข คำถาม'); ?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'คำถามที่พบบ่อย',
));
?>
<?php echo $form->textFieldGroup($model, 'question'); ?>
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