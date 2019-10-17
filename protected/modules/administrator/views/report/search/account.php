<?php $this->beginContent('/layouts/wrapper/searchBox'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<?php
echo $form->textFieldGroup($model, 'search[username]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'เลขบัตรประชาชน/รหัสประจำตัว',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[firstname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชื่อ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[lastname]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'นามสกุล',
    ),
));
?>
<?php if ($this->id == 'reportPasswordChange'): ?>
    <?php
    echo $form->dropDownListGroup($model, 'is_legacy_update', array(
        'widgetOptions' => array(
            'data' => array(
                '1' => 'เปลี่ยนแล้ว',
                '0' => 'ยังไม่ได้เปลี่ยน',
            ),
            'htmlOptions' => array(
                'prompt' => '(ทั้งหมด)',
            ),
        ),
        'labelOptions' => array(
            'label' => 'สถานะ',
        ),
    ));
    ?>
<?php endif; ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'buttonType' => 'submit',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>