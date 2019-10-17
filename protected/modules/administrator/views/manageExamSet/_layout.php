<?php

/* @var $model ExamSet */
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ชุดข้อสอบ : ' . CHtml::value($model, 'id'),
    'headerIcon' => 'file',
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'small',
            'buttons' => array(
                array(
                    'label' => 'ย้อนกลับ',
                    'icon' => 'arrow-left',
                    'buttonType' => 'link',
                    'url' => array('manageExamSet/index'),
                ),
            ),
        ),
    ),
));
?>
<?php

$this->widget('booster.widgets.TbMenu', array(
    'encodeLabel' => false,
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => $this->module->getMenuIcon('icon/info') . 'ข้อมูลทั่วไป',
            'url' => array('view', 'id' => $model->id),
            'active' => $this->action->id === 'view',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/task') . 'รายละเอียดข้อสอบ' . ($model->getIsTaskReady() ? Helper::htmlSignSuccess() : Helper::htmlSignFail()),
            'url' => array('viewTask', 'id' => $model->id),
            'active' => $this->action->id === 'viewTask',
        ),
        array(
            'label' => $this->module->getMenuIcon('icon/grade') . 'ระดับการให้คะแนน' . ($model->getIsGradeReady() ? Helper::htmlSignSuccess() : Helper::htmlSignFail()),
            'url' => array('viewGrade', 'id' => $model->id),
            'active' => $this->action->id === 'viewGrade',
        ),
    ),
));
?>
<?php echo $content; ?>
<?php $this->endWidget(); ?>