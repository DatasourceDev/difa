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
        <h3 align="center"></h3>
        <table border="1">
            <thead>
                <tr>
                    <th align="center">เลขที่นั่งสอบ</th>
                    <th align="center">รหัสประจำตัว</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th align="center">ทักษะการอ่าน</th>
                    <th align="center">ทักษะการฟัง</th>
                    <th align="center">ทักษะการเขียน</th>
                    <th align="center">ทักษะการพูด</th>
                </tr>
            </thead>
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td align="center"><?php echo str_pad($application->desk_no, 3, "0", STR_PAD_LEFT); ?></td>
                    <td align="center"><?php echo CHtml::value($application, 'account.entry_code'); ?></td>
                    <td><?php echo CHtml::value($application, 'fullnameTh'); ?></td>
                    <td align="center"><?php echo CHtml::value($application->getExamSetBySubject("R"), "exam_set_id", '-'); ?></td>
                    <td align="center"><?php echo CHtml::value($application->getExamSetBySubject("L"), "exam_set_id", '-'); ?></td>
                    <td align="center"><?php echo CHtml::value($application->getExamSetBySubject("W"), "exam_set_id", '-'); ?></td>
                    <td align="center"><?php echo CHtml::value($application->getExamSetBySubject("S"), "exam_set_id", '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>