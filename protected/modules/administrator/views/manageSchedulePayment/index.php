<?php echo Helper::htmlTopic('ข้อมูลการชำระเงิน', 'แสดงรายการชำระเงิน'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'บันทึกรับชำระเงิน',
        'url' => array('pay'),
        'buttonType' => 'link',
        'context' => 'primary',
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array_merge(
            ExamApplication::getDefaultGridViewColumns(), ExamApplication::getPaymentGridViewColumns()
    ),
));
?>