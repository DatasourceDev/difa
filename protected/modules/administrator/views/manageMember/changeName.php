<?php $this->beginContent('_layout', array('model' => $account,)); ?>
<h3><?php echo Helper::t('List of name changes', 'ประวัติการเปลี่ยนชื่อ'); ?></h3>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => Helper::t('From', 'เปลี่ยนจาก'),
            'value' => 'CHtml::value($data,"htmlChangeFrom")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'value' => 'Helper::glyphicon("arrow-right")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('To', 'เปลี่ยนเป็น'),
            'value' => 'CHtml::value($data,"htmlChangeTo")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Date', 'วันที่ทำรายการ'),
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Attachment', 'หลักฐาน'),
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{self}',
            'buttons' => array(
                'self' => array(
                    'label' => 'ดาวน์โหลด',
                    'icon' => 'download',
                    'url' => 'array("downloadDocumentChangeName","id" => $data->id)',
                ),
            ),
        ),
        array(
            'header' => Helper::t('Delete', 'ลบ'),
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("changeNameDelete","id" => $data->id)',
        ),
    ),
));
?>
<br/><br/>
<h3><?php echo Helper::t('List of careers', 'ประวัติการทำงาน'); ?></h3>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $workProvider,
    'columns' => array(
        array(
            'header' => Helper::t('From', 'เปลี่ยนจาก'),
            'value' => 'CHtml::value($data,"htmlChangeFrom")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'value' => 'Helper::glyphicon("arrow-right")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('To', 'เปลี่ยนเป็น'),
            'value' => 'CHtml::value($data,"htmlChangeTo")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Date', 'วันที่ทำรายการ'),
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Delete', 'ลบ'),
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("changeDepartmentDelete","id" => $data->id)',
        ),
    ),
));
?>
<br/><br/>
<h3><?php echo Helper::t('List of member type', 'ประวัติการเปลี่ยนประเภทสมาชิก'); ?></h3>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $typeProvider,
    'columns' => array(
        array(
            'header' => Helper::t('From', 'เปลี่ยนจาก'),
            'value' => 'CHtml::value($data,"accountTypeOriginal.name_th")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'value' => 'Helper::glyphicon("arrow-right")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('To', 'เปลี่ยนเป็น'),
            'value' => 'CHtml::value($data,"accountType.name_th")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Date', 'วันที่ทำรายการ'),
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => Helper::t('Delete', 'ลบ'),
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("changeTypeDelete","id" => $data->id)',
        ),
    ),
));
?>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-register').change(function () {
            initForm();
        });
        initForm();
    });

    function initForm() {
        if ($('#Profile_title_id_th').val()) {
            $('#Profile_title_id_en').val($('#Profile_title_id_th').val());
        }
        if ($('#Profile_title_id_th').val() === 'O') {
            $('#Profile_title_th').closest('.form-group').show();
        } else {
            $('#Profile_title_th').closest('.form-group').hide();
        }

        if ($('#Profile_title_id_en').val() === 'O') {
            $('#Profile_title_en').closest('.form-group').show();
        } else {
            $('#Profile_title_en').closest('.form-group').hide();
        }
    }
</script>