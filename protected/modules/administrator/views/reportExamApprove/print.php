 <table border="1" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th>รายงานการตรวจข้อสอบ</th>
    </tr>
    <tr>
        <td colspan="2">รอบสอบ</td>
        <td><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
    </tr>
    <tr>
        <td colspan="2">ชื่อผู้ตรวจ</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">จำนวนผู้เข้าสอบ</td>
        <td><?php echo Yii::app()->format->formatNumber(CHtml::value($model, 'examSchedule.countValidAttendee', 0)); ?> คน</td>
    </tr>
    <tr>
        <td colspan="2">จำนวนการตรวจข้อสอบ</td>
        <td><?php echo Yii::app()->format->formatNumber(CHtml::value($model, 'examSchedule.countExamSetTaskItemByApplication', 0)); ?></td>
    </tr>
    <tr>
        <td>เลขที่สอบ</td>
        <td colspan="2">ชื่อ-นามสกุล</td>
        <td>หน่วยงาน</td>
        <?php foreach ($model->examSchedule->examScheduleUniqueItems as $subject): ?>
            <td><?php echo CHtml::value($subject, 'examSubject.code'); ?></td>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($model->examSchedule->examApplications(array('scopes' => array('scopeValid'))) as $row): ?>
        <tr>
            <td><?php echo CHtml::value($row, 'deskNo'); ?></td>
            <td><?php echo CHtml::value($row, 'title_th'); ?><?php echo CHtml::value($row, 'firstname_th'); ?></td>
            <td><?php echo CHtml::value($row, 'lastname_th'); ?></td>
            <td><?php echo CHtml::value($row, 'department_th'); ?></td>
            <?php foreach ($model->examSchedule->examScheduleUniqueItems as $subject): ?>
                <td><?php echo CHtml::value($row->getExamSetBySubject($subject->examSubject->code), 'grade', '-'); ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>