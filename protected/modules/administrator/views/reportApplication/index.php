<?php echo Helper::htmlTopic('ระบบรายงาน', 'สถิติการสอบ'); ?>
<?php $this->beginContent('/layouts/wrapper/searchBox'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'action' => array('index'),
    'method' => 'get',
        ));
?>
<?php
echo $form->dateRangeGroup($model, 'search[exam_date_range]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
        'options' => array(
            'format' => 'YYYY-MM-DD',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ระหว่างวันที่',
    ),
    'append' => Helper::glyphicon('calendar'),
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_type_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'class' => 'input-update',
            'prompt' => '(ทั้งหมด)',
            'data-target' => '#ExamApplication_search_exam_subject_id, #ExamApplication_search_exam_objective_id',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทสอบ',
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_subject_id]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->findAllByAttributes(array(
                    'exam_type_id' => CHtml::value($model, 'search.exam_type_id'),
                )), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ทักษะการสอบ',
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'search[exam_objective]', array(
    'labelOptions' => array(
        'label' => 'วัตถุประสงค์การสอบ',
    ),
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamScheduleObjective::model()->sortBy('name_th')->findAll(array(
                    'distinct' => 'name_th',
                )), 'name_th', 'name_th'),
        'htmlOptions' => array(
            'prompt' => '(ทั้งหมด)',
        ),
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[firstname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชื่อ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[lastname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'นามสกุล',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[department]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'หน่วยงานระดับกระทรวง',
    ),
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
            'label' => 'ส่งออกไฟล์ XLS',
            'icon' => 'print',
            'context' => 'success',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'id' => 'btn-export',
                'name' => 'mode',
                'value' => 'print',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'columns' => array_merge(ExamApplication::getDefaultGridViewColumns(), ExamApplication::getPaymentGridViewColumns(), array(
        array(
            'header' => 'หมายเหตุ',
            'name' => 'htmlRemarkDepartment',
            'type' => 'raw',
        ),
    )),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-export').submit(function () {
            var items = $('.grid-view').yiiGridView('getSelection');
            if (items.length) {
                $('#items', this).val(items);
                return true;
            } else {
                alert('กรุณาเลือกรายการที่ต้องการพิมพ์');
                return false;
            }

        });
    });
</script>