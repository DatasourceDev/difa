<?php
$this->renderPartial('/manageMember/shared/grid', array(
    'model' => $model,
    'dataProvider' => $dataProvider,
));
?>