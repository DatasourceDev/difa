<div class="topic">สมัครสอบเรียบร้อย</div>
สมัครสอบเรียบร้อย กรุณาชำระเงินตามรายละเอียดในใบชำระเงิน
<div class="text-center">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์ใบชำระเงิน และ บัตรประจำตัวสอบ',
        'icon' => 'print',
        'size' => 'large',
        'buttonType' => 'link',
        'url' => array('printPaymentSlip', 'id' => $model->id),
    ));
    ?>
</div>