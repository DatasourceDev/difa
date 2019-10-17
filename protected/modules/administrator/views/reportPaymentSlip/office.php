<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบชำระเงินประเภทหน่วยงาน'); ?>
<?php $this->beginContent('/layouts/wrapper/searchBox'); ?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'id' => 'frm-date',
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('office'),
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
        'required' => false,
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
            'context' => 'info',
            'buttonType' => 'submit',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ล้างเงื่อนไข',
            'icon' => 'refresh',
            'buttonType' => 'link',
            'url' => array('office'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export',
    'type' => 'horizontal',
    'action' => array('printOffice'),
    'method' => 'get',
    'htmlOptions' => array(
        'target' => '_blank',
    ),
        ));
?>
<?php echo CHtml::hiddenField('items'); ?>
<?php
$this->widget('booster.widgets.TbButton', array(
    'label' => 'พิมพ์ใบชำระเงิน',
    'icon' => 'print',
    'context' => 'primary',
    'buttonType' => 'submit',
    'htmlOptions' => array(
        'id' => 'btn-export',
        'disabled' => true,
    ),
));
?>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'dataProvider' => $dataProvider,
    'afterAjaxUpdate' => 'js:function(){updateButton();}',
    'selectionChanged' => 'js:function(){updateButton();}',
    'selectableRows' => 2,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'header' => 'วันที่สอบ',
            'name' => 'examSchedule.db_date',
            'type' => 'date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::link($data->examSchedule->exam_code,array("manageSchedule/view","id" => $data->exam_schedule_id))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ประเภทการสอบ',
            'name' => 'examSchedule.examType.code',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ทักษะ',
            'name' => 'examSchedule.textSkillCode',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'วัตถุประสงค์',
            'name' => 'textObjective',
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
            'name' => 'max_quota',
            'value' => 'CHtml::value($data,"max_quota")',
            'type' => 'number',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ค่าธรรมเนียม',
            'name' => 'paymentAmount',
            'type' => 'money',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'header' => 'สถานะการชำระเงิน',
            'name' => 'is_paid',
            'value' => '$data->getHtmlPaymentStatus()',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-export').submit(function () {
            var items = $('.grid-view').yiiGridView('getSelection');
            if (items.length) {
                $('#items', this).val(items);
                return true;
            } else {
                alert('กรุณาเลือกรายการที่ต้องการพิมพ์');
                return false;
            }

        });
    });
    function updateButton() {
        var items = $('#data-grid').yiiGridView('getSelection');
        if (items.length > 0) {
            $('#btn-export').prop('disabled', false);
        } else {
            $('#btn-export').prop('disabled', true);
        }
    }
</script>