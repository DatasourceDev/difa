<?php echo Helper::htmlTopic('จัดการข้อความ SMS', 'เพิ่ม/แก้ไข เนื้อหา'); ?>

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
<?php
echo $form->datePickerGroup($model, 'date_start', array(
    'labelOptions' => array(
        'label' => 'สอบตั้งแต่วันที่',
    ),
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
));
?>
<?php
echo $form->datePickerGroup($model, 'date_end', array(
    'labelOptions' => array(
        'label' => 'ถึงวันที่',
    ),
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_type_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
            'class' => 'input-update',
            'data-target' => '#WebMail_search_exam_subject_id, #summary',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทสอบ',
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_subject_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->findAllByAttributes(array(
                    'exam_type_id' => CHtml::value($model, 'search.exam_type_id'),
                )), 'id', 'name'),
        'htmlOptions' => array(
            'class' => 'input-update',
            'data-target' => '#summary',
            'prompt' => '(ทั้งหมด)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ทักษะที่เลือกสอบ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[department]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'class' => 'input-update',
            'data-target' => '#summary',
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'หน่วยงาน/กระทรวง',
    ),
));
?>
<div class="form-group">
    <label class="control-label col-sm-3">
        จำนวนผู้รับข่าวสาร
    </label>
    <div class="col-sm-9">
        <div id="summary">
            <div class="form-control">
                <?php echo number_format($model->getRecipientCount()); ?> ราย
            </div>
            <span class="help-block">จำนวนผู้รับข่าวสาร จะไม่นับอีเมล์ที่ซ้ำกัน</span>
        </div>
    </div>
</div>
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