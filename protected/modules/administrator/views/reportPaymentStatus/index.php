<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายงานสถานะการชำระเงิน'); ?>
<?php
$this->beginContent('/layouts/wrapper/searchBox');
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<?php
echo $form->dateRangeGroup($model, 'search[exam_date_range]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
        'options' => array(
            'format' => 'YYYY-MM-DD',
        ),
    ),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-5',
    ),
    'labelOptions' => array(
        'label' => 'ช่วงเวลา',
    ),
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_type_id]', array(
    'labelOptions' => array(
        'label' => 'ประเภทการสอบ',
    ),
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_objective]', array(
    'labelOptions' => array(
        'label' => 'วัตถุประสงค์การสอบ',
    ),
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamScheduleObjective::model()->sortBy('name_th')->findAll(array(
                    'distinct' => 'name_th',
                )), 'name_th', 'name_th'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[firstname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชื่อ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[lastname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'นามสกุล',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[level]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ระดับ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[position]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ตำแหน่ง',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[department]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'หน่วยงาน',
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'apply_type', array(
    'widgetOptions' => array(
        'data' => ExamApplication::getApplyTypeOptions(),
        'htmlOptions' => array(
            'placeholder' => '',
            'prompt' => '(ทุกประเภท)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทการสมัคร',
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'context' => 'primary',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'search',
                'onclick' => 'this.form.target="_self";',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ PDF',
            'icon' => 'file',
            'context' => 'danger',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'pdf',
                'onclick' => 'this.form.target="_blank";',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ XLS',
            'icon' => 'th',
            'context' => 'success',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'xls',
                'onclick' => 'this.form.target="_blank";',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>

<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array_merge(ExamApplication::getDefaultGridViewColumns(), ExamApplication::getPaymentGridViewColumns()),
));
?>
