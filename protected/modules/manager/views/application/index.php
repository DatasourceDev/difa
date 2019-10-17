<?php echo Helper::htmlTopic('รายชื่อผู้เข้าสอบ'); ?>
<div class="row">
    <div class="col-sm-3">
        <div class="info-box bg-warning">
            <div class="info-box-content text-center">
                <div>จำนวนที่นั่งสอบ</div>
                <h2><?php echo Yii::app()->format->formatNumber($this->examSchedule->max_quota); ?></h2>
                <small>ที่นั่ง</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box bg-info">
            <div class="info-box-content text-center">
                <div>จำนวนผู้สมัคร</div>
                <h2 class="text-info"><?php echo Yii::app()->format->formatNumber($this->examSchedule->countAttendee); ?></h2>
                <small>ราย</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box bg-success">
            <div class="info-box-content text-center">
                <div>จำนวนผู้สมัครที่ชำระเงินแล้ว</div>
                <h2 class="text-success"><?php echo Yii::app()->format->formatNumber($this->examSchedule->countAttendeePaid); ?></h2>
                <small>ราย</small>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box bg-danger">
            <div class="info-box-content text-center">
                <div>จำนวนผู้สมัคร</div>
                <h2 class="text-info"><?php echo Yii::app()->format->formatNumber($this->examSchedule->countAttendee); ?></h2>
                <small>ราย</small>
            </div>
        </div>
    </div>
</div>
<div class="grid-view">
    <table class="table table-bordered table-condensed">
        <colgroup>
            <col width="80"/>
        </colgroup>
        <thead>
            <tr>
                <th class="text-center">เลขที่นั่งสอบ</th>
                <th class="text-center">รหัสประจำตัว</th>
                <th>ชื่อ-นามสกุล</th>
                <th class="text-center">หน่วยงาน</th>
                <th class="text-center">วัตถุประสงค์การสอบ</th>
                <th class="text-center">ประเภทสมัคร</th>
                <th class="text-center">การชำระเงิน</th>
                <th class="text-center">พิมพ์เอกสาร</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= $this->examSchedule->max_quota; $i++): ?>
                <?php if ($i > ($this->examSchedule->max_quota - (($this->examSchedule->countQuotaPreserved - $this->examSchedule->countAttendeeByOffice)))): ?>
                    <tr class="bg-warning">
                        <td class="text-center"><?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?></td>
                        <td class="text-muted text-center" colspan="7">-- จองโดยโควต้าตัวแทนหน่วยงาน --</td>
                    </tr>
                <?php else: ?>
                    <?php $application = CHtml::value($applicationData, $i); ?>
                    <?php if (isset($application)): ?>
                        <tr>
                            <td class="text-center"><?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'account.entry_code'); ?></td>
                            <td><?php echo CHtml::link(CHtml::value($application, 'account.profile.fullname'), array('application/view', 'id' => $application->id)); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'account.profile.textDepartment'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($application, 'examScheduleObjective.name_th'); ?></td>
                            <td class="text-center">
                                <?php if ($application->office_user_id): ?>
                                    <?php echo CHtml::link('โดยตัวแทน', array('office/view', 'id' => $application->office_user_id)); ?> 
                                <?php else: ?>
                                    สมัครเอง
                                <?php endif; ?>
                            </td>
                            <td class="text-center <?php echo $application->isPaid ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $application->isPaid ? '<span class="text-success">ชำระเงินแล้ว</span>' : '<span class="text-danger">ยังไม่ได้ชำระ</span>'; ?>
                            </td>
                            <td class="text-center">
                                <?php echo CHtml::link($this->module->getImage('icon/user_role'), array('print/examCard', 'id' => $application->id), array('title' => 'บัตรประจำตัวสอบ', 'data-toggle' => 'tooltip', 'target' => '_blank')); ?>
                                <?php echo CHtml::link($this->module->getImage('icon/expenditure'), array('print/paymentSlip', 'id' => $application->id), array('title' => 'ใบชำระเงิน', 'data-toggle' => 'tooltip', 'target' => '_blank')); ?>
                                <?php echo CHtml::link($this->module->getImage('icon/barcode'), array('print/barcode', 'id' => $application->id), array('title' => 'บาร์โค้ด', 'data-toggle' => 'tooltip')); ?>
                                <?php echo CHtml::link($this->module->getImage('icon/log'), array('print/profile', 'id' => $application->account_id), array('title' => 'ประวัติการสอบ', 'data-toggle' => 'tooltip', 'target' => '_blank')); ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr class="bg-gray">
                            <td class="text-center"><?php echo str_pad($i, 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="text-muted text-center" colspan="7">-- ว่าง --</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endfor; ?>

        </tbody>
    </table>