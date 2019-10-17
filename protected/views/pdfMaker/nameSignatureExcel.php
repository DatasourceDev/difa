<html>
    <head>
        <style>
            body {font-family:'TH SarabunPSK',  thsarabun;font-size:16pt;}
            td {vertical-align: top; font-size:14pt;}
            th {vertical-align: top; font-size:16pt;}
        </style>
    </head>
    <body>
        <?php
        $this->renderPartial('//shared/docExamScheduleHeader', array(
            'title' => 'ใบเซ็นต์ชื่อผู้เข้ารับการทดสอบวัดระดับความรู้ภาษาอังกฤษ',
            'examSchedule' => $examSchedule,
        ))
        ?>
        <br/>
        <table style="border-collapse: collapse;" width="100%">
            <thead>
                <tr>
                    <th align="center" style="border:1px solid #000000;">เลขที่</th>
                    <th align="center" style="border:1px solid #000000;border-right: 0px;">ชื่อ</th>
                    <th align="left" style="border:1px solid #000000;border-left: 0px;">นามสกุล</th>
                    <th align="center" style="border:1px solid #000000;">กระทรวง</th>
                    <th align="center" style="border:1px solid #000000;">หน่วยงาน</th>
                    <th align="center" style="border:1px solid #000000;">เบอร์โทรศัพท์</th>
                    <th align="center" style="border:1px solid #000000;">ลายมือชื่อ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examSchedule->validExamApplications as $application): ?>
                    <tr>
                        <td width="50" align="center" style="border:1px solid #000000;"><?php echo str_pad(CHtml::value($application, 'desk_no'), 3, '0', STR_PAD_LEFT); ?></td>
                        <td style="border:1px solid #000000;border-right: 0px;"><?php echo CHtml::value($application, 'title_th'); ?><?php echo CHtml::value($application, 'firstname_th'); ?></td>
                        <td style="border:1px solid #000000;border-left: 0px;"><?php echo CHtml::value($application, 'lastname_th'); ?></td>
                        <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'department_th'); ?></td>
                        <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'office_th', '-'); ?></td>
                        <td width="150" align="center" style="border:1px solid #000000;"><?php echo CHtml::value($application, 'account.profile.textContactMobile'); ?></td>
                        <td width="200" align="center" style="border:1px solid #000000;"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody> 
        </table>
    </body>
</html>

