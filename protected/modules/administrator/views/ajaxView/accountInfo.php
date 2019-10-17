<div class="modal-header">
    <h3 class="modal-title">
        <?php echo CHtml::value($model, 'profile.fullname'); ?>
        <small>(<?php echo CHtml::value($model, 'entry_code'); ?>)</small>
    </h3>
</div>
<div class="modal-body">
    <h4 class="fancy">ประวัติการสอบ</h4>
    <div class="grid-view no-padding">
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">วันที่สอบ</th>
                    <th rowspan="2" class="text-center">ประเภทสอบ</th>
                    <th rowspan="2" class="text-center" >รอบสอบ</th>
                    <th rowspan="2" class="text-center">วัตถุประสงค์ในการสอบ</th>
                    <th colspan="4" class="text-center">ทักษะการสอบ</th>
                </tr>
                <tr>
                    <th class="text-center">R</th>
                    <th class="text-center">L</th>
                    <th class="text-center">W</th>
                    <th class="text-center">S</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td class="text-center"><?php echo Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date')); ?></td>
                        <td class="text-center"><?php echo CHtml::value($application, 'examSchedule.examType.name'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($application, 'examSchedule.exam_code'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($application, 'textObjective'); ?></td>
                        <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($application->getExamSetBySubject('R'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($application->getExamSetBySubject('R'), 'exam_set_id'); ?></small></td>
                        <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($application->getExamSetBySubject('L'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($application->getExamSetBySubject('L'), 'exam_set_id'); ?></small></td>
                        <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($application->getExamSetBySubject('W'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($application->getExamSetBySubject('W'), 'exam_set_id'); ?></small></td>
                        <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($application->getExamSetBySubject('S'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($application->getExamSetBySubject('S'), 'exam_set_id'); ?></small></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer"></div>