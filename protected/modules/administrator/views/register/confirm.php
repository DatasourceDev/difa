<div class="topic">E-mail Confirmation <small>(ยืนยันการตัวตนผ่านทางอีเมล์)</small></div>
<p class="text-center">ทางสถาบันฯได้บันทึกข้อมูลของคุณไว้เรียบร้อยแล้ว กรุณาตรวจสอบกล่องจดหมายของ <span class="text-primary"><?php echo CHtml::value($model, 'profile.contact_email'); ?></span> เพื่อทำการยืนยันการสมัคร</p>
<p class="text-center">หากไม่พบ ท่านสามารถ <?php echo CHtml::link('[คลิ๊กที่นี่]', array('resend', 'id' => $model->id)); ?> เพื่อส่งจดหมายอีกครั้ง</p>
<p class="text-center">หลังจากยืนยันการสมัครแล้ว ท่านสามารถ เข้าสู่ระบบ ได้ทันที</p>
<div class="text-center">
    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/email-sent.png', '', array('height' => 150)); ?>
</div>