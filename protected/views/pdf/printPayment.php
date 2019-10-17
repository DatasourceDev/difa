<?php $this->beginContent('application.views.pdf.layout'); ?>
<table border="0" width="100%">
    <tr>
        <td>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/images/logo.png', '', array('width' => '200')); ?>        
        </td>
        <td>
            <h1>ใบชำระเงิน</h1>
        </td>
        <td width="30%" style="font-size:12pt;" align="right">
            <div>[ส่วนที่ 1 : สำหรับธนาคาร]</div>
        </td>
    </tr>
</table>
<table width="100%" style="border-top:1px solid #000000;">
    <tr>
        <th align="right">Comp Code.</th>
        <td><?php echo CHtml::value($model, 'desk_code'); ?></td>
    </tr>
    <tr>
        <th align="right">Reference 1</th>
        <td><?php echo CHtml::value($model, 'desk_code'); ?></td>
    </tr>
    <tr>
        <th align="right">Reference 2</th>
        <td><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
    </tr>
    <tr>
        <th align="right">จำนวนเงินที่ต้องชำระ</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_name'); ?></td>
    </tr>
    <tr>
        <th align="right">กำหนดชำระเงิน</th>
        <td><?php echo CHtml::value($model, 'desk_no'); ?></td>
    </tr>
</table>
<table border="1" cellspacing="0" cellpadding="4">
    <tr>
        <td colspan="3">
            <div><strong>เพื่อเข้าบัญชี</strong>....................................................................</div>
            <ul>
                <li>ธนาคาร....................................................................</li>
                <li>ธนาคาร....................................................................</li>
            </ul>
        </td>
        <td colspan="2" rowspan="3">
            <div><strong>ชุดรับชำระเงิน / PAY-IN SLIP</strong></div>
            <ul>
                <li>วันที่....................................................................</li>
                <li>ชื่อสมาชิกบัตร..............................................................</li>
                <li>หมายเลขบัตร (Ref.1)..............................................................</li>
                <li>ยอดเงินถึงวันที่ (Ref.2)..............................................................</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <ul>
                <li>ธนาคาร....................................................................</li>
                <li>ธนาคาร....................................................................</li>
                <li>ธนาคาร....................................................................</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <ul>
                <li>ตัวแทนชำระเงิน....................................................................</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>หมายเลขเช็ค / Cheque No.</td>
        <td>เช็คลงวันที่ / Date</td>
        <td>ชื่อธนาคาร / Drawee Bank</td>
        <td>สาขา / Branch</td>
        <td>บาท / Baht</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<br/><br/>
<div align="center">
    <?php echo CHtml::image(Yii::app()->baseUrl . '/get/barcode?code=|999999999999999999999999999999999999999999999', '', array('height' => '40')); ?>        
</div>
<?php $this->endContent(); ?>