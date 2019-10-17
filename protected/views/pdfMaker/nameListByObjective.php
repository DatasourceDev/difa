<html>
    <head>
        <style>
            body {font-family:'TH SarabunPSK',  thsarabun;font-size:16pt;}
            td {vertical-align: top;}
            th {vertical-align: top;}
        </style>
    </head>
    <body>
        <?php
        $this->renderPartial('//shared/docExamScheduleHeader', array(
            'title' => 'รายชื่อผู้เข้าสอบแยกตามวัตถุประสงค์ในการสอบ',
            'examSchedule' => $examSchedule,
        ))
        ?>
        <br/>
        <?php foreach ($examSchedule->examScheduleObjectives as $object): ?>
            <?php
            $applications = ExamApplication::model()->scopeValid()->sortBy('desk_no')->findAllByAttributes(array(
                'exam_schedule_objective_id' => $object->id,
                'exam_schedule_id' => $examSchedule->id,
            ));
            ?>
            <?php if (count($applications)): ?>
                <table border="1" style="table-layout: fixed;border-collapse: collapse;margin-bottom:20px;" width="100%">
                    <caption>
                        <strong><?php echo CHtml::value($object, 'name_th'); ?></strong>
                    </caption>
                    <thead>
                        <tr>
                            <th width="15%" align="center">เลขที่</th>
                            <th width="35%" align="center">ชื่อ-นามสกุล</th>
                            <th width="40%" align="center">หน่วยงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td align="center"><?php echo str_pad(CHtml::value($application, 'desk_no'), 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo CHtml::value($application, 'fullname_th'); ?></td>
                                <td align="center"><?php echo CHtml::value($application, 'department'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody> 
                </table>
            <?php endif; ?>
        <?php endforeach; ?>
    </body>
</html>

