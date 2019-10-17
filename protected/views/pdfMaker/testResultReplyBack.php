<html>
    <head> 
        <?php if (count($application->currentExamSets) > 2): ?>
            <style type="text/css">
                @page {
                    margin-left:30px;
                    margin-top:0px;
                    margin-header: 0mm;
                    margin-footer: 0mm;
                    marks:none;
                }
                body , table {margin:0;padding:0;font-family: Arial;font-size: 10px;}
                td, th {padding:0px;line-height: 0px;}
                tr.odd {background:#cccccc;}
            </style>
        <?php else: ?>
            <style type="text/css">
                @page {margin-left:30px;}
                body , table {font-size: 15px;font-family: Arial;}
                td, th {padding:0px;}
                tr.odd {background:#cccccc;}
            </style>
        <?php endif; ?>
    </head>
    <body>
        <?php if (count($application->currentExamSets) > 2): ?>
            <div style="font-size:11px;font-weight: bold;">Level Descriptors</div>
            <?php foreach ($application->currentExamSets as $x => $item): ?>
                <table width="100%" style="border-collapse: collapse;border-bottom: 1px solid #000000;<?php echo $x === 0 ? 'border-top: 1px solid #000000;' : ''; ?>">
                    <tr>
                        <th colspan="2" style="border-bottom:1px solid #000000;padding:0;"><b><?php echo CHtml::value($item, 'examSubject.name_en'); ?></b></th>
                    </tr>
                    <?php foreach ($item->examSet->examSetGrades as $count => $grade): ?>
                        <?php if (strtolower($grade->grade) <> 'below b1'): ?>
                            <tr class="<?php echo $count % 2 ? 'odd' : 'even' ?>">
                                <th width="5%" align="left" style="padding-left:10px;font-size: 10px;<?php echo count($item->examSet->examSetGrades) == $count ? 'border-bottom:2px solid #000000;' : '' ?>"><?php echo $grade->grade; ?></th>
                                <td style="padding:1px;line-height:14px;<?php echo count($item->examSet->examSetGrades) == $count ? 'border-bottom:2px solid #000000;' : '' ?>"><?php echo $grade->description; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php else: ?>
            <div><b>Level Descriptors</b></div>
            <?php foreach ($application->currentExamSets as $item): ?>
                <table width="100%" style="border-collapse: collapse;border-bottom: 2px solid #000000;margin-bottom: 25px;margin-top:10px;">
                    <tr>
                        <th colspan="2" style="border-bottom:1px solid #000000;"><b><?php echo CHtml::value($item, 'examSubject.name_en'); ?></b></th>
                    </tr>
                    <?php foreach ($item->examSet->examSetGrades as $count => $grade): ?>
                        <?php if (strtolower($grade->grade) <> 'below b1'): ?>
                            <tr class="<?php echo $count % 2 ? 'even' : 'odd' ?>">
                                <th width="10%" align="left" style="padding-left:10px;font-size: 14px;<?php echo count($item->examSet->examSetGrades) == $count ? 'border-bottom:2px solid #000000;' : '' ?>"><?php echo $grade->grade; ?></th>
                                <td style="padding:2px;<?php echo count($item->examSet->examSetGrades) == $count ? 'border-bottom:2px solid #000000;' : '' ?>"><?php echo $grade->description; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>
