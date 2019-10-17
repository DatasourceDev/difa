<?php echo Helper::htmlTopic('รายละเอียดการสอบ'); ?>
<div class="row">
    <div class="col-sm-6">
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $this->examSchedule,
            'attributes' => array(
                array(
                    'name' => 'examType.name',
                ),
                array(
                    'name' => 'exam_code',
                ),
                array(
                    'label' => 'ทักษะ',
                    'name' => 'textSkill',
                ),
                array(
                    'label' => 'จำนวนที่นั่งสอบ',
                    'value' => CHtml::value($this, 'examSchedule.countSeatPreserved') . ' / ' . CHtml::value($this, 'examSchedule.max_quota'),
                ),
                array(
                    'name' => 'db_date',
                    'type' => 'dateText',
                ),
                array(
                    'label' => 'สถานที่สอบ',
                    'name' => 'place_name',
                ),
                array(
                    'label' => 'แผนที่',
                    'value' => CHtml::link(CHtml::image(CHtml::value($this, 'examSchedule.codePlace.fileUrl'), CHtml::value($this, 'examSchedule.codePlace.name')), array('#'), array('class' => 'thumbnail')),
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
    </div>
</div>
