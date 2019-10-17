<div class="row">
    <div class="col-sm-12">
    <div class="topic"><?php echo Helper::t('Download', 'ดาวน์โหลด'); ?></div>
    <ul id="nav-download" class="text-small">
        <?php foreach ($model as $document): ?>
            <li>
                <?php echo CHtml::link(Helper::glyphicon('download-alt') . '<span>' . CHtml::value($document, 'name_th') . '</span><small>' . CHtml::value($document, 'name_en') . '</small>', array('get/downloadDocument', 'id' => $document->id)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>
</div>