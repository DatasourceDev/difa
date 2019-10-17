
<h3 class="fancy">ภาพรวมของระบบรับสมัคร</h3>
<div class="row">
   <div class="col-sm-3">
      <div class="info-box bg-primary">
         <div class="info-box-content text-center">
            <div>รอบสอบถัดไป</div>
            <?php if (isset($nextSchedule)): ?>
            <h2>
               <?php echo CHtml::link(CHtml::value($nextSchedule, 'exam_code'), array('manageSchedule/view', 'id' => $nextSchedule->id), array('class' => 'text-white')); ?>
            </h2>
            <small>
               วันที่ <?php echo CHtml::value($nextSchedule, 'db_date'); ?>
            </small>
            <?php else: ?>
            <h2 class="text-white">-</h2>
            <small>-</small>
            <?php endif; ?>
         </div>
      </div>
   </div>
   <div class="col-sm-3">
      <div class="info-box bg-info">
         <div class="info-box-content text-center">
            <div>จำนวนสมาชิกทั้งหมด</div>
            <h2 class="text-info">
               <?php echo Yii::app()->format->formatNumber($countAccount); ?>
            </h2>
            <small>ราย</small>
         </div>
      </div>
   </div>
   <div class="col-sm-3">
      <div class="info-box bg-warning">
         <div class="info-box-content text-center">
            <div>Border Line ที่รอตรวจ</div>
            <h2 class="text-warning">
               <?php echo Yii::app()->format->formatNumber($countBorderline); ?>
            </h2>
            <small>ราย</small>
         </div>
      </div>
   </div>
   <div class="col-sm-3">
      <div class="info-box bg-danger">
         <div class="info-box-content text-center">
            <div>จำนวนรอบสอบ</div>
            <h2 class="text-danger">
               <?php echo Yii::app()->format->formatNumber($countSchedule); ?>
            </h2>
            <small>รอบ</small>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-6">
      <h3 class="fancy">รายการผู้สมัครสมาชิกล่าสุด</h3>

      <?php
      $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
          'type' => 'horizontal',
          'id' => 'latest-search',
      ));
      ?>
      <div class="well wel-sm">
         <?php
         echo $form->dropDownListGroup($account, 'status', array(
             'widgetOptions' => array(
                 'data' => Account::getStatusOptions(),
                 'htmlOptions' => array(
                     'prompt' => '(ทุกสถานะ)',
                 ),
             ),
         ));
         ?>
      </div>
      <?php $this->endWidget(); ?>
      <?php
      $this->widget('booster.widgets.TbGridView', array(
          'id' => 'latest-grid',
          'dataProvider' => $accountProvider,
          'columns' => array(
              array(
                  'header' => 'รหัส',
                  'name' => 'entry_code',
                  'value' => 'CHtml::link($data->entry_code,array("manageMember/goto","id" => $data->id))',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
              array(
                  'header' => 'ชื่อ-นามสกุล',
                  'value' => 'CHtml::value($data,"profile.fullname")',
                  'type' => 'text',
              ),
              array(
                  'header' => 'ประเภท',
                  'name' => 'account_type_id',
                  'value' => 'CHtml::value($data,"accountType.name_th")',
                  'type' => 'text',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'visible' => false,
              ),
              array(
                  'header' => 'สถานะ',
                  'name' => 'status',
                  'value' => 'CHtml::value($data,"status") === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess("ยืนยันการสมัครแล้ว") : Helper::htmlSignFail("ยังไม่ได้ยืนยันการสมัคร")',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
              array(
                  'class' => 'ext.codesk.widgets.CodeskButtonColumn',
                  'template' => '{confirm} {envelope}',
                  'buttons' => array(
                      'confirm' => array(
                          'label' => 'ยืนยัน',
                          'icon' => 'ok-sign',
                          'url' => 'array("manageMember/setConfirm","id" => $data->id)',
                          'visible' => '$data->status === Account::STATUS_NEW',
                          'options' => array(
                              'class' => 'btn-ajax',
                          ),
                      ),
                      'envelope' => array(
                          'label' => 'ส่งจดหมายยืนยันอีกครั้ง',
                          'icon' => 'envelope',
                          'url' => 'array("manageMember/resendConfirmationMail","id" => $data->id)',
                          'visible' => '$data->status === Account::STATUS_NEW',
                          'options' => array(
                              'class' => 'btn-ajax',
                          ),
                      ),
                  ),
              ),
          ),
      ));
      ?>
   </div>
   <div class="col-md-6">
      <h3 class="fancy">รายการผู้สมัครสอบล่าสุด</h3>
      <?php
      $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
          'type' => 'horizontal',
          'id' => 'apply-search',
      ));
      ?>
      <div class="well wel-sm">
         <?php
         echo $form->dropDownListGroup($application, 'is_paid', array(
             'widgetOptions' => array(
                 'data' => ExamApplication::getPaymentStatusOptions(),
                 'htmlOptions' => array(
                     'prompt' => '(ทุกสถานะ)',
                 ),
             ),
             'labelOptions' => array(
                 'label' => 'การชำระเงิน',
             ),
         ));
         ?>
      </div>
      <?php $this->endWidget(); ?>
      <?php
      $this->widget('booster.widgets.TbGridView', array(
          'id' => 'apply-grid',
          'dataProvider' => $applicationProvider,
          'columns' => array(
              array(
                  'header' => 'รหัส',
                  'name' => 'account_id',
                  'value' => 'CHtml::link(CHtml::value($data,"account.username"),array("manageMember/goto","id" => $data->account_id))',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
              array(
                  'header' => 'ชื่อ-นามสกุล',
                  'name' => 'account_id',
                  'value' => 'CHtml::value($data,"account.profile.fullname")',
                  'type' => 'text',
              ),
              array(
                  'header' => 'รอบสอบ',
                  'name' => 'exam_schedule_id',
                  'value' => 'CHtml::link(CHtml::value($data,"examSchedule.exam_code"),array("manageSchedule/view","id" => CHtml::value($data,"exam_schedule_id")))',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
              array(
                  'header' => 'SMS',
                  'name' => 'is_sms',
                  'value' => 'CHtml::value($data,"is_sms") === ActiveRecord::YES ? Helper::htmlSignSuccess("สมัคร") : Helper::htmlSignFail("ไม่ได้สมัคร")',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
              array(
                  'header' => 'ชำระเงิน',
                  'name' => 'is_paid',
                  'value' => 'CHtml::value($data,"is_paid") === ActiveRecord::YES ? Helper::htmlSignSuccess("ชำระเงินเรียบร้อย") : Helper::htmlSignFail("ยังไม่ได้ชำระเงิน")',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
          ),
      ));
      ?>
   </div>
</div>
<hr />
<h3 class="fancy">รายการผู้ขอใบรับรองใหม่</h3>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export-2',
    'type' => 'horizontal',
    'action' => array('print'),
    'method' => 'get',
    'htmlOptions' => array(
        'target' => '_blank',
    ),
        ));
?>
<div class="well well-sm">
   <?php echo CHtml::hiddenField('items'); ?>
   <?php
   $this->widget('booster.widgets.TbButton', array(
       'label' => 'พิมพ์ใบรับรอง',
       'icon' => 'print',
       'context' => 'info',
       'buttonType' => 'submit',
       'htmlOptions' => array(
           'id' => 'btn-export',
       ),
   ));
   ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'result-grid',
    'dataProvider' => $requestResultProvider,
    'selectableRows' => 2,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),

        //array(
        //    'name' => 'desk_no',
        //    'value' => 'CHtml::value($data,"examApplication.desk_no")',
        //    'headerHtmlOptions' => array(
        //        'class' => 'text-center',
        //    ),
        //    'htmlOptions' => array(
        //        'class' => 'text-center',
        //    ),
        //),
        array(
            'header' => 'รหัส',
            'name' => 'account_id',
            'value' => 'CHtml::link(CHtml::value($data,"id_card"),array("manageMember/goto","id" => $data->member_id))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                  'class' => 'text-center',
            ),
            'htmlOptions' => array(
                  'class' => 'text-center',
            ),
         ),
        array(
            'header' => 'วันที่ขอ',
            'type' => 'datetime',
            'value' => 'CHtml::value($data,"request_date")',
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'name',
            'value' => 'CHtml::value($data,"name")',
            'type' => 'text',
        ),
        array(
                  'header' => 'รอบสอบ',
                  'name' => 'exam_schedule_id',
                  'value' => 'CHtml::link(CHtml::value($data,"examSchedule.exam_code"),array("manageSchedule/view","id" => CHtml::value($data,"exam_schedule_id")))',
                  'type' => 'raw',
                  'headerHtmlOptions' => array(
                      'class' => 'text-center',
                  ),
                  'htmlOptions' => array(
                      'class' => 'text-center',
                  ),
              ),
        array(
            'header' => 'จำนวนใบรับรอง',
            'value' => 'CHtml::value($data,"request_number")',
        ),
       array(
            'header' => 'เป็นเงิน',
            'value' => 'CHtml::value($data,"request_number") * 100 ',
        ),
      array(
            'header' => 'การมารับใบรับรอง',
            'value' => 'ExamApplicationResult::getStatusDeliveryType(CHtml::value($data,"request_delivery_type"))',
        ),
      array(
            'header' => 'ที่อยู่จัดส่ง',
            'value' => 'ExamApplicationResult::getAddress(CHtml::value($data,"request_delivery_type"),CHtml::value($data,"address"))',
        ),

        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
                'style' => 'width:65px;',
            ),
            'template' => '{active}{inactive}',
            'buttons' => array(
                'active' => array(
                    'label' => 'เปลี่ยนสถานะยืนยันการรับใบรับรอง',
                    'icon' => 'exclamation-sign',
                    'click' => 'js:function(){if(confirm("ยืนยันการเปลี่ยนสถานะ?")){$(this).attr("data-original-title","ออกใบรับรองเรียบร้อยแล้ว") ; $(this).removeClass("text-danger"); $(this).addClass("text-success"); $(this).find(".glyphicon").removeClass("glyphicon-exclamation-sign");$(this).find(".glyphicon").addClass("glyphicon-ok-sign");}else{return false;}}',
                    'url' => 'array("acceptPrintResult", "id" => CHtml::value($data, "id"))',
                    'visible' => '$data->is_request',
                    'options' => array(
                        'class' => 'btn-ajax-post text-danger',
                        'data-grid-update' => '#data-grid',
                    ),
                ),
                'inactive' => array(
                    'label' => 'ขอใบรับรองใหม่สำเร็จ',
                    'icon' => 'ok-sign',
                    'visible' => '!$data->is_request',
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
   $(document).ready(function () {
      $('#frm-export-2').submit(function () {
         var items = $('#result-grid').yiiGridView('getSelection');
         if (items.length) {
            $('#items', this).val(items);
            return true;
         } else {
            alert('กรุณาเลือกรายการที่ต้องการพิมพ์');
            return false;
         }

      });
   });
</script>
<hr />
<h3 class="fancy">รายการผู้เปลี่ยนชื่อ</h3>
<?php
$this->renderPartial('/profileHistory/grid', array(
    'dataProvider' => $changeNameHistoryProvider,
));
?>
<h3 class="fancy">รายการผู้แก้ไขประวัติการทำงาน</h3>
<?php
$this->renderPartial('/profileHistory/grid', array(
    'dataProvider' => $changeDepartmentHistoryProvider,
));
?>
<h3 class="fancy">รายการผู้เปลี่ยนประเภทสมาชิก</h3>
<?php
$this->renderPartial('/profileHistory/grid', array(
    'dataProvider' => $changeTypeHistoryProvider,
));
?>
<hr />
<h3 class="fancy">
   รายการผู้สมัครชาวต่างชาติที่มีแนวโน้มที่จะมีบัญชีซ้ำซ้อน
   <small>
      <?php echo CHtml::link('[แสดงทั้งหมด]', array('memberAccountDuplicate/index')); ?>
   </small>
</h3>
<?php
$this->renderPartial('/memberAccountDuplicate/shared/grid', array(
    'dataProvider' => $duplicateProvider,
));
?>
<hr />
<h3 class="fancy">
   ข้อความจากสมาชิกที่ยังไม่ได้ตอบกลับ
   <small>
      <?php echo CHtml::link('[แสดงทั้งหมด]', array('accountInquiry/index')); ?>
   </small>
</h3>
<?php
$this->renderPartial('/accountInquiry/shared/grid', array(
    'dataProvider' => $inquiryProvider,
));
?>
<script type="text/javascript">
   $(document).ready(function () {
      $('#latest-search').change(function () {
         $('#latest-grid').yiiGridView('update', { data: $('#latest-search').serialize() });
         return false;
      });

      $('#apply-search').change(function () {
         $('#apply-grid').yiiGridView('update', { data: $('#apply-search').serialize() });
         return false;
      });
   });
</script>