<?php echo Helper::htmlTopic('จัดการชุดข้อสอบ'); ?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array_merge(array(
        array(
            'name' => 'desk_no',
            'value' => 'str_pad($data->desk_no,3,"0",STR_PAD_LEFT)',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'account.entry_code',
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'account.profile.fullname',
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllBySubject('R'), 'id', 'id'),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($this->examSchedule->getExamSetOfSubject('R'), 'exam_subject_id'),
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการอ่าน',
            'value' => 'CHtml::value($data->getExamSetBySubject("R"),"exam_set_id")',
            'visible' => $this->examSchedule->hasSkill('R'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllBySubject('L'), 'id', 'id'),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($this->examSchedule->getExamSetOfSubject('L'), 'exam_subject_id'),
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการฟัง',
            'value' => 'CHtml::value($data->getExamSetBySubject("L"),"exam_set_id")',
            'visible' => $this->examSchedule->hasSkill('L'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllBySubject('W'), 'id', 'id'),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($this->examSchedule->getExamSetOfSubject('W'), 'exam_subject_id'),
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการเขียน',
            'value' => 'CHtml::value($data->getExamSetBySubject("W"),"exam_set_id")',
            'visible' => $this->examSchedule->hasSkill('W'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllBySubject('S'), 'id', 'id'),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($this->examSchedule->getExamSetOfSubject('S'), 'exam_subject_id'),
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการพูด',
            'value' => 'CHtml::value($data->getExamSetBySubject("S"),"exam_set_id")',
            'visible' => $this->examSchedule->hasSkill('S'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
        ),
    )),
));
?>