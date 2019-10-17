<?php echo Helper::htmlTopic('จัดการเนื้อหาข่าวสาร', 'เพิ่ม/แก้ไข เนื้อหา'); ?>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'เนื้อหาข่าวสาร',
));
?>
<?php echo $form->textFieldGroup($model, 'title'); ?>
<?php
echo $form->redactorGroup($model, 'content', array(
    'widgetOptions' => array(
        'editorOptions' => array(
            'imageUpload' => $this->createUrl('upload'),
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