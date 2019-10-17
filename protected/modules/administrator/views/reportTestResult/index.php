<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบรับรองผลสอบภาษาอังกฤษ'); ?>
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
<div class="well well-sm">
    <?php echo CHtml::hiddenField('items'); ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์ใบรับรองผลสอบภาษาอังกฤษ',
        'icon' => 'print',
        'context' => 'info',
        'buttonType' => 'submit',
        'htmlOptions' => array(
            'id' => 'btn-export',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
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
        array(
            'header' => 'ทักษะในการสอบ',
            'value' => 'CHtml::value($data,"examSchedule.textSkill")',
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
</script>