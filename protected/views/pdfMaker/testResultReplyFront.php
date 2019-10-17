<html>
    <head> 
        <style type="text/css">
            body , table {font-family: 'TH SarabunPSK', thsarabun;font-size: 22px;}
        </style>
    </head>
    <body>
        <table width="100%" style="margin-left:0.9cm;margin-right:0.5cm;table-layout: fixed;" cellspacing="0" cellpadding="0">
            <tr>
                <th align="left" style="vertical-align: top;" width="12%">Name</th>
                <td style="vertical-align: top;">: <?php echo CHtml::value($application, 'fullnameEn'); ?></td>
                <th align="right" style="vertical-align: top;padding-right: 5px;" width="11%">ID No.</th>
                <td style="vertical-align: top;" width="25%"> :  <?php echo CHtml::value($application, 'account.entryCode'); ?></td>
            </tr>
            <tr>
                <th align="left" style="vertical-align: top;" width="12%">Agency</th>
                <td style="vertical-align: top;" colspan="3">: 
                    <?php echo strtoupper(CHtml::value($application, 'office', CHtml::value($application, 'department'))); ?>
                </td>
            </tr>
            <tr>
                <th align="left" style="vertical-align: top;" width="10%">Test Code</th>
                <td style="vertical-align: top;">: <?php echo CHtml::value($application, 'examSchedule.examType.name'); ?></td>
                <th align="right" style="vertical-align: top;padding-right: 5px;" width="11%">Test Date</th>
                <td style="vertical-align: top;" width="25%"> : <?php echo CHtml::value($application, 'examSchedule.db_date') ? strtoupper(Yii::app()->format->formatDate(CHtml::value($application, 'examSchedule.db_date'))) : ''; ?></td>
            </tr>
            <tr>
                <th align="left" style="vertical-align: top;" width="12%">Test Name</th>
                <td colspan="3" style="vertical-align: top;">: <?php echo strtoupper('Devawongse Varopakarn Institute of Foreign Affairs Test of English Skills'); ?></td>
            </tr>
        </table>

        <table width="100%" border="1" style="border-collapse: collapse;margin-top:2cm;margin-left:2cm;margin-right:2cm;">
            <tr>
                <?php foreach (CHtml::value($application, 'examSchedule.examScheduleUniqueItems', array()) as $item): ?>
                    <th style="background:rgba(160,160,160,0.3);" width="<?php echo round(100 / count(CHtml::value($application, 'examSchedule.examScheduleUniqueItems'))); ?>%">
                        <?php echo CHtml::value($item, 'examSubject.name_en'); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach (CHtml::value($application, 'examSchedule.examScheduleUniqueItems', array()) as $item): ?>
                    <th style="padding:0.2cm;">
                        <?php echo CHtml::value($application->getExamSetBySubject(CHtml::value($item, 'examSubject.code')), 'grade', '-'); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </table>
        <div align="center"><strong>Remark :</strong> DIFA TES <?php echo count(CHtml::value($application, 'examSchedule.examScheduleUniqueItems')) === 1 ? 'grade is' : 'grades are'; ?> valid for 2 years from the test date.</div>
    </body>
</html>
