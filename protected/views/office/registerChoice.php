<?php $this->beginContent('_layout'); ?>
<h3 class="fancy text-center">บันทึกข้อมูลการสมัครสอบเรียบร้อย</h3>
<?php if ($this->scheduleAccount->max_quota >= $this->scheduleAccount->getCountApplication()): ?>
    <?php if ($this->scheduleAccount->getIsQuotaExceeded()): ?>
        <div class="text-center">ท่านได้เพิ่มผู้สอบครบตามจำนวนโควต้าแล้ว</div>
        <br/>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'เสร็จสิ้นการสมัคร',
                    'url' => array('register', 'mode' => 'confirm'),
                    'buttonType' => 'link',
                    'context' => 'primary',
                    'block' => true,
                ));
                ?>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center">ท่านต้องการเพิ่มผู้สอบอีกหรือไม่?</div>
        <br/>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-2">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'เพิ่มผู้สอบรายถัดไป',
                    'url' => array('register', 'mode' => 'add'),
                    'buttonType' => 'link',
                    'context' => 'success',
                    'block' => true,
                ));
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'เสร็จสิ้นการสมัคร',
                    'url' => array('register', 'mode' => 'confirm'),
                    'buttonType' => 'link',
                    'context' => 'primary',
                    'block' => true,
                ));
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="text-center">ท่านต้องการเพิ่มผู้สอบอีกหรือไม่?</div>
    <br/>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เสร็จสิ้นการสมัคร',
                'url' => array('register', 'mode' => 'confirm'),
                'buttonType' => 'link',
                'context' => 'primary',
                'block' => true,
            ));
            ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->endContent(); ?>