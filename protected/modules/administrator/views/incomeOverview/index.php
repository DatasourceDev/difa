<?php echo Helper::htmlTopic('ภาพรวมการบันทึกรายรับ'); ?>
<div class="pull-right">
    <?php
    $this->widget('booster.widgets.TbButtonGroup', array(
        'buttons' => array(
            array(
                'icon' => 'chevron-left',
                'url' => array('index', 'year' => $model->year - 1),
                'buttonType' => 'link',
                'context' => 'info',
            ),
            array(
                'label' => $model->year + 543,
                'context' => 'primary',
            ),
            array(
                'icon' => 'chevron-right',
                'url' => array('index', 'year' => $model->year + 1),
                'buttonType' => 'link',
                'context' => 'info',
            ),
        ),
    ));
    ?>
</div>
<h4 class="fancy">สรุปรายรับประจำปี <span class="text-primary"><?php echo $model->year + 543; ?></span></h4>
<?php
$this->widget('ext.highcharts.HighchartsWidget', array(
    'options' => $json,
));
?>
<div class="grid-view">
    <table class="table table-condensed table-bordered table-striped">
        <colgroup>
            <col/>
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <col width="75"/>
            <?php endfor; ?>
            <col width="75"/>
        </colgroup>
        <thead>
            <tr>
                <th></th>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <th class="text-center"><?php echo Yii::app()->format->textMonthShort($i); ?></th>
                <?php endfor; ?>
                <th class="text-center">รวม</th>
            </tr>
        </thead>
        <tfoot class="bg-info">
            <tr>
                <th class="text-right">รวม</th>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <th class="text-right"><?php
                        echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($incomeSummary, 'm' . $i, 0)), array('income/index', 'Income' => array(
                                'search' => array(
                                    'date_start' => Helper::dateFirstOfMonth($i, $model->year),
                                    'date_end' => Helper::dateLastOfMonth($i, $model->year),
                                ),
                        )));
                        ?>
                    </th>
                <?php endfor; ?>
                <th class="text-right"><?php
                    echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($incomeSummary, 'y', 0)), array('income/index', 'Income' => array(
                            'search' => array(
                                'date_start' => Helper::dateFirstOfMonth(1, $model->year),
                                'date_end' => Helper::dateLastOfMonth(12, $model->year),
                            ),
                    )));
                    ?>
                </th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($incomeTypes as $incomeType): ?>
                <tr>
                    <th class="text-right"><?php echo CHtml::value($incomeType, 'name'); ?></th>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <td class="text-right">
                            <?php
                            echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($incomes, $i . '.' . $incomeType->id, 0)), array('income/index', 'Income' => array(
                                    'income_type_id' => CHtml::value($incomeType, 'id'),
                                    'search' => array(
                                        'date_start' => Helper::dateFirstOfMonth($i, $model->year),
                                        'date_end' => Helper::dateLastOfMonth($i, $model->year),
                                    ),
                                )), array('class' => CHtml::value($incomes, $i . '.' . $incomeType->id, 0) == 0 ? 'text-muted' : ''));
                            ?>
                        </td>
                    <?php endfor; ?>
                    <td class="text-right">
                        <?php
                        echo CHtml::link(Yii::app()->format->formatMoney(CHtml::value($incomes, 'y' . '.' . $incomeType->id, 0)), array('income/index', 'Income' => array(
                                'income_type_id' => CHtml::value($incomeType, 'id'),
                                'search' => array(
                                    'date_start' => Helper::dateFirstOfMonth(1, $model->year),
                                    'date_end' => Helper::dateLastOfMonth(12, $model->year),
                                ),
                        )));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>