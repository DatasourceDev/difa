<div class="topic">รายการตรวจข้อสอบ</div>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
    'headerIcon' => 'search',
));
?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'action' => array('index'),
    'method' => 'get',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'search[exam_code]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
        'required' => false,
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[exam_set_id]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชุดข้อสอบ',
        'required' => false,
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[entry_code]', array(
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
echo $form->textFieldGroup($model, 'search[application_name]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชื่อ-นามสกุล',
    ),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('ค้นหา', array(
            'icon' => 'search',
        ));
        ?>    
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'อนุมัติ',
        'context' => 'success',
        'buttonType' => 'link',
        'url' => array('bulkApprove'),
        'htmlOptions' => array(
            'id' => 'btn-approve',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ไม่อนุมัติ',
        'context' => 'danger',
        'buttonType' => 'link',
        'url' => array('bulkDisapprove'),
        'htmlOptions' => array(
            'id' => 'btn-disapprove',
        ),
        'visible' => false,
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'grid-data',
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSchedule.exam_code")',
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'exam_application_id',
            'value' => 'CHtml::value($data,"examApplication.account.entry_code")',
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'exam_application_id',
            'value' => 'CHtml::value($data,"examApplication.account.profile.fullname")',
        ),
        array(
            'header' => 'ชุดข้อสอบ',
            'name' => 'exam_set_id',
            'value' => 'CHtml::value($data,"examSet.id")',
        ),
        array(
            'header' => 'คะแนน',
            'name' => 'score',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'Border Line',
            'name' => 'is_border_line',
            'value' => '$data->is_border_line === ActiveRecord::YES ? Helper::htmlSignSuccess() : ""',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ระดับ',
            'name' => 'grade',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ข้อมูลดิบ',
            'name' => 'raw_data',
        ),
        array(
            'header' => 'สร้างเมื่อ',
            'name' => 'created',
            'type' => 'datetime',
        ),
        array(
            'header' => 'อนุมัติ',
            'name' => 'is_grade_confirm',
            'value' => '$data->is_grade_confirm ==="1" ? Helper::htmlSignSuccess("อนุมัติ") : Helper::htmlSignFail("ไม่อนุมัติ")',
            'type' => 'raw',
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
        $('#btn-approve, #btn-disapprove').click(function () {
            var items = $('#grid-data').yiiGridView('getSelection');
            $.post($(this).attr('href'), {items: items}, function () {
                $('#grid-data').yiiGridView('update');
            });
            return false;
        });
    });
</script>