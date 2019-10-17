
<html>
<head>
   <style>
      body {
         font-family: 'TH SarabunPSK', thsarabun;
         font-size: 16pt;
      }
      table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
      }
      td {
         vertical-align: top;
         padding-left: 5px;
         padding-right: 5px;

      }

      th {
         vertical-align: top;
         padding-left: 5px;
         padding-right: 5px;
      }

   </style>
</head>
<body>
   <?php
   $this->renderPartial('//shared/docExamScheduleHeader', array(
       'title' => 'รายชื่อผู้เข้ารับการทดสอบวัดระดับความรู้ภาษาอังกฤษ',
       'examSchedule' => $examSchedule,
   ))
   ?>
   <br />
   <table width="100%">
      <thead>
         <tr>
            <th align="center">เลขที่</th>
            <th align="center" colspan="2">ชื่อ-นามสกุล</th>
            <th align="center">หน่วยงาน</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($examSchedule->validExamApplications as $application): ?>
         <tr>
            <td align="center">
               <?php echo str_pad(CHtml::value($application, 'desk_no'), 3, '0', STR_PAD_LEFT); ?>
            </td>
            <td style="border-right:none;">
               <?php echo CHtml::value($application, 'title_en'); ?><?php echo CHtml::value($application, 'firstname_en'); ?>
            </td>
            <td style="border-left:none;">
               <?php echo CHtml::value($application, 'lastname_en'); ?>
            </td>
            <td>
               <?php echo CHtml::value($application, 'department'); ?>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</body>
</html>

