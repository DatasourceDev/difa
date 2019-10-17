<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายงานการชำระเงิน'); ?>
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
echo $form->dateRangeGroup($model, 'search[payment_date_range]', array(
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
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ PDF',
            'icon' => 'file',
            'buttonType' => 'submit',
            'context' => 'danger',
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
            'buttonType' => 'submit',
            'context' => 'success',
            'htmlOptions' => array(
                'name' => 'mode',
                'value' => 'xls',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<div class="text-center">
    <h3>รายงานการชำระเงิน</h3>
    <h4>ตั้งแต่วันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_start); ?></span> ถึง <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_end); ?></span></h4>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array_merge(array(
        array(
            'header' => 'วันที่ชำระเงิน',
            'name' => 'payment_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
            ), ExamApplication::getDefaultGridViewColumns(), array(
        array(
            'header' => 'ค่าธรรมเนียม',
            'value' => 'CHtml::value($data,"examSchedule.register_fee")',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-right',
            ),
        ),
        array(
            'header' => 'เลขที่ใบเสร็จ',
            'value' => 'CHtml::value($data,"receipt") ? CHtml::link(CHtml::value($data,"receipt.doc_name"),array("reportReceipt/print","items" =>  CHtml::value($data,"receipt.id")),array("target" => "_blank")) : ""',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
    )),
));
?>