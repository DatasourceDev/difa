<?php

$this->renderPartial('/report/search/examApplication', array(
    'model' => $model,
));
?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ประเภท',
            'name' => 'exam_type_id',
            'value' => 'CHtml::value($data,"examSchedule.examType.code")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'รหัสรอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::link(CHtml::value($data,"examSchedule.exam_code"),array("manageSchedule/view","id" => $data->exam_schedule_id))',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'เลขที่นั่งสอบ',
            'name' => 'desk_no',
            'value' => 'str_pad($data->desk_no,3,"0",STR_PAD_LEFT)',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'account_id',
            'value' => 'CHtml::link(CHtml::value($data,"account.profile.fullname"),array("ajaxView/accountInfo","id"=> $data->account_id), array("class" => "btn-ajax-modal","data-modal-size" => "large")) . "<br/><small>". CHtml::value($data,"account.profile.textDepartment") ."</small>"',
            'type' => 'raw',
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'account_id',
            'value' => 'CHtml::value($data,"account.entry_code")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'exam_schedule_objective_id',
            'value' => 'CHtml::value($data,"textObjective")',
            'type' => 'text',
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'is_paid',
            'value' => 'CHtml::value($data,"is_paid") === ActiveRecord::YES ? Helper::htmlSignSuccess() : Helper::htmlSignFail()',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชำระเงิน',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{pay} {unpay}',
            'buttons' => array(
                'pay' => array(
                    'label' => 'ตั้งค่าเป็นชำระเงินแล้ว',
                    'icon' => 'flag',
                    'url' => 'array("setPaid","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการตั้งค่าเป็นชำระเงินแล้ว ?")',
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                    'visible' => '$data->is_paid === ActiveRecord::NO',
                ),
                'unpay' => array(
                    'label' => 'ตั้งค่าเป็นยังไม่ได้ชำระเงิน',
                    'icon' => 'ban-circle',
                    'url' => 'array("setUnpaid","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการตั้งค่าเป็นยังไม่ได้ชำระเงิน ?")',
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                    'visible' => '$data->is_paid === ActiveRecord::YES',
                ),
            ),
        ),
        array(
            'header' => 'ยกเลิก',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{btn}',
            'buttons' => array(
                'btn' => array(
                    'label' => 'ยกเลิกการสมัคร',
                    'icon' => 'ban-circle',
                    'url' => 'array("setCancel","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการยกเลิกการสมัคร ?")',
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
            ),
        ),
        array(
            'header' => 'ส่งบัตร',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{btn}',
            'buttons' => array(
                'btn' => array(
                    'label' => 'ส่งบัตรประจำตัวสอบผ่านอีเมล์',
                    'icon' => 'envelope',
                    'url' => 'array("sendExamCard","id" => $data->id)',
                    'options' => array(
                        'onclick' => 'return confirm("ต้องการส่งบัตรประจำตัวสอบผ่านอีเมล์ ?")',
                    ),
                ),
            ),
        ),
    ),
));
?>