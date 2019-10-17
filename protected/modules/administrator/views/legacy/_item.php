<tr>
    <td>
        <?php echo Yii::app()->format->formatDate(CHtml::value($data, "room.TestDate")); ?><br/>
        <small>รอบที่ <span class="text-primary"><?php echo CHtml::value($data, "room.Round"); ?></span> / ประเภท <span class="text-primary"><?php echo CHtml::value($data, "room.level.Level"); ?></span></small>
    </td>
    <td>
        <strong><?php echo CHtml::value($data, "person.Title"); ?> <?php echo CHtml::value($data, "person.Name"); ?></strong><br/>
        <small class="text-muted"><?php echo CHtml::value($data, "person.department.Department"); ?></small>
    </td>
    <td>
        <?php if (mb_strlen(CHtml::value($data, "room.subject.Subject"), 'UTF-8') > 50): ?>
            <?php echo mb_substr(CHtml::value($data, "room.subject.Subject"), 0, 50, 'UTF-8'); ?>...<br/>
        <?php else: ?>
            <?php echo CHtml::value($data, "room.subject.Subject", '--ไม่ระบุชื่อทุน--'); ?><br/>
        <?php endif; ?>
        <small class="text-muted"><?php echo CHtml::value($data, "room.donor.DonorName"); ?></small>
    </td>
    <td class="text-center">
        <?php echo CHtml::value($data, "room.TestSet"); ?><br/>
        <small class="text-muted"><?php echo CHtml::value($data, "room.TestType"); ?></small>
    </td>
    <td class="text-center"><?php echo CHtml::value($data, "DeskNumber"); ?></td>
    <td class="text-right"><?php echo CHtml::value($data, "Reading"); ?></td>
    <td class="text-right"><?php echo CHtml::value($data, "Listening"); ?></td>
    <td class="text-right"><?php echo CHtml::value($data, "ScoreTotal"); ?></td>
</tr>