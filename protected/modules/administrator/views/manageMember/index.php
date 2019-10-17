<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มผู้ใช้งาน',
        'url' => array('create'),
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
            'header' => 'รหัส',
            'name' => 'username',
            'value' => 'CHtml::link($data->username,array("manageMember/goto","id" => $data->id))',
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
            'value' => 'CHtml::value($data,"profile.fullname")',
            'type' => 'text',
        ),
        array(
            'header' => 'ประเภท',
            'name' => 'account_type_id',
            'value' => 'CHtml::value($data,"accountType.name_th")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'status',
            'value' => 'CHtml::value($data,"status") === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess("ยืนยันการสมัครแล้ว") : Helper::htmlSignFail("ยังไม่ได้ยืนยันการสมัคร")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'created',
            'type' => 'datetime',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{confirm} {envelope} {delete}',
            'deleteButtonUrl' => 'array("manageMember/delete","id" => $data->id)',
            'buttons' => array(
                'confirm' => array(
                    'label' => 'ยืนยัน',
                    'icon' => 'ok-sign',
                    'url' => 'array("manageMember/setConfirm","id" => $data->id)',
                    'visible' => '$data->status === Account::STATUS_NEW',
                    'options' => array(
                        'class' => 'btn-ajax',
                    ),
                ),
                'envelope' => array(
                    'label' => 'ส่งจดหมายยืนยันอีกครั้ง',
                    'icon' => 'envelope',
                    'url' => 'array("manageMember/resendConfirmationMail","id" => $data->id)',
                    'visible' => '$data->status === Account::STATUS_NEW',
                    'options' => array(
                        'class' => 'btn-ajax',
                    ),
                ),
            ),
        ),
    ),
));
?>