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
    <htmlpageheader name="myHeader">
        <div class="text-center"><small>-{PAGENO}-</small></div>
    </htmlpageheader>
    <sethtmlpageheader name="myHeader" value="on"/>
    <div class="text-center">
        <h3>รายงานรายจ่าย</h3>
        <?php if (isset($model->expenditure_type_id)): ?>
            <h4><?php echo CHtml::value($model, 'expenditureType.name'); ?></h4>
        <?php endif; ?>
        <h4>ตั้งแต่วันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_start); ?></span> ถึง <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_end); ?></span></h4>
    </div>
    <div class="grid-view">
        <table width="100%" border="1" class="table table-condensed table-bordered" autosize="2">
            <thead>
                <tr>
                    <th class="text-center"  rowspan="<?php echo count($expenditureTypes) > 1 ? '2' : '1'; ?>">วันที่</th>
                    <?php if (count($expenditureTypes) > 1): ?>
                        <th class="text-center" colspan="<?php echo count($expenditureTypes); ?>">ประเภทรายจ่าย</th>
                    <?php endif; ?>
                    <th class="text-center"  rowspan="<?php echo count($expenditureTypes) > 1 ? '2' : '1'; ?>">จำนวนเงินรวม</th>
                </tr>
                <tr>
                    <?php foreach ($expenditureTypes as $expenditureType) : ?>
                        <th text-rotate="90" class="text-center"><?php echo CHtml::value($expenditureType, 'name'); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $current_date = $model->date_start;
                ?>
                <?php while ($current_date <= $model->date_end): ?>
                    <?php if (isset($reportData[$current_date])): ?>
                        <tr>
                            <td class="text-center"><?php echo Yii::app()->format->formatDate($current_date); ?></td>
                            <?php foreach ($expenditureTypes as $expenditureType) : ?>
                                <td class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.' . $expenditureType->id . '.amount')); ?></td>
                            <?php endforeach; ?>
                            <th class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.summary.amount')); ?></th>
                        </tr>
                    <?php endif; ?>
                    <?php $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date))); ?>
                <?php endwhile; ?>
                <tr>
                    <th class="text-right">รวม</th>
                    <?php foreach ($expenditureTypes as $expenditureType) : ?>
                        <th class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($reportData, 'categories.' . $expenditureType->id . '.amount')); ?></th>
                    <?php endforeach; ?>
                    <th class="text-right"><?php echo Yii::app()->format->formatMoney(CHtml::value($summary, 'amount')); ?></th>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

