<?php
$this->renderPartial('/report/search/account', array(
    'model' => $model,
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'inline',
    'action' => 'exportXls',
        ));
?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ลบสมาชิก',
        'buttonType' => 'ajaxSubmit',
        'url' => array('deleteBulk'),
        'context' => 'danger',
        'htmlOptions' => array(
            'id' => 'btn-delete-bulk',
            'disabled' => true,
        ),
        'ajaxOptions' => array(
            'data' => 'js:{
                ids : $("#data-grid").yiiGridView("getSelection")
            }',
            'success' => 'js:function(){
                $("#data-grid").yiiGridView("update");
            }',
        ),
    ));
    ?>
    <?php echo CHtml::hiddenField('ids'); ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ XLS',
        'buttonType' => 'submit',
        'id' => 'btn-export',
        'context' => 'success',
        'icon' => 'share',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'afterAjaxUpdate' => 'js:function(){
        if (jQuery.isFunction(gridview_selectionChanged)) {
            gridview_selectionChanged(); 
        }
    }',
    'selectableRows' => 2,
    'selectionChanged' => 'js:function(){
        if (jQuery.isFunction(gridview_selectionChanged)) {
            gridview_selectionChanged(); 
        }
    }',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
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
            'header' => 'หน่วยงาน',
            'value' => 'CHtml::value($data,"accountProfile.department")',
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
            'header' => 'วันที่สมัคร',
            'name' => 'created',
            'type' => 'date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{confirm} {envelope} {delete}',
            'buttons' => array(
                'confirm' => array(
                    'label' => 'ยืนยัน',
                    'icon' => 'ok-sign',
                    'url' => 'array("setConfirm","id" => $data->id)',
                    'visible' => '$data->status === Account::STATUS_NEW',
                    'options' => array(
                        'class' => 'btn-ajax',
                    ),
                ),
                'envelope' => array(
                    'label' => 'ส่งจดหมายยืนยันอีกครั้ง',
                    'icon' => 'envelope',
                    'url' => 'array("resendConfirmationMail","id" => $data->id)',
                    'visible' => '$data->status === Account::STATUS_NEW',
                    'options' => array(
                        'class' => 'btn-ajax',
                    ),
                ),
                'delete' => array(
                    'label' => 'ลบข้อมูล',
                    'icon' => 'trash',
                    'url' => 'array("manageMember/delete","id" => $data->id)',
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    function gridview_selectionChanged() {
        var items = $('#data-grid').yiiGridView('getSelection');
        if (items.length > 0) {
            $('#btn-delete-bulk').prop('disabled', false);
        } else {
            $('#btn-delete-bulk').prop('disabled', true);
        }
        $('#ids').val(items);
    }
</script>