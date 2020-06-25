<?php $this->beginContent('application.views.mail._layout'); ?>
<p>เรียน <?php echo CHtml::value($model, 'profile.fullnameTh'); ?></p>
<p>ตามที่ท่านได้สมัครสอบภาษาอังกฤษ DIFA TES สถาบันการต่างประเทศเทวะวงศ์วโรปการ ขอแจ้งรายละเอียด ดังนี้: </p>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $examApplication,
    'attributes' => array(
        array(
            'label' => 'ประเภทการสอบ',
            'name' => 'exam_type_id',
            'value' => $examApplication->examSchedule->examType->name,
        ),
        array(
            'label' => 'ค่าธรรมเนียมสอบ',
            'name' => 'payment_amount',
            'type' => 'moneyRoundText',
            'options'=>['class'=>'text-left'],
            'visible' => $examApplication->payment_amount > 0,
        ),
    ),
));
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $examApplication->examSchedule,
    'attributes' => $examApplication->examSchedule->getSkillDetailArray(),
));
?>
<?php if ($examApplication->payment_amount > 0): ?>
    <p>กรุณาพิมพ์แบบชำระค่าธรรมเนียมการสอบ (เอกสารแนบ) เพื่อนำไปชำระที่ธนาคารหรือตามช่องทางอื่น ที่ให้บริการ และเก็บเอกสารส่วนของผู้สมัครไว้เป็นหลักฐานในการเข้าห้องสอบ</p>
<?php else: ?>
    <p>กรุณาพิมพ์บัตรประจำตัวสอบ (เอกสารแนบ) เพื่อเป็นหลักฐานในการเข้าห้องสอบ</p>
<?php endif; ?>
<p >**ในกรณีของผู้บกพร่องทางการเห็น กรุณากรอกแบบคำร้องการสอบภาษาอังกฤษ DIFA TES ผ่านระบบ ออนไลน์ที่ <a href="https://goo.gl/forms/WWF4Ys3JpkOArTKZ2" target="_blank">https://goo.gl/forms/WWF4Ys3JpkOArTKZ2</a></p>
<br />
<div style="border:2px solid #dc1414;padding:10px">
   <p>
      เพื่อป้องกันการแพร่ระบาดของโรคติดเชื้อไวรัสโคโรนา 2019 (COVID-19) จึงขอความร่วมมือผู้สอบทุกท่านตอบแบบคัดกรองผ่านระบบออนไลน์ที่ https://bit.ly/2WFCa02
   </p>
   <p>
      ** ขอขอบคุณในความร่วมมือ **
   </p>
</div>

<br />
<p>ขอบคุณสำหรับการสมัครสอบของท่าน</p>
<?php $this->endContent(); ?>