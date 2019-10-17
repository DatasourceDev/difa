<?php echo Helper::htmlTopic(' รายชื่อตัวแทนหน่วยงาน'); ?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ชื่อบัญชี',
            'name' => 'account.username',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อผู้ติดต่อประสานงาน',
            'name' => 'account.profile.fullname',
        ),
        array(
            'header' => 'หน่วยงาน/กระทรวง',
            'name' => 'account.profile.textDepartment',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'โควต้า',
            'name' => 'max_quota',
            'type' => 'number',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'จำนวนสมัคร',
            'name' => 'countApplication',
            'type' => 'number',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'is_confirm',
            'value' => '$data->isConfirm ? "ยืนยันเรียบร้อย" : "ยังไมไ่ด้ยืนยัน"',
            'type' => 'raw',
            'cssClassExpression' => '$data->isConfirm ? "text-success bg-success" : "text-danger bg-danger"',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
));
?>