<?php echo Helper::htmlTopic('ระบบรายงาน', 'ทดสอบการชำระเงิน'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButtonGroup', array(
        'buttons' => array(
            array(
                'label' => 'สร้างใบชำระเงิน',
            ),
            array(
                'label' => 'ปกติ',
                'url' => array('create', 'status' => ApplicationPayment::TESTCASE_NORMAL),
                'buttonType' => 'link',
                'context' => 'success',
            ),
            array(
                'label' => 'ผิดพลาด',
                'context' => 'danger',
                'items' => array(
                    array(
                        'label' => 'Invalid Citizen ID (Ref.1)',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_CUSID),
                    ),
                    array(
                        'label' => 'Invalid Test Type (Ref.1)',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_TESTID),
                    ),
                    array(
                        'label' => 'Invalid App ID (Ref.2)',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_APPID),
                    ),
                    array(
                        'label' => 'Invalid DueDate ID (Ref.2)',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_DUEDATE),
                    ),
                    array(
                        'label' => 'Invalid Amount',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_AMOUNT),
                    ),
                    array(
                        'label' => 'Expired',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_EXPIRED),
                    ),
                    array(
                        'label' => 'Duplicated Payment',
                        'url' => array('create', 'status' => ApplicationPayment::TESTCASE_FAILED_PAIDED),
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        'id',
        array(
            'name' => 'ref1',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ), array(
            'name' => 'ref2',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'amount',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'name' => 'com_code',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'issue_date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'due_date',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'payment_status',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{print} {delete}',
            'buttons' => array(
                'print' => array(
                    'icon' => 'print',
                    'label' => 'พิมพ์ใบชำระเงิน',
                    'url' => 'array("print","id" => $data->id)',
                ),
            ),
        ),
    ),
));
?>