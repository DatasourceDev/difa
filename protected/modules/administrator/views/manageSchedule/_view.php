<?php

$includeMenu = isset($includeMenu) ? $includeMenu : true;
?>
<?php

$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลการจัดสอบ วันที่ <span class="text-primary">' . Yii::app()->format->formatDateText(CHtml::value($model, 'db_date')) . '</span>',
    'headerIcon' => 'calendar',
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'small',
            'buttons' => array(
                array(
                    'label' => 'ย้อนกลับ',
                    'icon' => 'arrow-left',
                    'buttonType' => 'link',
                    'url' => array('index'),
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'size' => 'small',
            'buttons' => array(
                array(
                    'label' => 'แก้ไข',
                    'icon' => 'edit',
                    'buttonType' => 'link',
                    'context' => 'info',
                    'url' => array('manageSchedule/update', 'id' => $model->id),
                ),
            ),
        ),
    ),
));
?>
<?php if ($includeMenu): ?>
    <?php

    $this->widget('booster.widgets.TbMenu', array(
        'htmlOptions' => array(
            'class' => 'text-small',
        ),
        'encodeLabel' => false,
        'type' => 'tabs',
        'items' => array(
            array(
                'label' => $this->module->getMenuIcon('icon/info') . 'ข้อมูลทั่วไป',
                'url' => array('view', 'id' => $model->id),
                'active' => $this->action->id === 'view',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/users') . 'ที่นั่งสอบ (<span class="text-danger">' . CHtml::value($model, 'countCurrentSeatPreserved', 0) . '</span>/<span class="text-primary">' . CHtml::value($model, 'max_quota', 0) . '</span>)',
                'url' => array('viewAttendee', 'id' => $model->id),
                'active' => $this->action->id === 'viewAttendee',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/exam') . 'จัดการชุดสอบ',
                'url' => array('viewAttendeeExamSet', 'id' => $model->id),
                'active' => $this->action->id === 'viewAttendeeExamSet',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/speaking') . 'ข้อมูลสำหรับทักษะการพูด',
                'url' => array('viewAttendeeExamSpeaking', 'id' => $model->id),
                'active' => $this->action->id === 'viewAttendeeExamSpeaking',
                'visible' => $model->hasSkill('S'),
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/page_fav') . 'ข้อมูลชุดข้อสอบ <span class="label label-' . ($model->getIsExamSetReady() ? 'success' : 'danger') . '">' . CHtml::value($model, 'countExamScheduleItem', 0) . '</span>',
                'url' => array('viewExamSet', 'id' => $model->id),
                'active' => $this->action->id === 'viewExamSet',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/objective') . 'วัตถุประสงค์การสอบ',
                'url' => array('viewObjective', 'id' => $model->id),
                'active' => $this->action->id === 'viewObjective',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/user_department') . 'ข้อมูลตัวแทนหน่วยงาน',
                'url' => array('viewUser', 'id' => $model->id),
                'active' => $this->action->id === 'viewUser',
            ),
            array(
                'label' => $this->module->getMenuIcon('icon/manage_exam_type') . 'หน่วยงานที่เปิดให้สมัคร',
                'url' => array('viewDepartment', 'id' => $model->id),
                'active' => $this->action->id === 'viewDepartment',
                'visible' => $model->is_private === ExamSchedule::YES,
            ),
        /*
          array(
          'label' => $this->module->getMenuIcon('icon/task') . 'รายละเอียดข้อสอบ' . ($model->getIsTaskReady() ? Helper::htmlSignSuccess() : Helper::htmlSignFail()),
          'url' => array('viewTask', 'id' => $model->id),
          'active' => $this->action->id === 'viewTask',
          ),
          array(
          'label' => $this->module->getMenuIcon('icon/grade') . 'ระดับการให้คะแนน' . ($model->getIsTaskReady() ? Helper::htmlSignSuccess() : Helper::htmlSignFail()),
          'url' => array('viewGrade', 'id' => $model->id),
          'active' => $this->action->id === 'viewGrade',
          ), */
        ),
    ));
    ?>
<?php endif; ?>
<?php echo $content; ?>
<?php $this->endWidget(); ?>