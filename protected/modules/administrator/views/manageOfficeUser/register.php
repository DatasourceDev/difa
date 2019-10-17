<?php $this->beginContent('_layout', array('model' => $account)); ?>

<div class="grid-view">
    <table class="table table-bordered table-condensed">
        <colgroup>
            <col width="60"/>
            <col width="100"/>
            <col width="180"/>
            <col width="120"/>
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
        </colgroup>
        <tbody>
            <tr class="bg-success">
                <th colspan="8">
                    <h5>รายชื่อผู้มีสิทธิสอบ</h5>
                </th>
            </tr>
            <tr class="bg-success">
                <th class="text-center">ลำดับที่</th>
                <th class="text-center">เลขที่นั่งสอบ</th>
                <th>ชื่อ-นามสกุล</th>
                <th class="text-center">รหัสประจำตัว</th>
                <th class="text-center">สถานะบัญชี</th>
                <th class="text-center">ชำระเงิน</th>
                <th class="text-center">ลงทะเบียน</th>
                <th class="text-center"></th>
            </tr>
            <?php foreach ($queueReady as $count => $data) : ?>
                <tr>
                    <td class="text-center"><?php echo $count + 1; ?></td>
                    <td class="text-center"><?php echo $data->getIsPaid() ? CHtml::value($data, 'deskNumber') : ''; ?></td>
                    <td><?php echo CHtml::value($data, 'account.profile.fullname'); ?></td>
                    <td class="text-center"><?php echo CHtml::value($data, 'account.entry_code'); ?></td>
                    <td class="text-center">
                        <?php if (CHtml::value($data, 'account.status') === Account::STATUS_ACTIVED): ?>
                            <?php echo Helper::htmlSignSuccess(); ?>
                        <?php else: ?>
                            <?php echo Helper::htmlSignFail(); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($data->getIsPaid()): ?>
                            <?php echo Helper::htmlSignSuccess(); ?>
                        <?php else: ?>
                            <?php echo Helper::htmlSignFail(); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($data->getIsPresent()): ?>
                            <?php echo Helper::htmlSignSuccess(); ?>
                        <?php else: ?>
                            <?php echo Helper::htmlSignFail(); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if (!$scheduleAccount->getIsConfirm()): ?>
                            <?php echo CHtml::link(Helper::glyphicon('trash'), array('cancel', 'id' => $data->id)); ?>
                        <?php endif; ?>
                        <?php if ($data->getIsPaid()): ?>
                            <?php echo CHtml::link(Helper::glyphicon('print'), array('printCard', 'id' => $data->exam_schedule_id, "exam_application_id" => $data->id)); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($queueFail)): ?>
                <tr class="bg-danger">
                    <th colspan="8">
                        <h5>รายชื่อผู้ที่ไม่สามารถสมัครสอบได้</h5>
                    </th>
                </tr>
                <tr class="bg-danger">
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">เลขที่นั่งสอบ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th class="text-center">รหัสประจำตัว</th>
                    <th class="text-center" colspan="3">เงื่อนไขการสมัคร</th>
                    <th class="text-center"></th>
                </tr>
                <?php foreach ($queueFail as $fCount => $data) : ?>
                    <tr>
                        <td class="text-center"><?php echo ($fCount + count($queueReady) + 1); ?></td>
                        <td class="text-center"><?php echo $data->getIsPaid() ? CHtml::value($data, 'deskNumber') : ''; ?></td>
                        <td><?php echo CHtml::value($data, 'account.profile.fullname'); ?></td>
                        <td class="text-center"><?php echo CHtml::value($data, 'account.entry_code'); ?></td>
                        <td colspan="3">
                            <span style="font-size:smaller;"><?php echo CHtml::value($data, 'applicable_error'); ?></span>
                        </td>
                        <td class="text-center">
                            <?php echo CHtml::link(Helper::glyphicon('refresh'), array('recheck', 'id' => $data->id)); ?>
                            <?php echo CHtml::link(Helper::glyphicon('trash'), array('cancel', 'id' => $data->id)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<hr/>
<div class="well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์บัตรประจำตัวสอบ',
        'buttonType' => 'link',
        'icon' => 'print',
        'url' => array('printCardAll', 'id' => $account->id),
        'htmlOptions' => array(
            'title' => $scheduleAccount->isPaid ? '' : 'ต้องชำระเงินก่อน จึงจะพิมพ์บัตรประจำตัวสอบได้',
            'data-toggle' => $scheduleAccount->isPaid ? '' : 'tooltip',
            'disabled' => !$scheduleAccount->isPaid,
            'onclick' => $scheduleAccount->isPaid ? 'return true' : 'return false',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'พิมพ์แบบชำระเงิน',
        'buttonType' => 'link',
        'icon' => 'print',
        'url' => array('printPayment', 'id' => $account->id),
    ));
    ?>
</div>
<?php $this->endContent(); ?>