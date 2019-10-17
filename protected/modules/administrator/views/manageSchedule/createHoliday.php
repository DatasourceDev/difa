<h4 class="fancy">จัดรอบสอบใหม่ ในวันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText(CHtml::value($holiday, 'id')) ?></span></h4>
<div class="alert alert-danger">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    ไม่สามารถจัดสอบได้ เนื่องจากตรงกับวันหยุดนักขัตฤกษ์ (<?php echo CHtml::value($holiday, 'name'); ?>)
</div>