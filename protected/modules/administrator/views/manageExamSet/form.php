<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลชุดข้อสอบ',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'id'),
        ));
?>
<div class="form-group">
    <label class="col-sm-3 control-label">รหัสชุดสอบ</label>
    <div class="col-sm-9">
        <h4 id="ExamSet_id" class="fancy"><?php echo CHtml::value($model, 'previewId'); ?></h4>
    </div>
</div>
<?php
echo $form->dropDownListGroup($model, 'exam_type_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->scopeActive()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'class' => 'form-change-update',
            'data-update' => '#ExamSet_id, #ExamSet_exam_subject_id, #ExamSet_exam_topic_code, #ExamSet_exam_num',
            'prompt' => '(เลือกประเภทการสอบ)',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_subject_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->findAllByAttributes(array(
                    'exam_type_id' => $model->exam_type_id,
                )), 'id', 'textName'),
        'htmlOptions' => array(
            'class' => 'form-change-update',
            'data-update' => '#ExamSet_id, #ExamSet_exam_topic_code, #ExamSet_exam_num',
            'prompt' => '(เลือกทักษะในการสอบ)',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_topic_code', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubjectTopic::model()->findAllByAttributes(array(
                    'exam_subject_id' => $model->exam_subject_id,
                )), 'exam_topic_code', 'textName'),
        'htmlOptions' => array(
            'class' => 'form-change-update',
            'data-update' => '#ExamSet_id, #ExamSet_exam_num',
            'prompt' => '(เลือกหัวข้อในการสอบ)',
        ),
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'exam_year', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'class' => 'form-change-update',
            'data-update' => '#ExamSet_id, #ExamSet_exam_num',
        ),
    ),
    'append' => 'ตัวเลข 2 หลัก',
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_num', array(
    'widgetOptions' => array(
        'data' => $model->getAvailableExamNumItems(),
        'htmlOptions' => array(
            'class' => 'form-change-update',
            'data-update' => '#ExamSet_id',
            'prompt' => 'เลือกเลขที่ชุดสอบ',
        ),
    ),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'is_grade_set', array(
    'widgetOptions' => array(
        'data' => ExamSet::getIsGradeSetOptions(),
    ),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.form-change-update', function () {
            var frm = $(this).closest('form');
            var updateElements = $($(this).data('update'));
            $(updateElements).each(function (i, e) {
                $(e).prop('disabled', true);
            });
            $.get($(frm).attr('action'), $(frm).serialize(), function (data) {
                $(updateElements).each(function (i, e) {
                    $(e).html($('#' + $(e).attr('id'), data).html());
                    $(e).prop('disabled', false);
                });
            });
        });
    });
</script>