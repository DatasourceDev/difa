<?php $contactUs = new WebContactUs; ?>
<div class="topic"><?php echo Helper::t('Contact Us', 'ติดต่อเรา'); ?></div>
<div class="row contactContent">
 <?php if(isset( $contactUs->googlemap)): ?>
    <div class="col-sm-6">
        <iframe src="<?php echo $contactUs->googlemap ?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    <?php endif; ?>
    <div class="col-sm-6">
        <div><?php echo $contactUs->address ?></div>
        <div>
            <strong>โทรศัพท์:</strong>
            <?php echo $contactUs->tel ?>
        </div>
        <div>
            <strong>Fax:</strong>
            <?php echo $contactUs->fax ?>
        </div>
        <div>
            <?php if(isset($contactUs->map_src)): ?>
            <br/>
            <?php echo CHtml::link("ดาวน์โหลดแผนที่", array('get/downloadMap'),array("target"=>"_blank")); ?>
            <?php endif ?>
        </div>

    </div>
</div>
