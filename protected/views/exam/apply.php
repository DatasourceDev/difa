<div class="topic"><?php echo Helper::t('Apply for', 'สมัครสอบ'); ?> <span class="text-success"><?php echo CHtml::value($exam, 'examCodeText'); ?></span></div>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php echo $form->errorSummary($model); ?>
<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo Helper::t('Type', 'ประเภท'); ?></label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo CHtml::value($exam, 'examType.name'); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo Helper::t('Skill', 'ทักษะ'); ?></label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo implode(', ', CHtml::listData(CHtml::value($exam, 'examScheduleItems'), 'examSubject.textName', 'examSubject.textName')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo Helper::t('Date', 'วันที่'); ?></label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo implode(', ', CHtml::listData(CHtml::value($exam, 'examScheduleItems'), 'textDateTime', 'textDateTime')); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo Helper::t('Registration Fee', 'ค่าธรรมเนียมการสอบ'); ?></label>
    <div class="col-sm-9">
        <div class="control-text">
            <?php echo Yii::app()->format->formatMoneyRoundText(CHtml::value($exam, 'register_fee')); ?>
        </div>
    </div>
</div>
<?php echo $form->textFieldGroup($model, 'capital_name'); ?>
<?php echo $form->textFieldGroup($model, 'capital_description'); ?>
<?php
echo $form->dropDownListGroup($model, 'exam_schedule_objective_id', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'prompt' => Helper::t('(Please select)', '(กรุณาเลือก)'),
        ),
        'data' => (Yii::app()->language === 'th' ? CHtml::listData($exam->examScheduleObjectives, 'id', 'name_th') : CHtml::listData($exam->examScheduleObjectives, 'id', 'name_en')) + array('0' => Helper::t('Other', 'อื่นๆ')),
    ),
));
?>
<div id="objective-pane">
    <?php
    echo $form->textFieldGroup($model, 'objective', array(
        'labelOptions' => array(
            'label' => Helper::t('Objective', 'ระบุวัตถุประสงค์'),
            'required' => true,
        ),
    ));
    ?>
</div>
<?php
echo $form->checkBoxGroup($model, 'is_sms', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'is_sms',
        ),
    ),
));
?>
<div id="sms-pane" style="display:none;">
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <div class="well">
                <ul>
                    <?php if (Yii::app()->language === 'th'): ?>
                        <li>เมื่อคุณสมัครรับข่าวสารผ่าน SMS คุณจะได้รับข้อความอย่างมาก 5 ข้อความ. โดยระบบจะคิดค่าบริการ 3 บาทต่อข้อความ</li>
                    <?php else: ?>
                        <li>A Maximum 5 sms alerts will be sent to your <?php echo CHtml::value($model, 'account.msisdn'); ?>. For each sms you will be charged 3 baht.</li>
                    <?php endif; ?>
                    <li><?php echo Helper::t('Please register SMS Service by call <span class="text-success">' . Configuration::getKey('sms_ivr') . '</span> and press dial.', 'กรุณาสมัครใช้บริการ SMS ผ่านระบบ IVR  โดย กด <span class="text-success">' . Configuration::getKey('sms_ivr') . '</span> แล้วกด โทรออก'); ?></li>
                    <li><?php echo Helper::t('After registered. You could receive confirmation SMS.', 'หลังจากสมัครใช้บริการ ท่านจะได้รับ SMS ยืนยันจากระบบ'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => Helper::t('Submitted your application', 'ยืนยันการสมัครสอบ'),
            'buttonType' => 'submit',
            'context' => 'primary',
            'icon' => 'edit',
            'htmlOptions' => array(
                'class' => 'pull-right',
                'onclick' => 'return confirm("Do you want to submit the application?")',
            ),
        ));
        ?>
        <?php echo Helper::buttonBack(array('site/index')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>

    $(document).ready(function () {
        $('#is_sms').change(function () {
            if ($(this).prop('checked')) {
                $('#sms-pane').show();
            } else {
                $('#sms-pane').hide();
            }
        });

        $('#ExamApplication_exam_schedule_objective_id').change(function () {
            if ($(this).val() === '0') {
                $('#objective-pane').show();
            } else {
                $('#objective-pane').hide();
            }
        });

        $('#ExamApplication_exam_schedule_objective_id').trigger('change');
        $('#is_sms').trigger('change');
    });
</script>