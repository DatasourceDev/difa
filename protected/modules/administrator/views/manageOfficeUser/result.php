<?php $this->beginContent('_layout', array('model' => $account)); ?>
<div class="text-small">
    <div class="grid-view">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2" style="vertical-align: middle;"><?php echo Helper::t('Name Type', 'ชื่อ-สกุล'); ?></th>
                    <th class="text-center" rowspan="2" style="vertical-align: middle;"><?php echo Helper::t('Date', 'วันที่'); ?></th>
                    <th class="text-center" colspan="4"><?php echo Helper::t('Result', 'ผลการสอบ'); ?></th>
                </tr>
                <tr>
                    <th class="text-center"><?php echo Helper::t('Reading', 'ทักษะการอ่าน'); ?></th>
                    <th class="text-center"><?php echo Helper::t('Listening', 'ทักษะการฟัง'); ?></th>
                    <th class="text-center"><?php echo Helper::t('Writing', 'ทักษะการเขียน'); ?></th>
                    <th class="text-center"><?php echo Helper::t('Speaking', 'ทักษะการพูด'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->data as $data): ?>
                    <tr>
                        <td><?php echo CHtml::value($data, 'account.profile.fullname'); ?></td>
                        <td class="text-center"><?php echo Yii::app()->format->formatDate(CHtml::value($data, "examSchedule.db_date")); ?></td>
                        <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('R'), 'grade', '<span class="text-muted">-</span>'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('L'), 'grade', '<span class="text-muted">-</span>'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('W'), 'grade', '<span class="text-muted">-</span>'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('S'), 'grade', '<span class="text-muted">-</span>'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endContent(); ?>