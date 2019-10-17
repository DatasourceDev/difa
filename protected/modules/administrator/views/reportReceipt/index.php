<?php $this->beginContent('_menu'); ?>
<?php $this->beginContent('/layouts/wrapper/searchBox'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'action' => array($this->action->id),
    'method' => 'get',
        ));
?>
<?php
echo $form->dateRangeGroup($model, 'search[date_range]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
        'options' => array(
            'format' => 'YYYY-MM-DD',
        ),
    ),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-5',
    ),
    'labelOptions' => array(
        'label' => 'ช่วงเวลา',
    ),
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
));
?>
<?php echo $form->textFieldGroup($model, 'doc_name', array()); ?>
<?php echo $form->textFieldGroup($model, 'payer_name', array()); ?>
<div id="xpane">
    <?php
    $criteria = new CDbCriteria();
    if (!empty($model->search['date_range'])) {
        $criteria->addBetweenCondition('db_date', Helper::getStartDate($model->search['date_range']), Helper::getEndDate($model->search['date_range']));
    }
    echo $form->dropDownListGroup($model, 'exam_schedule_id', array(
        'widgetOptions' => array(
            'data' => CHtml::listData(ExamSchedule::model()->sortBy('db_date DESC')->findAll($criteria), 'id', 'textExamCode'),
            'htmlOptions' => array(
                'prompt' => '(ทุกรอบสอบ)',
            ),
        ),
        'labelOptions' => array(
            'label' => 'รอบสอบ',
            'required' => false,
        ),
    ));
    ?>
</div>
<?php
echo $form->dropDownListGroup($model, 'is_office', array(
    'widgetOptions' => array(
        'data' => Receipt::getTypeOptions(),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทใบเสร็จ',
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'context' => 'info',
            'buttonType' => 'submit',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
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
    'label' => 'พิมพ์ใบเสร็จรับเงิน',
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
        array(
            'header' => 'เลขที่ใบเสร็จ',
            'name' => 'doc_name',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ผู้ชำระเงิน',
            'name' => 'payer_name',
        ),
        array(
            'header' => 'วันที่ออกใบเสร็จ',
            'name' => 'payment_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'จำนวนเงิน',
            'name' => 'amount',
            'value' => 'Yii::app()->format->formatNumber($data->amount) . "<div><small>" . Helper::number2Text($data->amount) . "</small></div>"',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSchedule.exam_code")',
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ประเภท',
            'name' => 'is_office',
            'value' => '$data->textType',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'type' => 'select',
                'url' => array('update'),
                'source' => CHtml::listData(ReceiptApprover::model()->findAll(), 'id', 'name'),
            ),
            'header' => 'ชื่อผู้รับเงิน',
            'name' => 'approve_id',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        //'value' => '$data->approve_name . "<div><small class=\"text-muted\">". $data->approve_position ."</small></div>"',
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

        $('#Receipt_search_date_range').on('apply.daterangepicker', function (ev, picker) {
            var frm = $(this).closest('form');
            $('#xpane select').prop('disabled', true);
            $.get($(frm).attr('action'), $(frm).serialize(), function (data) {
                $('#xpane').html($('#xpane', data).html());
                $('#xpane select').prop('disabled', false);
            });
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
<?php $this->endContent(); ?>