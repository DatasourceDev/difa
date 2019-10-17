<html>
    <head>
        <style>
            body {font-family: 'TH SarabunPSK', thsarabun;font-size:14pt;}
            table {border-collapse: collapse;}
            h3 {font-size:22pt;margin-bottom:0.5cm;}
            h4 {margin:0px;}
            .text-center {text-align: center;}
            .text-right {text-align: right;}
        </style>
    </head>
    <body>
        <div class="text-center">
            <h3>รายงานสถานะการชำระเงิน</h3>
            <h4><?php echo Helper::prettyDateRangeThai($model->date_start, $model->date_end); ?></h4>
        </div>
        <div class="grid-view">
            <table width="100%" border="1" class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">วันเวลาสอบ</th>
                        <th class="text-center">ประเภทการสอบ</th>
                        <th class="text-center">เลขที่สอบ</th>
                        <th class="text-center">ชื่อ-นามสกุล</th>
                        <th class="text-center">ประเภทการสมัคร</th>
                        <th class="text-center">สถานะการชำระเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->data as $data): ?>
                        <tr>
                            <td class="text-center"><small><?php echo Yii::app()->format->formatDate($data->examSchedule->db_date); ?></small><div><small><?php echo CHtml::value($data, 'examSchedule.firstExamScheduleItem.textTimeRange'); ?></small></div></td>
                            <td class="text-center"><?php echo CHtml::value($data, 'examSchedule.examType.name'); ?><div><small><?php echo CHtml::value($data, 'examSchedule.textSkillCode'); ?></small></div></td>
                            <td class="text-center"><?php echo CHtml::value($data, 'deskNo'); ?></td>
                            <td>
                                <?php echo CHtml::value($data, 'account.profile.fullname'); ?>
                                <div><small><?php echo CHtml::value($data, 'account.entry_code'); ?></small></div>
                            </td>
                            <td class="text-center">
                                <?php echo CHtml::value($data, "htmlApplyType"); ?>
                            </td>
                            <td class="text-center"><?php echo CHtml::value($data, 'textPaymentStatus'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

