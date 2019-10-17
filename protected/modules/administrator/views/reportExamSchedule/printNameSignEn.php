<?php $this->beginContent('/report/_pdf') ?>
<h1 class="text-center">Signature of examination attendee</h1>
<table class="detail-view" style="margin-bottom: 15px;">
    <tr>
        <th>Examination ID</th>
        <td><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
        <th>Date</th>
        <td><?php echo Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')); ?></td>
    </tr>
    <tr>
        <th>Examination Type</th>
        <td><?php echo CHtml::value($model, 'examSchedule.examType.name'); ?></td>
        <th>Time</th>
        <td><?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_start')); ?> - <?php echo Yii::app()->format->formatTime(CHtml::value($model, 'time_end')); ?></td>
    </tr>
    <tr>
        <th>Skill</th>
        <td><?php echo CHtml::value($model, 'examSubject.name_en'); ?></td>
        <th>Place</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_name_en'); ?></td>
    </tr>
    <tr>
        <th>Subject</th>
        <td><?php echo CHtml::value($model, 'examSet.examSubjectTopic.name'); ?></td>
        <th>Floor/Room</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_remark_en'); ?></td>        
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th style="border:1px solid #000000;" width="50">No.</th>
            <th style="border:1px solid #000000;" colspan="3">Name-Surname</th>
            <th style="border:1px solid #000000;" width="200">Department</th>
            <th style="border:1px solid #000000;" width="100">Phone</th>
            <th style="border:1px solid #000000;" width="150">Signature</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $count => $application): ?>
            <tr>
               <td width="50" style="border:1px solid #000000;" class="text-center">
                  <?php echo CHtml::value($application, 'deskNo'); ?>
               </td>
               <td style="border-bottom:1px solid #000000;padding-left:10px">
                  <?php echo CHtml::value($application, 'title_en'); ?>
               </td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'firstname_en'); ?></td>
                <td style="border-bottom:1px solid #000000;"><?php echo CHtml::value($application, 'lastname_en'); ?></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'department'); ?><br/><small><?php echo CHtml::value($application, 'office', '-'); ?></small></td>
                <td style="border:1px solid #000000;" class="text-center"><?php echo CHtml::value($application, 'account.profile.textContactMobile'); ?></td>
                <td style="border:1px solid #000000;"></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endContent(); ?>