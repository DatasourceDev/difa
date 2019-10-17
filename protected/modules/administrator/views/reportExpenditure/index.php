<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายงานรายจ่าย'); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<?php
echo $form->dateRangeGroup($model, 'search[date_range]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
        'options' => array(
            'format' => 'YYYY-MM-DD',
        ),
    ),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-5',
    ),
    'labelOptions' => array(
        'label' => 'ช่วงเวลา',
    ),
    'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
));
?>
<?php
echo $form->dropDownListGroup($model, 'expenditure_type_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExpenditureType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'context' => 'primary',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'search',
                'onclick' => 'this.form.target="_self";',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ PDF',
            'icon' => 'file',
            'context' => 'danger',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'pdf',
                'onclick' => 'this.form.target="_blank";',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ XLS',
            'icon' => 'th',
            'context' => 'success',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'xls',
                'onclick' => 'this.form.target="_blank";',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<div class="text-center">
    <h3>รายงานรายจ่าย</h3>
    <h4>ตั้งแต่วันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_start); ?></span> ถึง <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_end); ?></span></h4>
    <?php if ($model->expenditure_type_id): ?>
        <div class="text-center">ประเภท <?php echo CHtml::value($model, 'expenditureType.name'); ?></div>
    <?php endif; ?>
</div>
<div class="grid-view">
    <table width="100%" border="1" class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th class="text-center" rowspan="2">วันที่</th>
                <?php if (count($expenditureTypes)): ?>
                    <th class="text-center" colspan="<?php echo count($expenditureTypes); ?>">ประเภทรายจ่าย</th>
                <?php endif; ?>
                <th class="text-center" rowspan="2">จำนวนเงินรวม</th>
            </tr>
            <?php if (count($expenditureTypes)): ?>
                <tr>
                    <?php foreach ($expenditureTypes as $expenditureType) : ?>
                        <th class="text-center"><?php echo CHtml::value($expenditureType, 'name'); ?></th>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>
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
                            <td class="text-right"><?php echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.' . $expenditureType->id . '.amount')), array('view', 'Expenditure' => array('expenditure_date' => $current_date, 'expenditure_type_id' => $expenditureType->id)), array('class' => 'btn-ajax-modal')); ?></td>
                        <?php endforeach; ?>
                        <th class="text-right"><?php echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($reportData, $current_date . '.summary.amount')), array('view', 'Expenditure' => array('expenditure_date' => $current_date)), array('class' => 'btn-ajax-modal')); ?></th>
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