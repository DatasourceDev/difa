<h3 class="fancy text-center"><?php echo CHtml::value($examSubject, 'examType.name'); ?> (<span class="text-success"><?php echo CHtml::value($examSubject, 'code'); ?> : <?php echo CHtml::value($examSubject, 'name'); ?></span>)</h3>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'exam_type_require_id',
            'value' => 'CHtml::value($data,"examTypeRequire.name")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'exam_subject_require_id',
            'value' => 'CHtml::value($data,"examSubjectRequire.textName")',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'minimum_grade',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
        ),
    ),
));
?>
<br/>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลทักษะที่ต้องผ่าน',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($newPrerequisite, 'minimum_grade'),
        ));
?>
<?php
echo $form->dropDownListGroup($newPrerequisite, 'exam_type_require_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'id', 'name'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'class' => 'input-update',
            'data-target' => '#ExamPrerequisite_exam_subject_require_id, #ExamPrerequisite_minimum_grade',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($newPrerequisite, 'exam_subject_require_id', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSubject::model()->findAllByAttributes(array(
                    'exam_type_id' => $newPrerequisite->exam_type_require_id,
                )), 'id', 'textName'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
            'class' => 'input-update',
            'data-target' => '#ExamPrerequisite_minimum_grade',
        ),
    ),
));
?>
<?php
echo $form->dropDownListGroup($newPrerequisite, 'minimum_grade', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamDefaultGrade::model()->sortBy('order_no')->findAllByAttributes(array(
                    'exam_type_id' => $newPrerequisite->exam_type_require_id,
                    'exam_subject_id' => $newPrerequisite->exam_subject_require_id,
                )), 'grade', 'grade'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือก)',
        ),
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
        <?php Helper::buttonBack(array('manageExam/index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>