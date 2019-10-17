<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<div class="text-small">
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
                'name' => 'examScheduleObjective.name_th',
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
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        'label' => 'แสดงรายละเอียด',
                        'url' => 'array("exam/view","id" => $data->id)',
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
</div>
<?php $this->endContent(); ?>