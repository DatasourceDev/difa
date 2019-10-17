<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มผู้แทนหน่วยงาน',
        'context' => 'primary',
        'url' => array('manageOfficeUser/createOfficeUser', 'exam_schedule_id' => $model->id,'return'),
        'buttonType' => 'link',
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ชื่อผู้ใช้งาน',
            'name' => 'account_id',
            'value' => 'CHtml::value($data,"account.username")',
            'type' => 'text',
        ),
        array(
            'header' => 'หน่วยงาน',
            'name' => 'account.profile.textDepartment',
            'type' => 'text',
        ),
        array(
            'name' => 'preserved_quota',
            'type' => 'number',
            'headerHtmlOptions' => array(
                'class' => 'col-sm-2 text-center',
            ),
            'htmlOptions' => array(
                'class' => 'col-sm-2 text-center',
            ),
        ),
        array(
            'name' => 'is_paid',
            'type' => 'raw',
            'value' => 'CHtml::value($data,"htmlPaymentStatus")',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ยืนยัน',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{doConfirm} {undoConfirm}',
            'buttons' => array(
                'doConfirm' => array(
                    'label' => 'ตั้งเป็นยืนยันการสมัคร',
                    'icon' => 'remove',
                    'url' => 'array("manageOfficeUser/doConfirm","id" => $data->account_id)',
                    'visible' => 'YII_DEBUG && $data->is_confirm === ActiveRecord::NO',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
                'undoConfirm' => array(
                    'label' => 'ตั้งเป็นยังไม่ได้ยืนยันการสมัคร',
                    'icon' => 'ok',
                    'url' => 'array("manageOfficeUser/undoConfirm","id" => $data->account_id)',
                    'visible' => 'YII_DEBUG && $data->is_confirm === ActiveRecord::YES',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
            ),
            'visible' => 'YII_DEBUG',
        ),
        array(
            'header' => 'ชำระเงิน',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{doPaid} {undoPaid}',
            'buttons' => array(
                'doPaid' => array(
                    'label' => 'ตั้งค่าเป็นชำระเงิน',
                    'icon' => 'remove',
                    'url' => 'array("manageOfficeUser/doPaid","id" => $data->account_id)',
                    'visible' => 'YII_DEBUG && $data->is_paid === ActiveRecord::NO',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
                'undoPaid' => array(
                    'label' => 'ตั้งเป็นไม่ได้ชำระเงิน',
                    'icon' => 'ok',
                    'url' => 'array("manageOfficeUser/undoPaid","id" => $data->account_id)',
                    'visible' => 'YII_DEBUG && $data->is_paid === ActiveRecord::YES',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
            ),
            'visible' => 'YII_DEBUG',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
            'updateButtonUrl' => 'array("manageMember/goto","id" => $data->account_id)',
            'deleteButtonUrl' => 'array("manageOfficeUser/delete","id" => $data->account_id)',
        ),
    ),
));
?>
<?php $this->endContent(); ?>