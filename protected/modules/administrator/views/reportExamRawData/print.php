<html>
    <head>
        <style>
            body {font-family: 'TH SarabunPSK', thsarabun;font-size:10pt;}
            h1 {font-size:18pt;}
            h2 {font-size:16pt;}
            .text-center {text-align: center;}
            td, th {border-collapse: collapse;padding:1mm 2mm;}
        </style>
    </head>
    <body>

        <?php foreach ($schedule->examScheduleItems as $sheetId => $subject): ?>
            <h1 class="text-center">ข้อมูลการทำข้อสอบ <?php echo CHtml::value($schedule, 'exam_code'); ?></h1>
            <h2 class="text-center"><?php echo CHtml::value($subject, 'examSubject.name'); ?> (<?php echo CHtml::value($subject, 'examSubject.name_en'); ?>)</h2>
            <?php
            $criteria = new CDbCriteria();
            $criteria->compare('exam_schedule_id', $schedule->id);
            $criteria->compare('exam_subject_id', $subject->exam_subject_id);
            $criteria->group = 'exam_set_id';
            $examSets = ExamApplicationExamSet::model()->findAll($criteria);
            ?>
            <?php foreach ($examSets as $coreExamSet) : ?>
                <?php
                $countItem = 0;
                ?>
                <h3 class="text-center"><?php echo CHtml::value($coreExamSet, 'exam_set_id'); ?></h3>
                <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เลขที่นั่งสอบ</th>
                            <?php foreach ($coreExamSet->examSet->examSetTasks as $task) : ?>
                                <th <?php echo in_array($task->exam_question_method_id, array(1, 2, 3, 4)) ? 'colspan="' . $task->task_num . '"' : ''; ?>><?php echo CHtml::value($task, 'task_no') . '.' . CHtml::value($task, 'examQuestionMethod.name'); ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <?php foreach ($coreExamSet->examSet->examSetTasks as $task) : ?>
                                <?php if (in_array($task->exam_question_method_id, array(1, 2, 3, 4))): ?>
                                    <?php for ($i = 0; $i < $task->task_num; $i++): ?>
                                        <th><?php echo $countItem + 1; ?></th>
                                        <?php $countItem++; ?>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <th><?php echo $countItem + 1; ?></th>
                                    <?php $countItem++; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $appCount = 0; ?>
                        <?php foreach ($applications as $rowCount => $application): ?>
                            <?php
                            $examSet = ExamApplicationExamSet::model()->findByAttributes(array(
                                'exam_application_id' => $application->id,
                                'exam_schedule_id' => $schedule->id,
                                'exam_subject_id' => $subject->exam_subject_id,
                            ));
                            if ($examSet->exam_set_id <> $coreExamSet->exam_set_id) {
                                continue;
                            } else {
                                $appCount++;
                            }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $appCount; ?></td>
                                <td><?php echo CHtml::value($application, 'fullname_th'); ?></td>
                                <td class="text-center"><?php echo CHtml::value($application, 'desk_no'); ?></td>
                                <?php
                                $countItem = 0;
                                $raw = $examSet->raw_data;
                                ?>
                                <?php foreach ($coreExamSet->examSet->examSetTasks as $task): ?>
                                    <?php if (in_array($task->exam_question_method_id, array(1, 2, 3, 4))): ?>
                                        <?php for ($i = 0; $i < $task->task_num; $i++): ?>
                                            <td class="text-center"><?php echo strlen($raw) > ($i) ? $raw{$i} : '-'; ?></td>
                                            <?php $countItem++; ?>
                                        <?php endfor; ?>
                                        <?php $raw = substr($raw, ($task->task_num)); ?>
                                    <?php elseif (in_array($task->exam_question_method_id, array(5))): ?>
                                        <td class="text-center"><?php echo (int) ($raw{0} . $raw{1}); ?></td>
                                    <?php else: ?>
                                        <td class="text-center"><?php echo $raw{0}; ?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php foreach ($coreExamSet->examSet->examSetTasks as $task) : ?>
                <?php endforeach; ?>
                <?php foreach ($applications as $rowCount => $application) : ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <pagebreak />
    <?php endforeach; ?>
</body>
</html>