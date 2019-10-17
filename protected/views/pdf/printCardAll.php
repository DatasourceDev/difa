<?php $this->beginContent('application.views.pdf.layout'); ?>
<?php foreach ($models as $model): ?>
    <?php

    $this->renderPartial('//pdf/printCardItem', array(
        'model' => $model,
    ));
    ?>
    <pagebreak />
<?php endforeach; ?>
<?php $this->endContent(); ?>