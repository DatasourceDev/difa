<html>
    <head>
        <style>
            body {font-family: 'TH SarabunPSK', thsarabun;font-size:17pt;font-weight: bold;margin-top:3cm;}
            .text-center {text-align: center;}
        </style>
    </head>
    <body>
        <br/>
        <table width="100%">
            <tr>
                <td width="75%" style="margin-left:0.5cm;"><br/><br/>ที่ กต 0204/
                </td>
                <td class="text-center" style="font-size:12pt;border:1px solid #000;padding:0.2cm;">ชำระค่าบริการเป็นเงินเชื่อ<br/>ใบอนุญาตที่ 73/2560<br/>ปณฝ. ศูนย์ราชการเฉลิมพระเกียรติ</td>
            </tr>
        </table>
        <br/>
        <table width="100%" border="0" cellspacing="5" style="table-layout:fixed;">
            <tr>
                <td width="30%" style="vertical-align: top;padding-right:1cm;" align="right">เรียน</td>
                <td width="60%" style="vertical-align: top;" >
                    <?php echo CHtml::value($application, 'account.profile.fullname'); ?><br/>
                    <?php if ($mode !== 'pdf-name-only'): ?>
                        <?php echo nl2br(CHtml::value($application, 'account.profile.replyAddress')); ?>
                    <?php endif; ?>
                </td> 
            </tr>
        </table>
    </body>
</html>