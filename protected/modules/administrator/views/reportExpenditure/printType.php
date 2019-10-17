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
    <htmlpageheader name="myHeader">
        <div class="text-center"><small>-{PAGENO}-</small></div>
    </htmlpageheader>
    <sethtmlpageheader name="myHeader" value="on"/>
    <div class="text-center">
        <h3>รายงานรายจ่าย</h3>
        <h4><?php echo CHtml::value($model, 'expenditureType.name'); ?></h4>
        <h4>ตั้งแต่วันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_start); ?></span> ถึง <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_end); ?></span></h4>
    </div>
    <div class="grid-view">
        <table width="100%" border="1" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th class="text-center">วันที่</th>
                    <th class="text-center">จำนวนเงินรวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $current_date = $model->date_start;
                ?>
                <?php while ($current_date <= $model->date_end): ?>
                    <?php if (isset($reportData[$current_date][$model->expenditure_type_id])): ?>
                        <tr>
                            <td class="text-center"><?php echo Yii::app()->format->formatDate($current_date); ?></td>
                            <?php foreach ($expenditureTypes as $expenditureType) : ?>
                                <td class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.' . $expenditureType->id . '.amount')); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endif; ?>
                    <?php $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date))); ?>
                <?php endwhile; ?>
                <tr>
                    <th class="text-right">รวม</th>
                    <?php foreach ($expenditureTypes as $expenditureType) : ?>
                        <th class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($reportData, 'categories.' . $expenditureType->id . '.amount')); ?></th>
                        <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

