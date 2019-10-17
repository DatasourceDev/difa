<?php echo Helper::htmlTopic('จัดการที่อยู่ติดต่อ', 'แสดงรายการที่อยู่ติดต่อ'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลที่อยู่ติดต่อ',
));
?>
<?php if(isset($model->googlemap)): ?>
<div class="form-group">
    <div class="col-md-8 col-md-offset-3">
        <iframe src="<?php echo $model->googlemap ?>" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</div>
<?php endif ?>

<?php echo $form->textFieldGroup($model, 'googlemap'); ?>
<div class="form-group">
    <div class="col-md-8 col-md-offset-3">
        <?php if(isset($model->map_src)): ?>
        <?php echo $model->map_src ?>
        <?php endif ?>
    </div>
    <div class="col-md-1 text-right">
      <?php if(isset($model->map_src)): ?>
      <div>
        <?php 
        echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webContactUs/deleteImage'),
        array(
            'type'=>'get',
            'data'=> array(
                'PHPSESSID' => session_id(), 'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
            ),
            'success' => 'js:function(data){location.reload(true);}'
        ),array(
            'class'=>'btn btn-danger small-btn',
            'confirm'=>'ต้องการที่จะลบรูป?'
        ));
        ?>
      </div>
      <?php endif ?>
    </div>
</div>
<?php
echo $form->fileFieldGroup($model, 'map_src');
?>
<?php
echo $form->redactorGroup($model, 'address', array(
    'widgetOptions' => array(
        'editorOptions' => array(
            
        ),
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'tel'); ?>
<?php echo $form->textFieldGroup($model, 'fax'); ?>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>