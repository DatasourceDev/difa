<?php $this->beginContent('_layout'); ?>
<?php $schedule->checkCondition(); ?>
<?php if ($scheduleAccount->is_confirm === ActiveRecord::NO && !$scheduleAccount->getIsQuotaExceeded()): ?>
    <?php if ($schedule->getIsClose()): ?>
        <div class="well well-sm"><?php echo $schedule->close_description; ?></div>
    <?php elseif ($schedule->hasErrors()): ?>
        <div class="well well-sm"><?php echo Helper::errorSummary($schedule); ?></div>
    <?php elseif (Yii::app()->request->getQuery('mode') !== 'confirm'): ?>
        <div class="btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เพิ่ม ข้าราชการ พนักงานรัฐวิสาหกิจ และพนักงานในกำกับของรัฐ',
                'url' => array('createGeneralThai', 'id' => $schedule->id),
                'context' => 'success',
                'buttonType' => 'link',
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เพิ่ม Foreign Civil Servants',
                'url' => array('createGeneralForeigner', 'id' => $schedule->id),
                'context' => 'info',
                'buttonType' => 'link',
            ));
            ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php if ($scheduleAccount->is_confirm === ActiveRecord::YES): ?>
        <?php if (($this->countCurrent) >= CHtml::value($this, 'scheduleAccount.preserved_quota')): ?>
            <div class="alert alert-success"><span class="glyphicon glyphicon-exclamation-sign"></span> คุณได้ทำการยืนยันการสมัครตามจำนวนที่ได้รับอนุญาตแล้ว</div>
        <?php else: ?>
            <div class="alert alert-info"><span class="glyphicon glyphicon-exclamation-sign"></span> คุณได้รับสิทธิในการสมัคร <span class="text-primary"><?php echo CHtml::value($this, 'scheduleAccount.preserved_quota'); ?></span> คน แต่ได้ยืนยันการสมัครเพียง <span class="text-success"><?php echo $this->countCurrent; ?></span> คน</div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<div class="text-small">
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
                            <?php if ($data->is_confirm === ActiveRecord::YES): ?>
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
                                <?php echo CHtml::link(Helper::glyphicon('print'), array('printCard', 'id' => $data->exam_schedule_id, "exam_application_id" => $data->id), array('target' => '_blank')); ?>
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
                        <th class="text-center" colspan="4">เงื่อนไขการสมัคร</th>
                    </tr>
                    <?php foreach ($queueFail as $fCount => $data) : ?>
                        <tr>
                            <td class="text-center"><?php echo ($fCount + count($queueReady) + 1); ?></td>
                            <td class="text-center"><?php echo $data->getIsPaid() ? CHtml::value($data, 'deskNumber') : ''; ?></td>
                            <td><?php echo CHtml::value($data, 'account.profile.fullname'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data, 'account.entry_code'); ?></td>
                            <td colspan="4">
                                <span style="font-size:smaller;"><?php echo CHtml::value($data, 'applicable_error'); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 
<hr/>
<div class="well">
    <?php if ($scheduleAccount->is_confirm === ActiveRecord::NO): ?>
        <?php if (Yii::app()->request->getQuery('mode') !== 'add'): ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ยืนยันการสมัคร',
                'buttonType' => 'link',
                'context' => 'primary',
                'icon' => 'ok',
                'url' => array('registerConfirm', 'id' => $schedule->id),
                'htmlOptions' => array(
                    'onclick' => 'return confirm("You could not register more application after this confirmation.\nDo you want to confirm ?")',
                ),
                'visible' => $dataProvider->totalItemCount > 0 && $dataProvider->totalItemCount >= CHtml::value($this, 'scheduleAccount.preserved_quota'),
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ยืนยันการสมัคร',
                'context' => 'primary',
                'icon' => 'ok',
                'buttonType' => 'link',
                'url' => array('quotaConfirmation'),
                'htmlOptions' => array(
                    'class' => 'btn-ajax-modal',
                ),
                'visible' => $dataProvider->totalItemCount > 0 && $dataProvider->totalItemCount < CHtml::value($this, 'scheduleAccount.preserved_quota'),
            ));
            ?>
        <?php endif; ?>
    <?php else: ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'พิมพ์บัตรประจำตัวสอบ',
            'buttonType' => 'link',
            'icon' => 'print',
            'url' => array('printCardAll', 'id' => $schedule->id),
            'htmlOptions' => array(
                'title' => $scheduleAccount->isPaid ? '' : 'ต้องชำระเงินก่อน จึงจะพิมพ์บัตรประจำตัวสอบได้',
                'data-toggle' => $scheduleAccount->isPaid ? '' : 'tooltip',
                'disabled' => !$scheduleAccount->isPaid,
                'onclick' => $scheduleAccount->isPaid ? 'return true' : 'return false',
                'target' => '_blank',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'พิมพ์แบบชำระเงิน',
            'buttonType' => 'link',
            'icon' => 'print',
            'url' => array('printPayment', 'id' => $schedule->id),
            'htmlOptions' => array(
                'target' => '_blank',
            ),
            'visible' => !$schedule->isFree,
        ));
        ?>
    <?php endif; ?>
</div>
<?php $this->endContent(); ?>