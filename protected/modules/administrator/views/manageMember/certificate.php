<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<div class="grid-view">
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th class="text-center" rowspan="2" style="vertical-align: middle;"><?php echo Helper::t('Examination Type', 'ประเภทการสอบ'); ?></th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;"><?php echo Helper::t('Date', 'วันที่'); ?></th>
                <th class="text-center" colspan="4"><?php echo Helper::t('Result', 'ผลการสอบ'); ?></th>
                <th class="text-center" rowspan="2"><?php echo Helper::t('Remark', 'หมายเหตุ'); ?></th>
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
                <tr class="<?php echo isset($data->presentPreventSchedule) ? "bg-danger" : ""; ?>">
                    <td class="text-center"><?php echo CHtml::value($data, 'examSchedule.examType.name'); ?></td>
                    <td class="text-center"><?php echo Yii::app()->format->formatDate(CHtml::value($data, "examSchedule.db_date")); ?></td>
                    <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($data->getExamSetBySubject('R'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($data->getExamSetBySubject('R'), 'exam_set_id'); ?></small></td>
                    <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($data->getExamSetBySubject('L'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($data->getExamSetBySubject('L'), 'exam_set_id'); ?></small></td>
                    <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($data->getExamSetBySubject('W'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($data->getExamSetBySubject('W'), 'exam_set_id'); ?></small></td>
                    <td class="text-center"><span class="text-blue text-bold"><?php echo CHtml::value($data->getExamSetBySubject('S'), 'grade', '<span class="text-muted">-</span>'); ?></span><br/><small class="text-muted-darker"><?php echo CHtml::value($data->getExamSetBySubject('S'), 'exam_set_id'); ?></small></td>
                    <td class="text-center">
                        <?php if (isset($data->presentPreventSchedule)): ?>
                            <?php echo Helper::htmlSignWarning('ไม่สามารถลงทะเบียนเข้าสอบได้เนื่องจาก ได้ลงทะเบียนสอบในรอบ ' . $data->presentPreventSchedule->textExamCode . ' แล้ว'); ?>
                        <?php endif; ?>
                        <?php echo CHtml::value($data, 'htmlRemark'); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->endContent(); ?>