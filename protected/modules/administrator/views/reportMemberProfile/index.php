<?php echo Helper::htmlTopic('ระบบรายงาน', 'ประวัติการสอบรายบุคคล'); ?>
<?php
$this->renderPartial('/report/search/account', array(
    'model' => $model,
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export',
    'type' => 'horizontal',
    'action' => array('print'),
    'method' => 'get',
    'htmlOptions' => array(
        'target' => '_blank',
    ),
        ));
?>
<div class="btn-toolbar">
    <?php echo CHtml::hiddenField('items'); ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์ประวัติการสอบรายบุคคล',
        'icon' => 'print',
        'context' => 'info',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-print',
            'name' => 'mode',
            'value' => 'pdf',
            'disabled' => true,
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ XLS',
        'icon' => 'export',
        'context' => 'success',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export',
            'name' => 'mode',
            'value' => 'xls',
            'disabled' => true,
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'selectionChanged' => 'js:function(){
        updatePrintButton();
    }',
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'header' => 'หมายเลขบัตรประชาชน/ID',
            'name' => 'username',
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'value' => 'CHtml::link(CHtml::value($data,"profile.fullname"),array("ajaxView/accountInfo","id" => $data->id),array("class" => "btn-ajax-modal"))',
            'type' => 'raw',
        ),
        array(
            'header' => 'ประเภทสมาชิก',
            'name' => 'account_type_id',
            'value' => 'CHtml::value($data,"accountType.name_th")',
            'type' => 'raw',
        ),
        array(
            'header' => 'จำนวนการสอบ',
            'value' => 'CHtml::value($data,"countExamApplication")',
            'type' => 'number',
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
    function updatePrintButton() {
        var items = $('#data-grid').yiiGridView('getSelection');
        console.log(items);
        if (items.length > 0) {
            $('#btn-print').prop('disabled', false);
            $('#btn-export').prop('disabled', false);
        } else {
            $('#btn-print').prop('disabled', true);
            $('#btn-export').prop('disabled', true);
        }
    }
</script>