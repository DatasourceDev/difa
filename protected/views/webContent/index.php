<div class="topic">News & Activities</div>
<?php

$this->widget('booster.widgets.TbListView', array(
    'itemView' => 'contentItem',
    'dataProvider' => $dataProvider,
    'template' => '{items} {pager}'
));
?>