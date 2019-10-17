<?php

$this->beginContent('/manageSchedule/_view', array(
    'model' => $examSchedule,
));
?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'selectableRows' => 0,
    'rowCssClassExpression' => '($data->getIsTakeSameExamType() ? "bg-yellow text-danger" : ($data->getIsTakeSameExamTypeUnstable() ? "bg-purple text-danger" : ""))',
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
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'account.profile.fullname',
            'value' => 'CHtml::link(CHtml::value($data,"fullnameTh"),array("ajaxView/accountInfo","id" => $data->account_id),array("class" => "btn-ajax-modal", "data-modal-size" => "large"))',
            'type' => 'raw',
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'name' => 'data_1',
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllByScheduleSubject('R'), 'id', 'id'),
                'options' => array(
                    'sourceError' => 'ไม่พบชุดสอบ',
                ),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($examSchedule->getExamSetOfSubject('R'), 'exam_subject_id'),
                    'exam_schedule_id' => $examSchedule->id,
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการอ่าน',
            'value' => 'CHtml::value($data->getExamSetBySubject("R"),"exam_set_id")',
            'visible' => $examSchedule->hasSkill('R'),
            'htmlOptions' => array(
                'rel' => 'helloworld',
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
            'cssClassExpression' => 'CHtml::value($data->getExamSetBySubject("R"),"isDuplicateExamSet") ? "bg-red" : ""',
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'name' => 'data_2',
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllByScheduleSubject('L'), 'id', 'id'),
                'options' => array(
                    'sourceError' => 'ไม่พบชุดสอบ',
                ),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($examSchedule->getExamSetOfSubject('L'), 'exam_subject_id'),
                    'exam_schedule_id' => $examSchedule->id,
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการฟัง',
            'value' => 'CHtml::value($data->getExamSetBySubject("L"),"exam_set_id")',
            'visible' => $examSchedule->hasSkill('L'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
            'cssClassExpression' => 'CHtml::value($data->getExamSetBySubject("L"),"isDuplicateExamSet") ? "bg-red" : ""',
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'name' => 'data_3',
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllByScheduleSubject('W'), 'id', 'id'),
                'options' => array(
                    'sourceError' => 'ไม่พบชุดสอบ',
                ),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($examSchedule->getExamSetOfSubject('W'), 'exam_subject_id'),
                    'exam_schedule_id' => $examSchedule->id,
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการเขียน',
            'value' => 'CHtml::value($data->getExamSetBySubject("W"),"exam_set_id")',
            'visible' => $examSchedule->hasSkill('W'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
            'cssClassExpression' => 'CHtml::value($data->getExamSetBySubject("W"),"isDuplicateExamSet") ? "bg-red" : ""',
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'editable' => array(
                'name' => 'data_4',
                'mode' => 'inline',
                'type' => 'select',
                'source' => CHtml::listData($examSet->findAllByScheduleSubject('S'), 'id', 'id'),
                'options' => array(
                    'sourceError' => 'ไม่พบชุดสอบ',
                ),
                'url' => array('changeExamSet'),
                'params' => array(
                    'exam_subject_id' => CHtml::value($examSchedule->getExamSetOfSubject('S'), 'exam_subject_id'),
                    'exam_schedule_id' => $examSchedule->id,
                ),
            ),
            'name' => 'exam_set_id',
            'header' => 'ทักษะการพูด',
            'value' => 'CHtml::value($data->getExamSetBySubject("S"),"exam_set_id")',
            'visible' => $examSchedule->hasSkill('S'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:275px;'
            ),
            'cssClassExpression' => 'CHtml::value($data->getExamSetBySubject("S"),"isDuplicateExamSet") ? "bg-red" : ""',
        ),
    )),
));
?>
<?php $this->endWidget(); ?>