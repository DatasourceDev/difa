<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
    'headerIcon' => 'search',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'action' => array('index'),
    'method' => 'get',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'search[exam_code]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[entry_code]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'รหัสประจำตัว',
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'search[application_name]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'placeholder' => '',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ชื่อ-นามสกุล',
    ),
));
?>
<div class="form-group">
   <div class="col-md-9 col-md-offset-3">
      <?php
      Helper::buttonSubmit('ค้นหา', array(
          'icon' => 'search',
      ));
      ?>
   </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'ชุด/รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSet.id") . "<div class=\"text-small text-muted\">". CHtml::value($data,"examSchedule.exam_code") . "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ/รหัสประจำตัว',
            'name' => 'exam_application_id',
            'value' => 'CHtml::value($data,"examApplication.account.profile.fullname") . "<div class=\"text-small text-muted\">". CHtml::value($data,"examApplication.account.entry_code") . "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ก่อนตรวจ',
            'name' => 'score',
            'value' => '$data->getGradeBefore() . "<div class=\"text-small text-muted\">".$data->getScoreBefore(). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'หลังตรวจ',
            'name' => 'score',
            'value' => '$data->getGradeAfter() . "<div class=\"text-small text-muted\">".$data->getScoreAfter(). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'is_approved',
            'value' => 'CHtml::value($data,"htmlStatus")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'cssClassExpression' => 'CHtml::value($data,"htmlStatusClass")',
        ),
        array(
            'header' => 'ผู้ตรวจ/ผู้อนุมัติ',
            'name' => 'update_user_id',
            'value' => 'CHtml::value($data,"updateUser.username") . "<div class=\"text-small text-muted\">". CHtml::value($data,"approve.username","-"). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'วันที่ปรับปรุงคะแนน',
            'name' => 'update_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                  'update' => array(
                     'options' => array(
                        'target' => '_blank',
                     ),
                  ),
            ),
        ),
    ),
));
