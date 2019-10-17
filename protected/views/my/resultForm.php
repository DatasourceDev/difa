
<div class="topic">
   <?php echo Helper::t('Result', 'รายละเอียดการขอใบรับรองผลการสอบใหม่'); ?>
</div>
<?php
$form = $this->beginWidget('ResultForm', array(
    'type' => 'horizontal',
    'formSize' => 'small',
    'htmlOptions' => array(
        'id' => 'frm-register',
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<div id="form-result">
   <div class="row">
      <div class="col-md-10">
         <?php
         echo $form->textFieldGroup($model, 'name', array(
             'widgetOptions' => array(
                 'htmlOptions' => array(
                     'placeholder' => '',
                 ),
             ),
         ));
         ?>
         <?php
         echo $form->textFieldGroup($model, 'id_card', array(
             'widgetOptions' => array(
                 'htmlOptions' => array(
                     'placeholder' => '',
                 ),
             ),
         ));
         ?>
         <?php
         echo $form->textFieldGroup($model, 'tel', array(
             'widgetOptions' => array(
                 'htmlOptions' => array(
                     'placeholder' => '',
                 ),
             ),
         ));
         ?>
      </div>
   </div>
   <?php echo $form->hiddenField($model, 'exam_application_id'); ?>
   <?php echo $form->hiddenField($model, 'exam_schedule_id'); ?>
   <?php echo $form->hiddenField($model, 'is_request'); ?>
   <?php echo $form->hiddenField($model, 'member_id'); ?>
   <div class="row">
      <div class="col-md-10">
         <div class="form-group">
            <?php echo $form->labelEx($model, 'request_number', array('class' => 'control-label col-sm-3')); ?>
            <div class="col-sm-9">
               <div class="form-inline">
                  <div class="form-group">
                     <?php echo $form->textField($model, 'request_number', array('class' => 'form-control input-numeric', 'style' => 'width:150px;', 'placeholder' => '', 'maxlength' => '9')); ?>
                  </div>
                  <div class="form-group">
                     <label class="control-label">
                        ฉบับ (ฉบับละ 100 บาท) เป็นเงิน
                        <span id="lblcal">100</span> บาท
                     </label>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-10">
         <?php echo $form->radioButtonListGroup($model, 'request_delivery_type', array(
            'widgetOptions' => array(
            'data' => $model->getDeliveryType(),
            ),
         ));
         ?>

         <div id="divAddress" style="display:none;">
            <?php echo $form->textFieldGroup($model, 'address', array(
                   'widgetOptions' => array(
                       'htmlOptions' => array(
                           'placeholder' => '',
                       ),
                   ),
                  'labelOptions' => array(
                        'label' => 'ที่อยู่ในการจัดส่งใบรับรอง',
                  ),
               ));
            ?>
         </div>

      </div>
   </div>
   <div class="row">
      <div class="col-md-10">
         <div class="col-sm-3"></div>
         <div class="col-sm-9">
            <!--<p>
               ดาวน์โหลดใบชำระค่าธรรมเนียม <?php echo CHtml::link('คลิ๊กที่นี่', array('PrintCerSlip'), array('target' => '_blank')) ?>
               <a></a>
            </p>-->
            <p>เมื่อชำระค่าธรรมเนียมแล้วโปรดส่งหลักฐานการชำระเงินให้สถาบันการต่างประเทศฯ ที่ Email : difates.thailand@gmail.com หรือ โทรสาร 02 143 9326</p>
         </div>
      </div>
   </div>
</div>
<div class="btn-toolbar well">
   <?php
   $this->widget('booster.widgets.TbButton', array(
       'label' => Helper::t('Submit', 'ขอใบรับรอง'),
       'buttonType' => 'submit',
       'context' => 'primary',
       'htmlOptions' => array(
           'class' => 'pull-right',
           'onclick' => 'return confirm("ต้องการที่จะขอใบรับรองใหม่?")',
       ),
   ));
   ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
   $(document).ready(function () {
      if ($('#ExamApplicationResult_request_delivery_type_0').get(0).checked == true | $('#ExamApplicationResult_request_delivery_type_1').get(0).checked == true)
         $('#divAddress').show();
      else
         $('#divAddress').hide();

      $('#ExamApplicationResult_request_number').change(function () {
         var num = parseInt($('#ExamApplicationResult_request_number').val());
         if (isNaN(num))
            $('#lblcal').text(100)
         else
            $('#lblcal').text(num * 100);
      });
      $('#ExamApplicationResult_request_delivery_type_0, #ExamApplicationResult_request_delivery_type_1, #ExamApplicationResult_request_delivery_type_2').change(function () {
         if ($('#ExamApplicationResult_request_delivery_type_0').get(0).checked == true | $('#ExamApplicationResult_request_delivery_type_1').get(0).checked == true) {
            $('#divAddress').show();
         }
         else
            $('#divAddress').hide();
      });

   });
</script>
