<?php $autoOpen = isset($autoOpen) ? $autoOpen : false; ?>
<?php
$this->beginContent('/layouts/wrapper/searchBox', array(
    'autoOpen' => $autoOpen,
));
?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<?php
echo $form->datePickerGroup($model, 'search[exam_schedule_date_start]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_date_start',
            'placeholder' => '',
            'class' => 'date-update',
            'data-target' => '#exam_schedule_id',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ตั้งแต่วันที่',
    ),
));
?>
<?php
echo $form->datePickerGroup($model, 'search[exam_schedule_date_end]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_date_end',
            'placeholder' => '',
            'class' => 'date-update',
            'data-target' => '#exam_schedule_id',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ถึงวันที่',
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_schedule_id', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_id',
            'prompt' => '(ค้นหาจากทุกรอบสอบในช่วงเวลาที่กำหนด)',
        ),
        'data' => CHtml::listData($model->getScheduleOnDateRange(), 'id', 'textExamCode'),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'desk_no', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'เลขที่นั่งสอบ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[username]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'เลขบัตรประชาชน/ID',
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
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'context' => 'info',
            'buttonType' => 'submit',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ล้างเงื่อนไข',
            'icon' => 'refresh',
            'buttonType' => 'link',
            'url' => array('index'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
