<?php $this->beginContent('_menu'); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'data-grid',
    'htmlOptions' => array(
        'class' => 'grid-view no-padding',
    ),
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{on} {off}',
            'buttons' => array(
                'on' => array(
                    'icon' => 'star',
                    'url' => 'array("#")',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                    'visible' => '$data->isDefault',
                ),
                'off' => array(
                    'label' => 'คลิกเพื่อเลือกเป็นผู้รับเงินหลัก',
                    'icon' => 'star-empty',
                    'url' => 'array("setPrimary","id" => $data->id)',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '#data-grid',
                    ),
                    'visible' => '!$data->isDefault',
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'name',
            'editable' => array(
                'url' => array('recipientUpdate'),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'position',
            'editable' => array(
                'url' => array('recipientUpdate'),
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'array("recipientDelete","id" => $data->id)',
        ),
    ),
));
?>
<hr/>
<h4 class="fancy">เพิ่มรายชื่อผู้รับเงิน</h4>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->textFieldGroup($newModel, 'name'); ?>
<?php echo $form->textFieldGroup($newModel, 'position'); ?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>