<?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.min.css'); ?>
<?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.print.css', 'print'); ?>
<?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/fullcalendar-2.4.0/lib/moment.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/fullcalendar-2.4.0/lang/th.js'); ?>

<form class="form-horizontal">
   <div class="row">
      <div class="col-md-8">
         <div class="well wel-sm">
            <div class="row">
               <div class="form-group">
                  <label class="col-sm-3 control-label">
                     <?php echo CHtml::value($this, 'label1'); ?>
                  </label>
                  <div class="col-md-5">
                     <div id='caljump'>
                        <select class="form-control" id='months'></select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <input type="text" id="years" class="form-control" />
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4"></div>
   </div>
</form>


<br />
<div class="row">
   <div class="col-md-8">
      <div id="calendar"></div>
   </div>
   <div class="col-md-4">
      <div id="exam-form-loader" class="hide text-center">
         <?php echo CHtml::image($this->module->assetUrl . '/images/ajax-loader.gif'); ?>
      </div>
      <div id="exam-form"></div>
   </div>
</div>
<script type="text/javascript">
var _url =  '<?php echo $this->createUrl('feed'); ?>';
var _urlclickDay = '<?php echo $this->createUrl('clickDay'); ?>';
var _urlclickEvent = '<?php echo $this->createUrl('clickEvent'); ?>';
</script>
<script type="text/javascript">
   var mNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

   $(document).ready(function () {
      var $months = $('#months');
      var $years = $('#years');
      var $calendar = $('#calendar');
      $('#calendar').fullCalendar({
         'editable': false,
         'startEditable': false,
         'durationEditable': false,
         eventSources: [
            {
               url: _url,
            }
         ],
         dayClick: function (date, jsEvent, view) {
            $('#exam-form-loader').removeClass('hide');
            $('#exam-form').addClass('hide');
            $.get(_urlclickDay, { d: date.format() }, function (data) {
               $('#exam-form-loader').addClass('hide');
               $('#exam-form').html(data).removeClass('hide');
            });
         },
         eventClick: function (event, jsEvent, view) {
            if ($.inArray('event-exam', event.className) !== -1) {
               $('#exam-form-loader').removeClass('hide');
               $('#exam-form').addClass('hide');
               $.get(_urlclickEvent, { id: event.id }, function (data) {
                  $('#exam-form-loader').addClass('hide');
                  $('#exam-form').html(data).removeClass('hide');
               });
            }
         },
         eventRender: function (event, element) {
            $(element).tooltip({ title: event.description, container: "body" });
         },
         eventAfterAllRender: function (view, element) {
            var oldYear = $(".fc-toolbar").find(".fc-left").text();
            oldYear = $.trim(oldYear);
            var oldY = oldYear.substr(-4);
            var newY = parseInt(oldY) + 543;
            oldYear = oldYear.replace(oldY, newY);
            $(".fc-toolbar").find(".fc-left").find("h2").text(oldYear);
         },
      });
      var currdate = $calendar.fullCalendar('getDate');

      var year = $('#years').val();
      if (year == null || year == '') {
         if (year < 2500) {
            $('#years').val(currdate.year() + 543);
         }
      }
      var initial = currdate.format('MM'); // where are we?
      var m = $calendar.fullCalendar('getDate');
      m.month(0);
      for (var i = 1; i < 13; i++) {
         var text = m.format('MMMM');
         var opt = document.createElement('option');
         opt.value = i;
         opt.text = m.format('MMMM');
         if (i == parseInt(initial))
            opt.selected = true; // current selection
         $months.append(opt);
         m.add(1, 'month');
      }

      $('#months, #years').on('change', function () {
         var month = $('#months').val();
         var year = parseInt($('#years').val());
         if (isNaN(year)) {
            $('#years').val(currdate.year() + 543);
            year = currdate.year();
         }
         if (year == null || year == '') {
            var date = $calendar.fullCalendar('getDate');
            year = date.year();
         }
         else if (year < 2000 | year > 2600) {
            $('#years').val(currdate.year() + 543);
            year = currdate.year();
         }
         else if (year > 2500) {
            year -= 543;
         }
         else if (year < 2500) {
            $('#years').val(year + 543);
         }
         var dd = year + '-' + month + '-' + '01';
         $calendar.fullCalendar('gotoDate', dd);
      });


   });
</script>