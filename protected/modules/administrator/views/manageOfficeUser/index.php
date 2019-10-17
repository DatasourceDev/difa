<?php $this->beginContent('/layouts/wrapper/searchBox'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
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
        'requried' => false,
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
        'label' => 'รหัสประจำตัว',
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
            'buttonType' => 'submit',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มตัวแทนหน่วยงาน',
        'url' => array('createOfficeUser'),
        'context' => 'primary',
        'buttonType' => 'link',
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::link($data->examSchedule->exam_code,array("manageSchedule/view","id" => $data->exam_schedule_id))',
            //'value' => '$data->examSchedule->exam_code',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'account_id',
            'value' => 'CHtml::link($data->account->username,array("profile","id" => $data->account_id))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'value' => 'CHtml::value($data,"account.profile.fullname")',
            'type' => 'text',
        ),
        array(
            'header' => 'หน่วยงาน/กระทรวง',
            'value' => 'CHtml::value($data,"account.profile.textDepartment")',
            'type' => 'text',
        ),
        array(
            'header' => 'โควต้า',
            'name' => 'preserved_quota',
            'value' => 'CHtml::value($data,"preserved_quota")',
            'type' => 'number',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สร้างเมื่อ',
            'value' => 'CHtml::value($data,"account.created")',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'หมดอายุ',
            'value' => 'CHtml::value($data,"htmlExpireDate")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("delete","id" => $data->account_id)',
        ),
    ),
));
