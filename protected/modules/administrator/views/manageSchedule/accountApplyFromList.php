<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
echo $form->select2Group($application, 'account_id', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => 'ค้นหาจาก ชื่อ / ชื่อบัญชี / หน่วยงาน / ตำแหน่ง / ระดับ',
        ),
        'asDropDownList' => false,
        'options' => array(
            'ajax' => array(
                'url' => $this->createUrl('shareSelect2/listAccount'),
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
                    $.ajax("' . $this->createUrl('shareSelect2/listAccount') . '?id=" + id, {
                        dataType: "json"
                    }).done(function(data) { 
                        callback(data); 
                    });
                }
            }',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ผู้สมัคร',
    ),
));
?>
<div class='form-group'>
    <label class="control-label col-sm-3">รอบสอบ</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($application, 'examSchedule.exam_code'); ?>
        </div>
    </div>
</div>
<div class='form-group'>
    <label class="control-label col-sm-3">ทักษะ</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($application, 'examSchedule.textSkill'); ?>
        </div>
    </div>
</div>
<div class='form-group'>
    <label class="control-label col-sm-3">วันที่</label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo Yii::app()->format->formatDateText(CHtml::value($application, 'examSchedule.db_date')); ?>
        </div>
    </div>
</div>
<?php
echo $form->radioButtonListGroup($application, 'exam_schedule_objective_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamScheduleObjective::model()->findAllByAttributes(array(
                    'exam_schedule_id' => $examSchedule->id,
                )), 'id', 'name_th'),
    ),
));
?>
<?php echo $form->errorSummary($application); ?>
<div class='form-group well well-sm'>
    <div class='col-sm-9 col-sm-offset-3'>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ย้อนกลับ',
            'icon' => 'arrow-left',
            'buttonType' => 'link',
            'url' => array('view', 'id' => $examSchedule->id),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'สมัครสอบ',
            'icon' => 'pencil',
            'context' => 'success',
            'buttonType' => 'submit',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>