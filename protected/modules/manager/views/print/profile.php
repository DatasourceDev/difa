<html>
    <head>
        <style>
            body {font-family:'TH SarabunPSK',  thsarabun;font-size:14pt;}
            .text-center {text-align: center;}
        </style>
    </head>
    <body>
        <h3>ประวัติการสอบสำหรับจัดชุดข้อสอบ</h3>
        <table width="100%">
            <tr>
                <th align="right" width="30%">เลขบัตรประชาชน/ID</th>
                <td><?php echo CHtml::value($account, 'username'); ?></td>
            </tr>
            <tr>
                <th align="right">Fullname</th>
                <td><?php echo CHtml::value($account, 'profile.fullnameEn'); ?></td>
            </tr>
            <tr>
                <th align="right">ชื่อ-นามสกุล</th>
                <td><?php echo CHtml::value($account, 'profile.fullnameTh'); ?></td>
            </tr>
            <tr>
                <th align="right">ประเภทบัญชี</th>
                <td><?php echo CHtml::value($account, 'accountType.name_th'); ?></td>
            </tr>
        </table>

        <h3>ประวัติการสอบ</h3>
        <table width="100%" border="1" style="border-collapse: collapse;">
            <tr>
                <th>วันที่สอบ</th>
                <th>ประเภทการสอบ</th>
                <th>ทักษะที่สอบ</th>
                <th>ชุดข้อสอบที่ใช้</th>
                <th>ผลการสอบ</th>
            </tr>
            <?php if (count($account->examApplications)): ?>
                <?php foreach ($account->examApplications as $application): ?>
                    <?php foreach ($application->examSchedule->examScheduleItems as $subject): ?>
                        <tr>
                            <td class="text-center"><?php echo Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date')); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'examSchedule.examType.name'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($subject, 'examSubject.textName'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'exam_set_id', CHtml::value($subject, 'exam_set_id')); ?></td>
                            <td class="text-center"><?php echo $application->getGradeByExamSet($application->exam_set_id); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr> 
                    <td class="text-center" colspan="4">--ยังไม่เคยสมัครสอบใดๆ--</td> 
                </tr> 
            <?php endif; ?>
        </table>
    <pagebreak />
</body>
</html>