<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export',
    'type' => 'horizontal',
    'action' => isset($formOptions['action']) ? $formOptions['action'] : array('print'),
    'method' => isset($formOptions['method']) ? $formOptions['method'] : 'get',
    'htmlOptions' => array(
        'target' => isset($formOptions['htmlOptions']['target']) ? $formOptions['htmlOptions']['target'] : '_blank',
    ),
        ));
?>
<?php
echo $form->select2Group($model, isset($modelOptions['attribute']) ? $modelOptions['attribute'] : 'id', array(
    'labelOptions' => array(
        'label' => 'รอบสอบ'
    ),
    'widgetOptions' => array(
        'htmlOptions' => array(
            'name' => isset($modelOptions['htmlOptions']['name']) ? $modelOptions['htmlOptions']['name'] : 'id',
        ),
        'asDropDownList' => false,
        'options' => array(
            'ajax' => array(
                'url' => $this->createUrl('report/ajaxExamScheduleSearch'),
                'dataType' => 'json',
                'data' => 'js:function(term, page){
                    return {
                        q: term
                    }
                }',
                'results' => 'js:function (data, page) {
                    return { results: data.items };
                }',
            ),
            'initSelection' => 'js:function(element, callback) {
                var id = $(element).val();
                if (id !== "") {
                    $.ajax("' . $this->createUrl('report/ajaxExamScheduleGet') . '?id=" + id, {
                        dataType: "json"
                    }).done(function(data) { 
                        callback(data); 
                    });
                }
            }',
        ),
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => isset($submitButton['label']) ? $submitButton['label'] : 'พิมพ์รายงาน',
            'icon' => isset($submitButton['icon']) ? $submitButton['icon'] : 'print',
            'buttonType' => 'submit',
            'context' => 'info',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>