<?php if (Yii::app()->language === 'th'): ?>
    <div class="topic">ยืนยันการสมัครสมาชิก</div>
    <p class="text-center">ระบบได้บันทึกข้อมูลของท่านเรียบร้อยแล้ว ก่อนปิดหน้าจอนี้ กรุณาตรวจสอบกล่องจดหมายของ <span class="text-primary"><?php echo CHtml::value($model, 'profile.contact_email'); ?></span> เพื่อยืนยันการสมัคร</p>
    <p class="text-center">หากไม่พบข้อความในกล่องจดหมาย <?php echo CHtml::link('[คลิกที่นี่]', array('resend', 'id' => $model->id)); ?> ระบบจะส่งข้อความอีกครั้ง</p>
    <p class="text-center">หลังจากยืนยันการสมัครสมาชิกแล้ว ท่านสามารถ Login เพื่อสมัครสอบ DIFA TES ได้</p>
    <div class="text-center">
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/email-sent.png', '', array('height' => 150)); ?>
    </div>
<?php else: ?>
    <div class="topic">Confirmation</div>
    <p class="text-center">Your data has been saved. Before closing this window, Please check your inbox <span class="text-primary"><?php echo CHtml::value($model, 'profile.contact_email'); ?></span> to confirm your membership registration.</p>
    <p class="text-center">If you have not received an email, you can <?php echo CHtml::link('[click here]', array('resend', 'id' => $model->id)); ?> to send again.</p>
    <p class="text-center">After your membership has been confirmed, you can go directly to log in.</p>
    <div class="text-center">
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/email-sent.png', '', array('height' => 150)); ?>
    </div>
<?php endif; ?>
