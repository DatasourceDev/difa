<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'เมนูเว็บไซต์',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<?php echo $form->textFieldGroup($model, 'name_en'); ?>
<?php
echo $form->dropDownListGroup($model, 'is_dropdown', array(
    'widgetOptions' => array(
        'data' => WebMenu::getIsDropDownOptions(),
        'htmlOptions' => array(
            'class' => 'input-update',
            'data-target' => '#url-pane',
        ),
    ),
));
?>
<div id="url-pane">
    <?php if ($model->is_dropdown == WebMenu::NO): ?>
        <?php echo $form->textFieldGroup($model, 'url'); ?>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <?php
                $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                    'config' => array(
                        'action' => array('upload'),
                        'allowedExtensions' => Helper::getAllowedFileExtension(),
                        'sizeLimit' => Helper::getMaxFileSize(),
                        'onComplete' => 'js:function(id, fileName, responseJSON){
                            console.log("uploaded a file.");
                        $("#WebMenu_url").val("' . Yii::app()->baseUrl . '/uploads/tmp/" + fileName);
                   }',
                    ),
                ));
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
echo $form->dropDownListGroup($model, 'bizrule', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamType::model()->findAll(), 'code', 'name'),
        'htmlOptions' => array(
            'prompt' => '(แสดงในทุกๆหน้า)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'แสดงเฉพาะประเภทสอบ',
    ),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'account_class', array(
    'widgetOptions' => array(
        'data' => WebMenu::getAccountClassOptions(),
    ),
    'labelOptions' => array(
        'label' => 'แสดงเฉพาะประเภทบัญชี',
    ),
));
?>
<?php
echo $form->radioButtonListGroup($model, 'account_nation', array(
    'widgetOptions' => array(
        'data' => WebMenu::getAccountNationOptions(),
    ),
    'labelOptions' => array(
        'label' => 'แสดงเฉพาะประเภทสัญชาติ',
    ),
));
?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>