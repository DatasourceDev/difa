<?php echo Helper::htmlTopic('เอกสารดาวน์โหลด', 'เพิ่ม/แก้ไข เอกสาร'); ?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
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
<?php echo $form->textFieldGroup($model, 'name_th'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php
echo $form->fileFieldGroup($model, 'doc_file', array(
    'labelOptions' => array(
        'required' => $model->isNewRecord ? true : false,
    ),
));
?>
<?php if (file_exists($model->filePath)): ?>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ดาวน์โหลดเอกสาร',
                'icon' => 'download',
                'buttonType' => 'link',
                'url' => array('download', 'id' => $model->id),
                'context' => 'info',
            ));
            ?>
        </div>
    </div>
<?php endif; ?>
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