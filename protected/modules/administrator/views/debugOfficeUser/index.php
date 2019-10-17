<?php echo Helper::htmlTopic('a'); ?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
));
?>