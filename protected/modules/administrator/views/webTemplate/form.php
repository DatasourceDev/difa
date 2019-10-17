<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));
?>

<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => $model->theme_name,
));
?>
<?php
echo $form->textFieldGroup($model, 'desc');
?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การจัดการส่วนพื้นหลัง',
));
?>
<?php echo $form->fileFieldGroup($model, 'header_bgSrc'); ?>
<?php if(isset($model->header_bgSrc)):?>
<div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
        <?php echo CHtml::image(WebTemplateForm::getUploadURL($model->theme_name, $model->header_bgSrc) . '?_=' . time(), '', array('width' => '100%')); ?>
    </div>
 <div class="col-md-1 text-right">
        <?php 
        echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webTemplate/deleteImage'),
        array(
            'type'=>'get',
            'data'=> array('field' => 'header_bgSrc', 'theme' => $model->theme_name,
                'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
            ),
            'success' => 'js:function(data){location.reload(true);}'
        ),array(
            'class'=>'btn btn-danger small-btn',
            'confirm'=>'ต้องการที่จะลบรูป?'
        ));
        ?>
        </div>
</div>
<?php endif ?>
<?php
echo $form->colorPickerGroup($model, 'header_bgColor');
?>


<?php echo $form->fileFieldGroup($model, 'body_bgSrc'); ?>
<?php if(isset($model->body_bgSrc)):?>
<div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
        
        <?php echo CHtml::image(WebTemplateForm::getUploadURL($model->theme_name, $model->body_bgSrc) . '?_=' . time(), '', array('width' => '100%')); ?>
    </div>
 <div class="col-md-1 text-right">
        <?php 
        echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webTemplate/deleteImage'),
        array(
            'type'=>'get',
            'data'=> array('field' => 'body_bgSrc', 'theme' => $model->theme_name,
                'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
            ),
            'success' => 'js:function(data){location.reload(true);}'
        ),array(
            'class'=>'btn btn-danger small-btn',
            'confirm'=>'ต้องการที่จะลบรูป?'
        ));
        ?>
        </div>

</div>
<?php endif ?>

<div style="display:none;">
<?php
echo $form->colorPickerGroup($model, 'body_bgColor');
?>

<?php echo $form->fileFieldGroup($model, 'menu_bgSrc'); ?>
<?php if(isset($model->menu_bgSrc)):?>
<div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
       
        <?php echo CHtml::image(WebTemplateForm::getUploadURL($model->theme_name, $model->menu_bgSrc) . '?_=' . time(), '', array('width' => '100%')); ?>
    </div>
    <div class="col-md-1 text-right">
   <?php 
           echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webTemplate/deleteImage'),
           array(
               'type'=>'get',
               'data'=> array('field' => 'menu_bgSrc', 'theme' => $model->theme_name,
                   'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
               ),
               'success' => 'js:function(data){location.reload(true);}'
           ),array(
               'class'=>'btn btn-danger small-btn',
               'confirm'=>'ต้องการที่จะลบรูป?'
           ));
           ?>
   </div>
</div>
<?php endif ?>
</div>


<?php
echo $form->colorPickerGroup($model, 'menu_bgColor');
?>

<?php echo $form->fileFieldGroup($model, 'subMenu_bgSrc'); ?>
<?php if(isset($model->subMenu_bgSrc)):?>
<div class="form-group">
    <div class="col-sm-8 col-sm-offset-3">
        <?php echo CHtml::image(WebTemplateForm::getUploadURL($model->theme_name, $model->subMenu_bgSrc) . '?_=' . time(), '', array('width' => '100%')); ?>
    </div>
 <div class="col-md-1 text-right">
<?php 
        echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webTemplate/deleteImage'),
        array(
            'type'=>'get',
            'data'=> array('field' => 'subMenu_bgSrc', 'theme' => $model->theme_name,
                'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
            ),
            'success' => 'js:function(data){location.reload(true);}'
        ),array(
            'class'=>'btn btn-danger small-btn',
            'confirm'=>'ต้องการที่จะลบรูป?'
        ));
        ?>
</div>

</div>
<?php endif ?>
<?php
echo $form->colorPickerGroup($model, 'subMenu_bgColor');
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'การจัดการตัวอักษร',
));
?>
<?php
echo $form->colorPickerGroup($model, 'heading_fontColor');
?>
<?php
echo $form->colorPickerGroup($model, 'menu_fontColor');
?>
<?php
echo $form->colorPickerGroup($model, 'subMenu_fontColor');
?>
<?php
echo $form->textFieldGroup($model, 'menu_fontSize', array(
    'append' => 'px',
));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'สีอักษรเมนูบาร์',
));
?>
<?php
echo $form->colorPickerGroup($model, 'menuLink_fontColor');
?>
<?php
echo $form->colorPickerGroup($model, 'menuHLink_fontColor');
?>
<?php
echo $form->colorPickerGroup($model, 'menuALink_bgColor');
?>
<?php $this->endWidget(); ?>
<?php
echo $form->textFieldGroup($model, 'subMenu_fontSize', array(
    'append' => 'px',
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
            'icon' => 'floppy-save',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php echo Helper::buttonBack(array('index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>