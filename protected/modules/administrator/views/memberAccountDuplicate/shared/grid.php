<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'value' => 'CHtml::link(Helper::glyphicon("picture"), array("manageMember/modalViewPassport", "id" => CHtml::value($data,"src_id")), array("class" => "btn-ajax-modal"))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'header' => 'ชื่อบัญชี',
            'name' => 'src_username',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'src_name',
            'htmlOptions' => array(
                'class' => 'bg-info',
            ),
        ),
        array(
            'header' => 'ประเภท',
            'name' => 'src_account_type',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'header' => 'สัญชาติ',
            'name' => 'src_nationality_id',
            'value' => 'CHtml::value(CodeCountry::model()->findByPk(CHtml::value($data,"src_nationality_id")),"nationality",CHtml::value($data,"src_nationality_id"))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'header' => 'วันเกิด',
            'name' => 'src_birth_date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'header' => 'ยืนยัน',
            'name' => 'src_status',
            'value' => 'CHtml::value($data,"src_status") === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess("ยืนยันการสมัครแล้ว") : Helper::htmlSignFail("ยังไม่ได้ยืนยันการสมัคร")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-info',
            ),
        ),
        array(
            'value' => 'Helper::glyphicon("resize-horizontal")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-danger',
            ),
        ),
        array(
            'value' => 'CHtml::link(Helper::glyphicon("picture"), array("manageMember/modalViewPassport", "id" => CHtml::value($data,"des_id")), array("class" => "btn-ajax-modal"))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'header' => 'ชื่อบัญชี',
            'name' => 'des_username',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'des_name',
            'htmlOptions' => array(
                'class' => 'bg-warning',
            ),
        ),
        array(
            'header' => 'ประเภท',
            'name' => 'des_account_type',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'header' => 'สัญชาติ',
            'name' => 'des_nationality_id',
            'value' => 'CHtml::value(CodeCountry::model()->findByPk(CHtml::value($data,"des_nationality_id")),"nationality",CHtml::value($data,"des_nationality_id"))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'header' => 'วันเกิด',
            'name' => 'des_birth_date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'header' => 'ยืนยัน',
            'name' => 'des_status',
            'value' => 'CHtml::value($data,"des_status") === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess("ยืนยันการสมัครแล้ว") : Helper::htmlSignFail("ยังไม่ได้ยืนยันการสมัคร")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center bg-warning',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view}',
            'viewButtonUrl' => 'array("memberAccountDuplicate/view","src_id" => CHtml::value($data,"src_id"),"des_id" => CHtml::value($data,"des_id"))',
        ),
    ),
));
?>