<?php echo Helper::htmlTopic('จัดการรูปภาพหรือวีดีโอ', 'แสดงรายการรูปภาพหรือวีดีโอ'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));
?>
<?php echo $form->hiddenField($model, 'index'); ?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลรูปภาพหรือวีดีโอ',
));
$i =  $model->index;
?>

<div class="form-group">
   <div class="col-md-3"></div>
   <div class="col-md-3">
      <?php echo $form->hiddenField($model, 'web_slider_index'); ?>
      <label class="control-label">
         <?php echo 'ลำดับที่ ' . WebSlider::getIndex($i);?>
      </label>
   </div>

</div>
<?php
         echo $form->fileFieldGroup($model, 'web_slider' , array(
             'hint' => 'ขนาดความสูง 150px ขนาดความกว้าง 768px',
         ));
?>

<div class="form-group">
   <div class="col-md-8 col-md-offset-3">
      <?php if(WebSlider::hasData($i)): ?>
      <?php if(WebSlider::isImage($i)): ?>
      <?php echo CHtml::image(WebSlider::getAssetUrl($i) . '?_=' . time(), '', array('style' => 'max-width: 768px;')); ?>
      <?php else: ?>
      <video width="768" height="150" controls>
         <source src="<?php echo WebSlider::getAssetUrl($i) ?>">
      </video>
      <?php endif ?>
      <?php endif ?>
   </div>
   <div class="col-md-1 text-right">
      <?php if(WebSlider::hasData($i)): ?>
      <div>
         <?php
               echo CHtml::ajaxLink('X',Yii::app()->createUrl('administrator/webSlider/delete'),
               array(
                   'type'=>'get',
                   'data'=> array('index' => $i,
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
<?php echo $form->textFieldGroup($model, 'web_slider_url' ); ?>
<?php
         echo $form->radioButtonListGroup($model, 'web_slider_is_visible', array(
            'widgetOptions' => array(
               'data' => WebSlider::getIsVisibleOptions(),
            ),
      ));
?>
<div class="form-group">
   <div class="col-md-9 col-md-offset-3">
      <?php
      Helper::buttonSubmit('บันทึกข้อมูล', array(
          'htmlOptions' => array(
              'class' => 'pull-right',
              'id'=>'btnSubmit'
          ),
      ));
      ?>
      <?php echo Helper::buttonBack(array('index')); ?>
   </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

