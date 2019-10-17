<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'template' => '{items}',
    'dataProvider' => $dataProvider,
    'rowCssClassExpression' => 'isset($data->presentPreventSchedule) ? "bg-danger" : ""',
    'columns' => array(
        array(
            'header' => Helper::t('Date', 'วันที่สอบ'),
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSchedule.db_date")',
            'type' => 'dateText',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Date', 'วันที่สมัครสอบ'),
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"created")',
            'type' => 'dateText',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Type', 'ประเภทการสอบ'),
            'name' => 'examSchedule.examType.name',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Desk No.', 'เลขที่นั่งสอบ'),
            'name' => 'deskNo',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Objective', 'วัตถุประสงค์ในการสอบ'),
            'name' => 'textObjective',
            'type' => 'text',
        ),
        array(
            'header' => Helper::t('Payment', 'ชำระเงิน'),
            'name' => 'is_paid',
            'value' => 'CHtml::value($data,"isPaid") ? Helper::htmlSignSuccess() : Helper::htmlSignInfo()',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Seat In', 'เข้าห้องสอบ'),
            'name' => 'is_present',
            'value' => 'CHtml::value($data,"is_present") === ActiveRecord::YES ? Helper::htmlSignSuccess() : (isset($data->presentPreventSchedule) ? Helper::htmlSignWarning("ไม่สามารถลงทะเบียนเข้าสอบได้เนื่องจาก ได้ลงทะเบียนสอบในรอบ " . $data->presentPreventSchedule->textExamCode . " แล้ว") : Helper::htmlSignFail())',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Detail', 'รายละเอียด'),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:150px;',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'label' => 'แสดงรายละเอียด',
                    'url' => 'array("manageSchedule/viewAttendee","id" => $data->exam_schedule_id)',
                ),
            ),
        ),
        array(
            'header' => Helper::t('Remark', 'หมายเหตุ'),
            'value' => '$data->htmlRemark',
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
<?php $this->endContent(); ?>