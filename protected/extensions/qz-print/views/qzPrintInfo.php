<div class="qz-info">
    <div class="well well-sm">
        <h3 class="text-center">QZ Printer Status</h3>
        <div class="text-center">
            <h2 id="qz-info-status" class="text-success">..checking..</h2>
            <div>Default Printer : <span id="qz-info-printer" class="text-info"><?php echo CHtml::image(Yii::app()->qz->assetUrl . '/images/ajax-loader.gif'); ?></span></div>
            <div>Version : <span id="qz-info-version" class="text-info"><?php echo CHtml::image(Yii::app()->qz->assetUrl . '/images/ajax-loader.gif'); ?></span></div>
        </div>
        <div class="text-center">
            <small><?php echo CHtml::link('Download QzTray', array('/site/qzTrayDownload')); ?></small>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>