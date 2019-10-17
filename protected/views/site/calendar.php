<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.print.css', 'print'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/fullcalendar-2.4.0/lib/moment.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/fullcalendar-2.4.0/fullcalendar.min.js'); ?>
<?php if (Yii::app()->language === 'th'): ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/fullcalendar-2.4.0/lang/th.js'); ?>
<?php endif; ?>
<div class="row">
    <div class="col-md-8">
        <div class="topic"><?php echo Helper::t('Examination Schedule', 'ปฏิทินการสอบ'); ?></div>
        <div id="calendar"></div>
    </div>
    <div class="col-md-4">
        <div class="topic">Details</div>
        <div id="exam-form-loader" class="hide text-center">
            <?php echo CHtml::image(Yii::app()->baseUrl . '/images/ajax-loader.gif'); ?>
        </div>
        <div id="exam-form"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            'editable': false,
            'startEditable': false,
            'durationEditable': false,
            eventSources: [
                {
                    url: '<?php echo $this->createUrl('feed'); ?>',
                }
            ],
            eventClick: function (event, jsEvent, view) {
                console.log('s:' + event.date_start + '|| e:' + event.date_end);
                if ($.inArray('event-joinable', event.className) !== -1) {
                    return false;
                }
                if ($.inArray('event-exam', event.className) !== -1) {
                    $('#exam-form-loader').removeClass('hide');
                    $('#exam-form').addClass('hide');
                    if (event.description) {
                        $('#base-modal .modal-content').html('<div class="modal-header bg-primary"><h4 class="modal-title">รอบสอบ : '+ event.title +'</h4></div><div class="modal-body"><strong>หมายเหตุ : </strong>' + event.description + '</div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">ปิด</button></div>');
                        $('#base-modal').modal('show');
                    }
                    $.get('<?php echo $this->createUrl('clickEvent'); ?>', {id: event.id}, function (data) {
                        $('#exam-form-loader').addClass('hide');
                        $('#exam-form').html(data).removeClass('hide');
                    });
                }
            },
            eventRender: function (event, element) {
                if ($(element).hasClass('event-expired')) {
                    return;
                }
                if ($(element).hasClass('event-joinable')) {
                    return;
                }
                if ($(element).hasClass('event-exam')) {
                    if (event.description) {
                        $(element).tooltip({title: event.description, container: "body"});
                    } else {
                        $(element).attr("title", "คลิ๊กเพื่อสมัครสอบ");
                        element.tooltip();
                    }
                }

            },
            eventAfterAllRender: function (view, element) {
<?php if (Yii::app()->language === 'th'): ?>
                    var oldYear = $(".fc-toolbar").find(".fc-left").text();
                    oldYear = $.trim(oldYear);
                    var oldY = oldYear.substr(-4);
                    var newY = parseInt(oldY) + 543;
                    oldYear = oldYear.replace(oldY, newY);
                    $(".fc-toolbar").find(".fc-left").find("h2").text(oldYear);
<?php endif; ?>
            },
        });
    });
</script>