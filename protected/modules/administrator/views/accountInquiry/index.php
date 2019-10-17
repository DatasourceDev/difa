<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
    'headerIcon' => 'search',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'action' => array('index'),
    'method' => 'get',
        ));
?>
<?php
echo $form->dropDownListGroup($model, 'is_done', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
        'data' => array(
            ActiveRecord::YES => 'ตอบกลับแล้ว',
            ActiveRecord::NO => 'รอดำเนินการ',
        ),
    ),
    'labelOptions' => array(
        'label' => 'สถานะของข้อความ',
    ),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('ค้นหา', array(
            'icon' => 'search',
        ));
        ?>    
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial('/accountInquiry/shared/grid', array(
    'dataProvider' => $dataProvider,
));
?>