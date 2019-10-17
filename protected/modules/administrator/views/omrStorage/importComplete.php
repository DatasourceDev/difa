<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'รายงานการนำเข้าผลสอบ',
    'headerIcon' => 'search',
));
?>
<div class="grid-view">
    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th class="text-center">ลำดับ</th>
                <th>ชื่อ-นามสกุล</th>
                <th class="text-center">รหัส</th>
                <th class="text-center">รอบสอบ</th>
                <th class="text-center">ชุดสอบ</th>
                <th class="text-center">คะแนน</th>
                <th class="text-center">เกรด</th>
                <th class="text-center">การนำเข้า</th>
                <th class="text-center">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $count => $data): ?>
                <tr>
                    <td class="text-center"><?php echo ($count + 1); ?></td>
                    <td><?php echo CHtml::value($data, 'examApplication.fullnameTh'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'examApplication.account.entry_code'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'examSchedule.exam_code'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'exam_set_id'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'score'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'grade'); ?></td>
                    <td class="text-center <?php echo CHtml::value($data, 'is_success') === '1' ? 'bg-success' : 'bg-danger'; ?>"><?php echo CHtml::value($data, 'is_success') === '1' ? Helper::glyphicon('ok') : Helper::glyphicon('remove'); ?></td>
                    <td><?php echo CHtml::value($data, 'comment'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br/>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'นำเข้ารายการต่อไป',
        'icon' => 'import',
        'url' => array('import'),
        'buttonType' => 'link',
        'context' => 'info',
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'กลับไปหน้าแสดงรายการ',
        'icon' => 'list',
        'url' => array('examProcessExamSet/index', 'ExamApplicationExamSet' => Yii::app()->request->getQuery('ExamApplicationExamSet')),
        'buttonType' => 'link',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>