<?php echo Helper::htmlTopic('ระบบรายงาน', 'บาร์โค๊ดสำหรับติดบนกระดาษคำตอบ'); ?>
<div class="row">
    <div class="col-sm-9">
        <?php
        $this->renderPartial('/report/search/examApplication', array(
            'model' => $model,
            'autoOpen' => true,
        ));
        ?>
    </div>
    <div class="col-sm-3">
        <?php $this->widget('qz.widgets.QzPrintInfo'); ?>        
    </div>
</div>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์บาร์โค้ด',
        'icon' => 'print',
        'context' => 'primary',
        'htmlOptions' => array(
            'id' => 'btn-print',
            'disabled' => true,
        ),
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'selectionChanged' => 'js:function(){
        updatePrintButton();
    }',
    'columns' => array_merge(array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
            ), array_merge(ExamApplication::getExamInfoGridViewColumns(), ExamApplication::getAccountInfoGridViewColumns(), array(
        array(
            'header' => 'เลขบัตรประจำตัวประชาชน/ID',
            'name' => 'account.entry_code',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'applicationNumber',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
            ))
    ),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-print').click(function () {
            var items = $('#data-grid').yiiGridView('getSelection');
            var d = new Date();
            $.get('<?php echo $this->createUrl('print'); ?>?t=' + d.getTime(), {ids: items}, function (data) {
                console.log(data);
                qz.append(data);
                qz.print();
            });
            return false;
        });
    });

    function updatePrintButton() {
        var items = $('#data-grid').yiiGridView('getSelection');
        console.log(items);
        if (items.length > 0) {
            $('#btn-print').prop('disabled', false);
        } else {
            $('#btn-print').prop('disabled', true);
        }
    }
</script>