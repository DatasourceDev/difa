<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มประเภทการสอบ',
        'context' => 'primary',
        'url' => array('manageExamType/create'),
        'buttonType' => 'link',
    ))
    ?>
</div>
<br/>
<?php foreach ($examTypes as $examType): ?>
    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'title' => CHtml::value($examType, 'htmlTitle'),
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'size' => 'small',
                'buttons' => array(
                    array(
                        'icon' => 'trash',
                        'context' => 'danger',
                        'buttonType' => 'link',
                        'url' => array('manageExamType/delete', 'id' => $examType->id),
                        'htmlOptions' => array(
                            'title' => 'ลบประเภทการสอบ',
                            'onclick' => 'return confirm("ต้องการลบประเภทการสอบ ?");',
                        ),
                    ),
                ),
            ),
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'size' => 'small',
                'buttons' => array(
                    array(
                        'icon' => 'edit',
                        'context' => 'info',
                        'buttonType' => 'link',
                        'url' => array('manageExamType/update', 'id' => $examType->id),
                        'htmlOptions' => array(
                            'title' => 'แก้ไขประเภทการสอบ',
                        ),
                    ),
                ),
            ),
        ),
    ));
    ?>
    <div class="row">
        <div class="col-sm-4">
            <div class="text-center"> 
                <span class="thumbnail">
                    <?php echo CHtml::image($examType->coverFile->getFileUrl('thumbnail')); ?>
                </span>
            </div>
        </div>
        <div class="col-sm-8">
            <?php
            $this->widget('booster.widgets.TbDetailView', array(
                'data' => $examType,
                'attributes' => array(
                    'code',
                    'name',
                    'description',
                    'default_register_fee',
                    array(
                        'name' => 'income_type_id',
                        'value' => CHtml::value($examType, 'incomeType.textName', '<span class="text-muted">ไม่ระบุ</span>'),
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'is_active',
                        'value' => $examType->is_active === ActiveRecord::YES ? 'เปิดใช้งาน' : 'ไม่ใช้งาน',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
    <table class="table table-condensed table-striped text-sm">
        <colgroup>
            <col width="5%"/>
            <col width="5%"/>
            <col width="15%"/>
            <col/>
            <col/>
            <col width="10%"/>
        </colgroup>
        <thead class="bg-primary">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">ลำดับ</th>
                <th>ประเภททักษะ</th>
                <th>หัวข้อในการสอบ</th>
                <th>การตัดคะแนน</th>
                <th class="text-center">เครื่องมือ</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'icon' => 'plus',
                        'size' => 'small',
                        'label' => 'เพิ่มประเภททักษะใหม่',
                        'context' => 'success',
                        'buttonType' => 'link',
                        'url' => array('manageExamSubject/create', 'id' => $examType->id),
                    ));
                    ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php if (count($examType->examSubjects)): ?>
                <?php foreach ($examType->examSubjects as $examSubject): ?>
                    <tr>
                        <td class="text-center"><span class="label label-primary"><?php echo CHtml::value($examSubject, 'code'); ?></span></td>
                        <td class="text-center">
                            <?php
                            $this->widget('booster.widgets.TbEditableField', array(
                                'model' => $examSubject,
                                'attribute' => 'order_no',
                                'url' => array('ajaxUpdateSubject'),
                                'success' => 'js:function(){window.location.reload();}',
                            ));
                            ?>
                        </td>
                        <td><?php echo CHtml::value($examSubject, 'name'); ?> (<?php echo CHtml::value($examSubject, 'name_en'); ?>)</td>
                        <td>
                            <?php foreach ($examSubject->examSubjectTopics as $examSubjectTopic): ?>
                                <span class="label label-info"><?php echo CHtml::value($examSubjectTopic, 'exam_topic_code'); ?> | <?php echo CHtml::value($examSubjectTopic, 'name'); ?> | <?php echo CHtml::link('<small class="text-white glyphicon glyphicon-pencil"></small>', array('manageExamSubjectTopic/update', 'exam_subject_id' => $examSubject->id, 'exam_topic_code' => $examSubjectTopic->exam_topic_code)); ?> <?php echo CHtml::link('<small class="text-white glyphicon glyphicon-trash"></small>', array('manageExamSubjectTopic/delete', 'exam_subject_id' => $examSubject->id, 'exam_topic_code' => $examSubjectTopic->exam_topic_code), array('onclick' => 'return confirm("ต้องการลบหัวข้อนี้ ?")')); ?></span>
                            <?php endforeach; ?>
                            <span class="label label-primary"><?php echo CHtml::link('+', array('manageExamSubjectTopic/create', 'exam_subject_id' => $examSubject->id), array('class' => 'text-white')); ?></span>
                        </td>
                        <td>
                            <?php foreach ($examSubject->examDefaultGrades as $examDefaultGrade): ?>
                                <span class="label label-success"><?php echo CHtml::value($examDefaultGrade, 'grade'); ?></span>
                            <?php endforeach; ?>                            
                        </td>
                        <td class="text-center">
                            <?php echo CHtml::link(Helper::glyphicon('tasks'), array('manageExamDefaultGrade/index', 'id' => $examSubject->id), array('title' => 'ตั้งค่าการตัดคะแนน')); ?>
                            <?php echo CHtml::link(Helper::glyphicon('list'), array('manageExamDefaultPrerequisiteSubject/index', 'id' => $examSubject->id), array('title' => 'ตั้งค่าผลการสอบที่ต้องผ่านมาก่อน')); ?>
                            <?php echo CHtml::link(Helper::glyphicon('edit'), array('manageExamSubject/update', 'id' => $examSubject->id), array('title' => 'แก้ไข')); ?>
                            <?php echo CHtml::link(Helper::glyphicon('trash'), array('manageExamSubject/delete', 'id' => $examSubject->id), array('title' => 'ลบ', 'onclick' => 'return confirm("ต้องการลบทักษะนี้?")')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center"><span class="text-muted">คุณยังไม่ได้กำหนดทักษะใดๆ ในประเภทการสอบนี้</span></td>
                </tr>
            <?php endif; ?>
    </table>
    <?php $this->endWidget(); ?>
<?php endforeach; ?>
