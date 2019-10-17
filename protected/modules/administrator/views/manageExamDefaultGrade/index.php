<h3 class="fancy text-center"><?php echo CHtml::value($examSubject, 'examType.name'); ?> (<span class="text-success"><?php echo CHtml::value($examSubject, 'code'); ?> : <?php echo CHtml::value($examSubject, 'name'); ?></span>)</h3>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'url' => $this->createUrl('update'),
                'onSave' => 'js: function(e, params) {
                    window.location.reload(false);
                }',
            ),
            'name' => 'order_no',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'grade',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-2',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'url' => $this->createUrl('update'),
            ),
            'name' => 'description',
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
    'title' => 'ข้อมูลการตัดคะแนน',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($newGrade, 'min_score'),
        ));
?>
<?php echo $form->textFieldGroup($newGrade, 'order_no'); ?>
<?php echo $form->textFieldGroup($newGrade, 'grade'); ?>
<?php
echo $form->textAreaGroup($newGrade, 'description', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'rows' => 4,
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