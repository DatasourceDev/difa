<div class="topic"><?php echo Helper::t('Payment', 'กรุณาชำระเงิน'); ?></div>
<div class="well well-sm text-center">
    <a class="btn btn-success" href="#">1.สมัครสมาชิก <span class="glyphicon glyphicon-ok"></span></a> <span class="glyphicon glyphicon-arrow-right"></span>
    <a class="btn btn-success" href="#">2.สมัครสอบ <span class="glyphicon glyphicon-ok"></span></a> <span class="glyphicon glyphicon-arrow-right"></span>
    <?php if ($model->isPaid): ?>
        <a class="btn btn-success" href="#">3.ชำระเงิน <span class="glyphicon glyphicon-ok"></span></a> 
    <?php else: ?>
        <a class="btn btn-default" href="#">3.ชำระเงิน</a>
    <?php endif; ?>
    <span class="glyphicon glyphicon-arrow-right"></span>
    <?php if ($model->isPresent): ?>
        <a class="btn btn-success" href="#">4.ดำเนินการสอบ <span class="glyphicon glyphicon-ok"></span></a>
    <?php else: ?>
        <a class="btn btn-default" href="#">4.ดำเนินการสอบ</a>
    <?php endif; ?>
    <span class="glyphicon glyphicon-arrow-right"></span>
    <?php if ($model->isGradeReady): ?>
        <a class="btn btn-success" href="#">5.ประกาศผลสอบ <span class="glyphicon glyphicon-ok"></span></a>
    <?php else: ?>
        <a class="btn btn-default" href="#">5.ประกาศผลสอบ</a>
    <?php endif; ?>

</div>
<div class="row"> 
    <div class="col-sm-7">
        <h4 class="fancy"><?php echo Helper::t('Examination', 'ข้อมูลการสมัครสอบ'); ?></h4> 
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'applicationNumber',
                ),
                array(
                    'name' => 'examSchedule.exam_code',
                ),
                array(
                    'name' => 'examSchedule.db_date',
                    'type' => 'dateText',
                ),
                array(
                    'name' => 'desk_no',
                    'value' => $model->isPaid ? $model->getDeskNo() : 'ดูที่หน้าห้องสอบ หรือตรวจสอบหลังชำระเงิน',
                ),
                array(
                    'label' => Helper::t('Test Venue', 'สถานที่สอบ'),
                    'name' => 'examSchedule.codePlace.name',
                ),
                array(
                    'name' => 'textObjective',
                ),
                array(
                    'name' => 'capital_name',
                ),
                array(
                    'name' => 'capital_description',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-sm-5">
        <h4 class="fancy"><?php echo Helper::t('Payment Information', 'ข้อมูลการชำระเงิน'); ?></h4> 
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'ref1',
                ),
                array(
                    'name' => 'ref2',
                ),
                array(
                    'name' => 'deskCode',
                ),
                array(
                    'label' => Helper::t('Skill(s)', 'ทักษะที่สอบ'),
                    'name' => 'examSchedule.textSkill',
                ),
                array(
                    'name' => 'payment_amount',
                    'visible' => $model->payment_amount > 0,
                ),
                array(
                    'name' => 'apply_date',
                    'type' => 'dateText',
                ),
                array(
                    'name' => 'due_date',
                    'type' => 'dateText',
                    'visible' => $model->payment_amount > 0,
                ),
                array(
                    'name' => 'is_paid',
                    'value' => ExamApplication::getHtmlPaymentStatusOptions($model->is_paid),
                    'type' => 'html',
                    'visible' => $model->payment_amount > 0,
                ),
                array(
                    'label' => Helper::t('Type of Register', 'ประเภทการสมัคร'),
                    'name' => 'apply_type',
                    'value' => $model->getHtmlApplyType(),
                    'type' => 'html',
                ),
            ),
        ));
        ?>
    </div>
</div>
<div class="well well-sm btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Back', 'ย้อนกลับ'),
        'icon' => 'arrow-left',
        'size' => 'large',
        'buttonType' => 'link',
        'url' => array('my/application'),
        'htmlOptions' => array(
            'class' => 'pull-left',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Print Pay-in Slip', 'พิมพ์แบบชำระเงิน'),
        'icon' => 'print',
        'size' => 'large',
        'context' => 'info',
        'buttonType' => 'link',
        'url' => array('printPaymentSlip', 'id' => $model->id),
        'visible' => $model->getIsSelfPrintablePaymentSlip(),
        'htmlOptions' => array(
            'target' => '_blank',
            'class' => 'pull-right',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Print Exam Card', 'พิมพ์บัตรประจำตัวสอบ'),
        'icon' => 'print',
        'size' => 'large',
        'context' => 'success',
        'buttonType' => 'link',
        'url' => array('printCard', 'id' => $model->id),
        'visible' => $model->getIsSelfPrintableExamCard(),
        'htmlOptions' => array(
            'target' => '_blank',
            'class' => 'pull-right',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Cancel', 'ยกเลิกการสมัคร'),
        'icon' => 'trash',
        'size' => 'large',
        'context' => 'danger',
        'buttonType' => 'link',
        'url' => array('cancel', 'id' => $model->id),
        'visible' => !$model->isPaid,
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("Do you want to cancel the application ?");',
        ),
    ));
    ?>
</div>