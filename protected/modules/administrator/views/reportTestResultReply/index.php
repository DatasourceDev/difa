<?php echo Helper::htmlTopic('ระบบรายงาน', 'หนังสือแจ้งการสอบภาษาอังกฤษ'); ?>
<?php
$this->renderPartial('/report/search/examApplication', array(
    'model' => $model,
));?>
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
<?php echo CHtml::hiddenField('items'); ?>
<?php
$this->widget('booster.widgets.TbButton', array(
    'label' => 'พิมพ์หนังสือแจ้งการสอบภาษาอังกฤษ',
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
    'selectableRows' => 2,
    'afterAjaxUpdate' => 'js:function(){updateButton();}',
    'selectionChanged' => 'js:function(){updateButton();}',
    'columns' => array(
array(
    'class' => 'CCheckBoxColumn',
),
    ) + ExamApplication::getDefaultGridViewColumns(),
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
    function updateButton() {
        var items = $('#data-grid').yiiGridView('getSelection');
        if (items.length > 0) {
            $('#btn-export').prop('disabled', false);
        } else {
            $('#btn-export').prop('disabled', true);
        }
    }
</script>