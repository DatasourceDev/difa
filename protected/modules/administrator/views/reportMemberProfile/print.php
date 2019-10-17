<html>
    <head>
        <style>
            body {font-family:'TH SarabunPSK',  thsarabun;font-size:14pt;}
            .text-center {text-align: center;}
        </style>
    </head>
    <body>
        <h3>ประวัติการสอบรายบุคคล</h3>
        <table width="100%">
            <tr>
                <th align="right" width="30%">เลขบัตรประชาชน/ID</th>
                <td><?php echo CHtml::value($account, 'username'); ?></td>
            </tr>
            <tr>
                <th align="right">Name</th>
                <td><?php echo CHtml::value($account, 'profile.fullnameEn'); ?></td>
            </tr>
            <tr>
                <th align="right">ชื่อ-นามสกุล</th>
                <td><?php echo CHtml::value($account, 'profile.fullnameTh'); ?></td>
            </tr>
            <tr>
                <th align="right">ประเภทสมาชิก</th>
                <td><?php echo CHtml::value($account, 'accountType.name_th'); ?></td>
            </tr>
            <tr>
                <th align="right">หน่วยงาน</th>
                <td><?php echo CHtml::value($account, 'profile.textDepartment'); ?></td>
            </tr>
        </table>

        <h3>ประวัติการสอบ</h3>
        <table width="100%" border="1" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th rowspan="2">วันที่สอบ</th>
                    <th rowspan="2">ประเภทการสอบ</th>
                    <th rowspan="2">หน่วยงาน</th>
                    <th colspan="4">ผลการสอบ</th>
                </tr>
                <tr>
                    <th>R</th>
                    <th>L</th>
                    <th>W</th>
                    <th>S</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($account->examApplications)): ?>
                    <?php foreach ($account->examApplications as $application): ?>
                        <?php /* @var $application ExamApplication */ ?>
                        <tr>
                            <td class="text-center"><?php echo Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date')); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'examSchedule.examType.name'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'department'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application->getGradeBySubject('R'), 'grade'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application->getGradeBySubject('L'), 'grade'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application->getGradeBySubject('W'), 'grade'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application->getGradeBySubject('S'), 'grade'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr> 
                        <td class="text-center" colspan="7">--ยังไม่เคยสมัครสอบใดๆ--</td> 
                    </tr> 
                <?php endif; ?>
            </tbody>
        </table>
    </body>
</html>