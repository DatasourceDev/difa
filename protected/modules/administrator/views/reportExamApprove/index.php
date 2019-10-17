<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายงานการตรวจข้อสอบ'); ?>
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
echo $form->dateRangeGroup($model, 'search[exam_date_range]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'class' => 'input-update',
            'placeholder' => '',
            'data-target' => '#ExamApplicationExamSet_exam_schedule_id',
            'data-method' => 'get',
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
echo $form->dropDownListGroup($model, 'search[exam_type_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(เลือกประเภทการสอบ)',
            'class' => 'input-update',
            'data-target' => '#ExamApplicationExamSet_exam_schedule_id, #ExamApplicationExamSet_search_exam_subject_id, #ExamApplicationExamSet_exam_subject_id',
            'data-method' => 'get',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทสอบ',
    ),
));
?>
<?php
echo $form->checkBoxListGroup($model, 'search[exam_subject_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->scopeExamType(CHtml::value($model, 'search.exam_type_id'))->sortBy('exam_type_id, order_no')->findAll(), 'id', 'TextNameWithType'),
        'htmlOptions' => array(
            'class' => 'input-update',
            'prompt' => '(เลือกทักษะในการสอบ)',
            'data-target' => '#ExamApplicationExamSet_exam_schedule_id',
            'data-method' => 'get',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ทักษะที่เลือกสอบ',
    ),
))
?>
<?php
echo $form->dropDownListGroup($model, 'exam_schedule_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSchedule::model()->scopeExamType(CHtml::value($model, 'search.exam_type_id'))->scopeExamSubject(CHtml::value($model, 'search.exam_subject_id'))->scopeDateRange($model->getSearchDateStart(), $model->getSearchDateEnd())->sortBy('exam_code DESC')->findAll(), 'id', 'textExamCode'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
        'required' => false,
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[grade]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => 'ระดับคะแนน',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ระดับคะแนน',
    ),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'search[exam_order_type]', array(
      'widgetOptions' => array(
          'data' => ExamApplicationExamSet::getOrderType(),
      ),
      'labelOptions' => array(
        'label' => 'การเรียงลำดับข้อมูล',
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
<script type="text/javascript">

    $(document).ready(function () {

        $('#ExamApplicationExamSet_search_exam_date_range').on('apply.daterangepicker', function (ev, picker) {
            $(this).trigger('change');
        });

    });

</script>