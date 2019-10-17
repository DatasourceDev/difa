<?php echo Helper::htmlTopic('รายชื่อผู้เข้าสอบแยกตามวัตถุประสงค์ในการสอบ'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์รายงาน',
        'icon' => 'print',
        'context' => 'primary',
        'buttonType' => 'link',
        'url' => array('print'),
        'htmlOptions' => array(
            'target' => '_blank',
        ),
    ));
    ?>
</div>
<?php
$this->renderPartial('//shared/docExamScheduleHeader', array(
    'title' => 'รายชื่อผู้เข้าสอบแยกตามวัตถุประสงค์ในการสอบ',
    'examSchedule' => $this->examSchedule,
))
?>
<br/>
<?php foreach ($this->examSchedule->examScheduleObjectives as $object): ?>
    <?php
    $applications = ExamApplication::model()->sortBy('desk_no')->findAllByAttributes(array(
        'exam_schedule_objective_id' => $object->id,
        'exam_schedule_id' => $this->examSchedule->id,
    ));
    ?>
    <?php if (count($applications)): ?>
        <table border="1" style="table-layout: fixed;border-collapse: collapse;margin-bottom:20px;" width="100%">
            <caption>
                <strong><?php echo CHtml::value($object, 'name_th'); ?></strong>
            </caption>
            <thead>
                <tr>
                    <th width="15%" class="text-center">เลขที่</th>
                    <th width="35%" class="text-center">ชื่อ-นามสกุล</th>
                    <th width="40%" class="text-center">หน่วยงาน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td class="text-center"><?php echo str_pad(CHtml::value($application, 'desk_no'), 3, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo CHtml::value($application, 'account.profile.fullname'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($application, 'account.profile.textDepartment'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody> 
        </table>
    <?php endif; ?>
<?php endforeach; ?>