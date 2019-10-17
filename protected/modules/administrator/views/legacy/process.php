<?php echo Helper::htmlTopic('ข้อมูลจากระบบเดิม', 'กำลังประมวลผล'); ?>
<div class="text-center">
    <div>กำลังประมวลผล กรุณารอสักครู่</div>
    <?php echo CHtml::image($this->module->assetUrl . '/images/ajax-loader.gif'); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        checkFile();
    });

    function checkFile() {
        $.get('<?php echo $this->createUrl('checkProgress', array('id' => $model->id)); ?>', function (data) {
            if (data !== 'OK') {
                window.setTimeout(function () {
                    checkFile();
                }, 3000);
            } else {
                window.location.href = '<?php echo $this->createUrl('done', array('id' => $model->id)); ?>';
            }
        });
    }
</script>