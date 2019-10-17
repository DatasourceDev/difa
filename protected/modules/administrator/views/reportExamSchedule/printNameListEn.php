<?php $this->beginContent('/report/_pdf') ?>
<h1 class="text-center">List of examination attendee</h1>
<table class="detail-view" style="margin-bottom: 15px;">
    <tr>
        <th style="vertical-align: top;">Examination ID</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
        <th style="vertical-align: top;">Date</th>
        <td style="vertical-align: top;"><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')); ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Examination Type</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.examType.name'); ?></td>
        <th style="vertical-align: top;">Time</th>
        <td style="vertical-align: top;"><?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_start')); ?> - <?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_end')); ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Skill</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSubject.name_en'); ?></td>
        <th style="vertical-align: top;">Place</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.place_name_en'); ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top;">Subject</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSet.examSubjectTopic.name'); ?></td>
        <th style="vertical-align: top;">Floor/Room</th>
        <td style="vertical-align: top;"><?php echo CHtml::value($model, 'examSchedule.place_remark_en'); ?></td>        
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th style="border:1px solid #000000;" width="50">No.</th>
            <th style="border:1px solid #000000;" colspan="3">Name-Surname</th>
            <th style="border:1px solid #000000;" width="200">Department</th>
            <th style="border:1px solid #000000;" width="80">Remark</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $count => $application): ?>
            <tr>
                <td style="border:1px solid #000000;" class="text-center"><?php echo $count + 1; ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'title_en'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'firstname_en'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'lastname_en'); ?></td>
                <td style="border:1px solid #000000;"class="text-center"><?php echo CHtml::value($application, 'department'); ?><br/><small><?php echo CHtml::value($application, 'office', '-'); ?></small></td>
                <td style="border:1px solid #000000;"></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endContent(); ?>