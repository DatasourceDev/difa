<?php $this->beginContent('/report/_pdf') ?>
<h1 class="text-center">ใบรายชื่อผู้สมัครสอบ</h1>
<table class="detail-view" style="margin-bottom: 15px;">
    <tr>
        <th style="vertical-align: top;">รหัสรอบสอบ</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
        <th style="vertical-align: top;">วันที่สอบ</th>
        <td style="vertical-align: top;"><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')); ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">ประเภทการสอบ</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.examType.name'); ?></td>
        <th style="vertical-align: top;">เวลาสอบ</th>
        <td style="vertical-align: top;"><?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_start')); ?> - <?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_end')); ?></td>
    </tr>
    <tr  style="vertical-align: top;">
        <th style="vertical-align: top;">ทักษะที่สอบ</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSubject.name'); ?></td>
        <th style="vertical-align: top;">สถานที่</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.place_name'); ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">หัวข้อ</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSet.examSubjectTopic.name'); ?></td>
        <th style="vertical-align: top;">ชั้น/ห้อง</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.place_remark'); ?></td>        
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th style="border:1px solid #000000;" width="50">ลำดับ</th>
            <th style="border:1px solid #000000;" colspan="3">ชื่อ-นามสกุล</th>
            <th style="border:1px solid #000000;" width="200">หน่วยงาน</th>
            <th style="border:1px solid #000000;" width="80">หมายเหตุ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $count => $application): ?>
            <tr>
                <td style="border:1px solid #000000;" class="text-center"><?php echo $count + 1; ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'title_th'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'firstname_th'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'lastname_th'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'department_th'); ?><br/><small><?php echo CHtml::value($application, 'office_th', '-'); ?></small></td>
                <td style="border:1px solid #000000;"></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endContent(); ?>