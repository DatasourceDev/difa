<?php

$this->beginContent('/manageSchedule/_view', array(
    'model' => $examSchedule,
));
?>
<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array_merge(array(
        array(
            'name' => 'desk_no',
            'value' => 'str_pad($data->desk_no,3,"0",STR_PAD_LEFT)',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'account.entry_code',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'account.profile.fullname',
        ),
    ),$skillsColumn),
));
?>
<?php $this->endWidget(); ?>