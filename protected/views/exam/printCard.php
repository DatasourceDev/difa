<html>
    <head>
        <style>
            body, table {font-family: THSarabun;font-size:14pt;}
            td {font-size:14pt;}
            .barcode128 {font-family: code128;font-size:20pt;}
        </style>
    </head>
    <body>
        <table border="0" width="100%">
            <tr>
                <td width="15%">
                    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/logo.png', '', array('width' => '100')); ?>        
                </td>
                <td>
                    DVIFA
                </td>
                <td width="30%" style="font-size:12pt;" align="right">
                    <div>[ส่วนที่ 1 : สำหรับผู้สมัคร]</div>
                    <div><strong>เลขที่ No. <?php echo str_pad(CHtml::value($model, 'desk_no'), 6, '0', STR_PAD_LEFT); ?></strong></div>
                </td>
            </tr>
        </table>
        <div align="center" style="font-weight: bold;">ใบเรียกเก็บเงิน (Bill Payment) / ใบรับเงิน (Payin Slip)</div>
        <p>รหัสบัตรประจำตัวประชาชน Personal id : <?php echo CHtml::value($model, 'account.username'); ?> ชื่อ-นามสกุล Name-Surname : <?php echo CHtml::value($model, 'account.profile.fullname'); ?></p>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/get/qr?code=' . $model->getConfirmLink(), '', array('height' => '80')); ?>        
        <div>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/get/barcode?code=' . ($model->getPaymentCode()), '', array('height' => '40')); ?>        
        </div>
    </body>
</html>
