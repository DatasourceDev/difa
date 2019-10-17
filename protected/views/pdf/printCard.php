<?php $this->beginContent('application.views.pdf.layout'); ?>
<?php

$this->renderPartial('//pdf/printCardItem', array(
    'model' => $model,
));
?>
<?php $this->endContent(); ?>