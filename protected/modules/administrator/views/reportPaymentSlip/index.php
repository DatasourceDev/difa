<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบชำระเงิน'); ?>
<?php
$this->renderPartial('/report/search/examApplication', array(
    'model' => $model,
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export-2',
    'type' => 'horizontal',
    'action' => array('print'),
    'method' => 'get',
    'htmlOptions' => array(
        'target' => '_blank',
    ),
        ));
?>
<?php echo CHtml::hiddenField('items'); ?>
<?php
$this->widget('booster.widgets.TbButton', array(
    'label' => 'พิมพ์ใบชำระเงิน',
    'icon' => 'print',
    'context' => 'primary',
    'buttonType' => 'submit',
    'htmlOptions' => array(
        'id' => 'btn-export',
        'disabled' => true,
    ),
));
?>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'dataProvider' => $dataProvider,
    'afterAjaxUpdate' => 'js:function(){updateButton();}',
    'selectionChanged' => 'js:function(){updateButton();}',
    'selectableRows' => 0,
    'columns' => array_merge(array(
        array(
            'id' => 'chk_col',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'disabled' => '!$data->isPrintPaymentSlip',
        ),
            ), ExamApplication::getDefaultGridViewColumns(), ExamApplication::getPaymentGridViewColumns()),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-export-2').submit(function () {
            var items = $('.grid-view').yiiGridView('getChecked', 'chk_col');
            if (items.length) {
                $('#items', this).val(items);
                return true;
            } else {
                alert('กรุณาเลือกรายการที่ต้องการพิมพ์');
                return false;
            }

        });

        $(document).on('change', '.checkbox-column input', function () {
            updateButton();
        })
    });
    function updateButton() {

        var items = $('#data-grid').yiiGridView('getChecked', 'chk_col');
        console.log(items.length);
        if (items.length > 0) {
            $('#btn-export').prop('disabled', false);
        } else {
            $('#btn-export').prop('disabled', true);
        }
    }
</script>