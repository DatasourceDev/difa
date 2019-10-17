<?php 
    $criteria = new CDbCriteria;
    $criteria->limit = 5;
    $documents = WebDownload::model()->sortBy('order_no')->findAll($criteria); 

    $countRecord =  WebDownload::model()->count();
?>
<input type="checkbox" id="load-more-download"/>
<div class="topic"><?php echo Helper::t('Download', 'ดาวน์โหลด'); ?></div>
<ul id="nav-download" class="text-small">
    <?php foreach ($documents as $document): ?>
        <li>
            <?php echo CHtml::link(Helper::glyphicon('download-alt') . '<span>' . CHtml::value($document, 'name_th') . '</span><small>' . CHtml::value($document, 'name_en') . '</small>', array('get/downloadDocument', 'id' => $document->id)); ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php if (isset($countRecord) && $countRecord > 5): ?>
<label class="load-more-btn-download align-right" for="load-more-download">
    <span class="unloaded">
        <?php echo CHtml::link(Helper::glyphicon('collapse-down'), array('download'), array('target' => '_blank')) ?>
    </span>
    <span class="loaded">
        <?php echo Helper::glyphicon('collapse-up') ?>
    </span>
</label>
<?php endif; ?>