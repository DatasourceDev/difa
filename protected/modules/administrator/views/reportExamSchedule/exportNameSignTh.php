<?php $this->beginContent('/report/_pdf') ?>
<h1 class="text-center">ใบเซ็นชื่อผู้สมัครสอบ</h1>
<table class="detail-view" style="margin-bottom: 15px;">
    <tr>
        <th>รหัสรอบสอบ</th>
        <td><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
        <th>วันที่สอบ</th>
        <td><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')); ?></td>
    </tr>
    <tr>
        <th>ประเภทการสอบ</th>
        <td><?php echo CHtml::value($model, 'examSchedule.examType.name'); ?></td>
        <th>เวลาสอบ</th>
        <td><?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_start')); ?> - <?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_end')); ?></td>
    </tr>
    <tr>
        <th>ทักษะที่สอบ</th>
        <td><?php echo CHtml::value($model, 'examSubject.name'); ?></td>
        <th>สถานที่</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_name'); ?></td>
    </tr>
    <tr>
        <th>หัวข้อ</th>
        <td><?php echo CHtml::value($model, 'examSet.examSubjectTopic.name'); ?></td>
        <th>ชั้น/ห้อง</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_remark'); ?></td>        
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th style="border:1px solid #000000;" width="50">ลำดับ</th>
            <th style="border:1px solid #000000;" colspan="2">ชื่อ-นามสกุล</th>
            <th style="border:1px solid #000000;" width="200">Ministry</th>
            <th style="border:1px solid #000000;" width="200">กระทรวง</th>
            <th style="border:1px solid #000000;" width="200">Department</th>
            <th style="border:1px solid #000000;" width="200">หน่วยงาน</th>
            <th style="border:1px solid #000000;" width="100">เบอร์โทรศัพท์</th>
            <th style="border:1px solid #000000;" width="80">ลายมือชื่อ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $count => $application): ?>
            <tr>
                <td style="border:1px solid #000000;" class="text-center"><?php echo $count + 1; ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'title_th'); ?><?php echo CHtml::value($application, 'firstname_th'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'lastname_th'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'department'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'department_th'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'office', '-'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'office_th', '-'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'account.profile.textContactMobile'); ?></td>
                <td style="border:1px solid #000000;"></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endContent(); ?>