
<html>
<head>
   <style class="text/css">
      body {
         font-family: 'TH SarabunPSK', thsarabun;
         font-size: 16pt;
      }

      table {
         border-collapse: collapse;
         width: 100%;
         margin-left: 15px;
         margin-right: 15px;
      }

      td {
         padding-left: 5px;
         padding-right: 5px;
         font-size: 13pt;
         vertical-align: top;
      }

      th {
         background-color: #dddddd;
         font-size: 13pt;
      }

      p {
         margin-left: 15px;
         margin-right: 15px;
      }
   </style>
</head>
<body>
   <table border="1">
      <thead>
         <tr>
            <th>วันที่สอบ</th>
            <th>เวลาสอบ</th>
            <th>ทักษะที่สอบ</th>
            <th>สถานที่สอบ</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td align="center">
               <?php echo date('d/m/Y', strtotime(CHtml::value($application, 'examSchedule.db_date', ''))); ?>
            </td>
            <td align="center">
               <?php
               foreach ($application->examSchedule->examScheduleItems as $item) {
                  echo CHtml::value($item, 'textTime', '');
                  echo "<br/>";
               }
               ?>
            </td>
            <td align="center">
               <?php
               foreach ($application->examSchedule->examScheduleItems as $item) {
                  $subject = ExamSubject::model()->findByPk($item->exam_subject_id);
                  if(isset($subject)){
                     echo CHtml::value($subject, 'name_en', '');
                     echo "<br/>";
                  }
               }
               ?>
            </td>
            <td align="center">
               <?php echo CHtml::value($application, 'examSchedule.codePlace.name', ''); ?>
            </td>
         </tr>
      </tbody>
   </table>
   <p>* โปรดแสดงบัตรนี้ต่อเจ้าหน้าที่คุมสอบเพื่อลงทะเบียนหน้าห้องสอบ</p>
</body>
</html>