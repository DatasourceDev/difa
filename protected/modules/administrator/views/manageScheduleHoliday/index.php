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
echo $form->dropDownListGroup($model, 'search[year]', array(
    'widgetOptions' => array(
        'data' => CodeHoliday::getYearList(),
    ),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-8',
    ),
));
?>
<div class="form-group">
    <label class="control-label col-sm-3">
        ค้นหาตามช่วงวัน
    </label>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'search[date_start]', array('id' => 'from', 'class' => 'form-control', 'placeholder' => 'ตั้งแต่วันที่')); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'search[date_end]', array('id' => 'to', 'class' => 'form-control', 'placeholder' => 'ถึงวันที่')); ?>
    </div>
</div>
<?php
echo $form->textFieldGroup($model, 'name_th', array(
    'prepend' => Helper::image('lang_th'),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-8',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'name_en', array(
    'prepend' => Helper::image('lang_en'),
    'wrapperHtmlOptions' => array(
        'class' => 'col-sm-8',
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
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มวันหยุด',
        'context' => 'primary',
        'url' => array('create'),
        'buttonType' => 'link',
    ))
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'id',
            'type' => 'date',
        ),
        array(
            'name' => 'name_th',
        ),
        array(
            'name' => 'name_en',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#from").datepicker({
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>