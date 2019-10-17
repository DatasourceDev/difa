<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-qr',
    'focus' => array($application, 'desk_code'),
        ));
?>
<div class="well well-sm" style="margin-top:8px;">
   ลงทะเบียนเข้าห้องสอบด้วย QRCODE/ID : <?php echo $form->textField($application, 'desk_code'); ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'rowCssClassExpression' => 'isset($data->presentPreventSchedule) ? "bg-danger" : ""',
    'afterAjaxUpdate' => 'js:function(){
            selectData();
            }',
    'columns' => array(
        array(
            'header' => 'เลขที่นั่งสอบ',
            'name' => 'desk_no',
            'value' => '$data->isPaid ? str_pad($data->desk_no,3,"0",STR_PAD_LEFT) : "-"',
            'type' => 'text',
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
            'value' => '
                CHtml::link(CHtml::value($data,"fullnameTh"),array("manageMember/certificate","id" => $data->account_id),array("target" => "_blank")) ." ".
                CHtml::link(Helper::glyphicon("edit"),array("updateInfo","id" => $data->id),array("class" => "btn-ajax-modal text-small pull-right","data-modal-size" => "large")) .
                ($data->isPresent ? "" : CHtml::link(Helper::glyphicon("log-in"),array("doPresent","id" => $data->id),array("class" => "btn-ajax-modal text-small pull-right","data-modal-size" => "large", "style" => "margin:0px 5px;", "title" => "ลงทะเบียนเข้าสอบ"))) .
                "<div><small class=\"text-muted\">". CHtml::value($data,"department") ."</small></div>"',
            'type' => 'raw',
        ),
        array(
            'header' => 'รหัสประจำตัว',
            'name' => 'account_id',
            'value' => 'CHtml::value($data,"account.entry_code")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ประเภทการสมัคร',
            'name' => 'apply_type',
            'value' => 'CHtml::value($data,"htmlApplyTypeWithDepartment") . "<small class=\"text-muted\">". Yii::app()->format->formatDateShort($data->created) ."</small>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'exam_schedule_objective_id',
            'value' => 'CHtml::value($data,"textObjective")',
            'type' => 'text',
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
            'value' => 'CHtml::value($data,"is_paid") === ActiveRecord::YES ? Helper::htmlSignSuccess() : CHtml::link(Helper::htmlSignFail(),"#",array("data-toggle" => "tooltip" , "title" => "หมดเขตชำระ " . $data->dueDate))',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ลงทะเบียน',
            'name' => 'is_present',
            'value' => 'CHtml::value($data,"is_present") === ActiveRecord::YES ? $data->getHtmlPresent() : (isset($data->presentPreventSchedule) ? Helper::htmlSignWarning("ไม่สามารถลงทะเบียนเข้าสอบได้เนื่องจาก ได้ลงทะเบียนสอบในรอบ " . $data->presentPreventSchedule->textExamCode . " แล้ว") : Helper::htmlSignFail())',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'R',
            'value' => 'CHtml::value($data->getExamSetBySubject("R"),"grade")',
            'visible' => $model->hasSkill('R'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'L',
            'value' => 'CHtml::value($data->getExamSetBySubject("L"),"grade")',
            'visible' => $model->hasSkill('L'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'W',
            'value' => 'CHtml::value($data->getExamSetBySubject("W"),"grade")',
            'visible' => $model->hasSkill('W'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'S',
            'value' => 'CHtml::value($data->getExamSetBySubject("S"),"grade")',
            'visible' => $model->hasSkill('S'),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'บาร์โค๊ด',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{print}',
            'buttons' => array(
                'print' => array(
                    'label' => 'พิมพ์บาร์โค๊ด',
                    'icon' => 'print',
                    'url' => 'array("reportBarcode/print","ids" => array($data->id))',
                    'options' => array(
                        'class' => 'btn-print-barcode',
                    ),
                ),
            ),
        ),
        array(
            'header' => 'ยกเลิก',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'label' => 'ยกเลิก',
                    'url' => 'array("attendeeCancel","id" => $data->id)',
                    'visible' => '$data->isPaid ? ($data->payment_amount == 0 ? true : false) : true',
                ),
            ),
        ),
    ),
));
?>
<?php $this->widget('qz.widgets.QzPrintInfo'); ?>
<?php $this->endContent(); ?>
<script type="text/javascript">
   var desk = '';
   var loading = false;

   $(document).ready(function () {
      loading = false;
      $(document).on('keypress', function () {
         var f = document.querySelector(':focus');
         if (f === null) {
            $('#ExamApplication_desk_code').select();
         }
      });
      $(document).on('keyup', function () {
         if ($('#ExamApplication_desk_code').val() != null) {
            if ($('#ExamApplication_desk_code').val().length == 13 | $('#ExamApplication_desk_code').val().length == 28) {
               onScan();
            }
         }
      });


      $(document).on('click', '.btn-print-barcode', function () {
         var d = new Date();
         $.post($(this).attr('href'), { t: d.getTime() }, function (data) {
            console.log(data);
            qz.append(data);
            qz.print();
         });
         return false;
      });

      $('#frm-qr').on('submit', function () {
        return onScan();
         //if ($('#ExamApplication_desk_code').val()) {
         //   $.post($(this).attr('action'), $(this).serialize(), function (data) {
         //      if (data.result) {
         //         $('.grid-view').yiiGridView('update');
         //      }

         //      alert(data.description);
         //      desk = data.deskCode;
         //      if (desk != undefined && desk != '' && desk.indexOf(' ')) {
         //         var arr = desk.split(' ');
         //         if (arr.length > 0) {
         //            desk = arr[0];
         //         }
         //      }
         //      ///setTimeout(selectData(desk), 2000, data.deskCode);
         //      $('#frm-qr input').val('');
         //      $('#frm-qr input').select();
         //   }, 'json');
         //}
         //return false;
      });
   });

   function onScan() {
      var form = $('form');
      if ($('#ExamApplication_desk_code').val()) {
         if (loading == false) {
            loading = true;
            $.post(form.attr('action'), form.serialize(), function (data) {
               if (data.result) {
                  $('.grid-view').yiiGridView('update');
               }

               alert(data.description);
               desk = data.deskCode;
               if (desk != undefined && desk != '' && desk.indexOf(' ')) {
                  var arr = desk.split(' ');
                  if (arr.length > 0) {
                     desk = arr[0];
                  }
               }
               $('#frm-qr input').val('');
               $('#frm-qr input').select();
               loading = false;
            }, 'json');
         }

      }
      return false;
   }

   function selectData() {
      if (desk != undefined && desk != '') {
         $(window).scrollTop($(".grid-view tr td:contains(" + desk + ")").position().top - 60);
         $(".grid-view tr td:contains(" + desk + ")").parent().addClass('selected');
      }
   }
</script>