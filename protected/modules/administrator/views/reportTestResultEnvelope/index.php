<?php echo Helper::htmlTopic('ระบบรายงาน', 'ซองสำหรับส่งผลสอบ'); ?>
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
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ PDF',
        'icon' => 'print',
        'context' => 'danger',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export',
            'name' => 'mode',
            'value' => 'pdf',
            'disabled' => true,
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ PDF (แสดงชื่อเท่านั้น)',
        'icon' => 'print',
        'context' => 'danger',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export-2',
            'name' => 'mode',
            'value' => 'pdf-name-only',
            'disabled' => true,
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ DOC',
        'icon' => 'print',
        'context' => 'primary',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export-3',
            'name' => 'mode',
            'value' => 'doc',
            'disabled' => true,
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ส่งออกไฟล์ DOC (แสดงชื่อเท่านั้น)',
        'icon' => 'print',
        'context' => 'primary',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export-4',
            'name' => 'mode',
            'value' => 'doc-name-only',
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
    'afterAjaxUpdate' => 'js:function(){updateButton();}',
    'selectionChanged' => 'js:function(){updateButton();}',
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSchedule.exam_code")',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'desk_no',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'member_id',
            'value' => 'CHtml::value($data,"account.profile.fullname")',
            'type' => 'text',
        ),
        array(
            'header' => 'ที่อยู่',
            'name' => 'member_id',
            'value' => 'CHtml::value($data,"account.profile.replyAddress")',
            'type' => 'text',
        ),
        array(
            'header' => 'รหัสบัญชี',
            'name' => 'member_id',
            'value' => 'CHtml::value($data,"account.username")',
            'type' => 'text',
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
        $('#frm-export-2').submit(function () {
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
            $('#btn-export-2').prop('disabled', false);
            $('#btn-export-3').prop('disabled', false);
            $('#btn-export-4').prop('disabled', false);
        } else {
            $('#btn-export').prop('disabled', true);
            $('#btn-export-2').prop('disabled', true);
            $('#btn-export-3').prop('disabled', true);
            $('#btn-export-4').prop('disabled', true);
        }
    }
</script>