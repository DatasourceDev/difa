<html>
    <head>
        <style>
            body {font-family: 'TH SarabunPSK', thsarabun;font-size:16pt;}
        </style>
    </head>
    <body>
        <?php
        $this->renderPartial('//shared/docExamScheduleHeader', array(
            'title' => 'รายงานสถานะการชำระเงิน',
            'examSchedule' => $examSchedule,
        ))
        ?>
        <br/>
        <table border="1" style="border-collapse: collapse;" width="100%">
            <thead>
                <tr>
                    <th align="center">เลขที่</th>
                    <th align="center">ชื่อ-นามสกุล</th>
                    <th align="center">สถานะการชำระเงิน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examSchedule->validExamApplications as $application): ?>
                    <tr>
                        <td align="center"><?php echo str_pad(CHtml::value($application, 'desk_no'), 3, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo CHtml::value($application, 'fullname_th'); ?></td>
                        <td align="center" width="150">
                            <?php
                            switch (CHtml::value($application, 'is_paid')) {
                                case '0':
                                    echo 'ยังไม่ชำระ';
                                    break;
                                case '1':
                                    echo 'ชำระแล้ว';
                                    break;
                                case '-1':
                                    echo 'เกินกำหนดชำระ';
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody> 
        </table>
    </body>
</html>

