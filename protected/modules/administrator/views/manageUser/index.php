<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มผู้ใช้งานใหม่',
        'context' => 'primary',
        'url' => array('create'),
        'buttonType' => 'link',
    ))
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'รีเซ็ตผู้ใช้ใหม่',
        'context' => 'danger',
        'url' => array('reset'),
        'buttonType' => 'link',
        'visible' => YII_DEBUG,
        'htmlOptions' => array(
            'onclick' => 'return confirm("ต้องการ รีเซ็ต ข้อมูลผู้ใช้งานระบบ ?")',
        ),
    ))
    ?>


</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'username',
            'value' => 'CHtml::link($data->username,array("view","id" => $data->id))',
            'type' => 'raw',
        ),
        array(
            'name' => 'email',
        ),
        array(
            'name' => 'role_id',
            'value' => 'CHtml::value($data,"roleName")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'last_login',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'visible' => '!$data->isSuperUser',
                ),
            ),
        ),
    ),
));
?>