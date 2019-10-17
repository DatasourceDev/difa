<div class="modal-header">
    <h3 class="modal-title">
        รายได้ ณ วันที่ <?php echo Yii::app()->format->formatDate(CHtml::value($model, 'income_date')) ?>
    </h3>
</div>
<div class="modal-body">
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'name' => 'incomeType.name',
                'footer' => 'รวม',
                'footerHtmlOptions' => array(
                    'class' => 'text-right text-bold',
                ),
            ),
            array(
                'name' => 'amount',
                'type' => 'money',
                'footer' => Yii::app()->format->formatMoney(CHtml::value($summary, 'amount')),
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-right',
                ),
                'footerHtmlOptions' => array(
                    'class' => 'text-right text-bold',
                ),
            ),
            array(
                'name' => 'comment',
            ),
        ),
    ));
    ?>
</div>
<div class="modal-footer"></div>