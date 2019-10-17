<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ค้นหาตามเงื่อนไข',
    'headerIcon' => 'search',
));
?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'action' => array('index'),
    'method' => 'get',
        ));
?>
<?php
echo $form->textFieldGroup($model, 'exam_set', array(
    'labelOptions' => array(
        'required' => false,
    ),
));
?>
<?php
echo $form->dropDownListGroup($model, 'exam_schedule', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSchedule::model()->sortBy('db_date DESC')->findAll(), 'id', 'textExamCode'),
        'htmlOptions' => array(
            'prompt' => '(ทุกรอบสอบ)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
        'required' => false,
    ),
));
?>
<?php
echo $form->textFieldGroup($model, 'dvifa_code', array(
    'labelOptions' => array(
        'required' => false,
    ),
));
?>
<?php echo $form->textFieldGroup($model, 'exam_num'); ?>
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
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{view} {viewNoPicture}',
            'viewButtonIcon' => 'picture',
            'buttons' => array(
                'view' => array(
                    'options' => array(
                        'class' => 'btn-ajax-modal',
                    ),
                    'visible' => 'count($data->getExamPhotos())',
                ),
                'viewNoPicture' => array(
                    'label' => 'ไม่มีรูปภาพ',
                    'url' => '"javscript:void(0);"',
                    'icon' => 'picture',
                    'visible' => '!count($data->getExamPhotos())',
                ),
            ),
            'cssClassExpression' => 'count($data->getExamPhotos()) ? "" : "text-muted"',
        ),
        array(
            'name' => 'exam_set',
            'value' => 'isset($data->examSet) ? CHtml::link(CHtml::value($data,"exam_set"),array("manageExamSet/view","id" => $data->exam_set)) : $data->exam_set',
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'dvifa_code',
            'value' => 'isset($data->account) ? CHtml::link($data->dvifa_code,array("manageMember/goto","id" => CHtml::value($data,"account.id"))) : $data->dvifa_code',
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'dvifa_code',
            'value' => 'isset($data->account) ? CHtml::value($data,"account.profile.fullname") : "<span class=\"text-muted\">ไม่พบรายการ</span>"',
            'type' => 'raw',
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule',
            'value' => 'CHtml::value($data,"examSchedule.exam_code")',
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'exam_num',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'import_date',
            'type' => 'datetime',
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'view' => array(
                    'visible' => 'count($data->getExamPhotos())',
                ),
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.btn-ajax-modal', function () {
            if ($(this).data('modal-size') === 'large') {
                $('#base-modal .modal-dialog').addClass('modal-lg');
            } else {
                $('#base-modal .modal-dialog').removeClass('modal-lg');
            }
            $.get($(this).attr('href'), function (data) {
                $('#base-modal .modal-content').html(data);
                $('#base-modal').modal('show');
            });
            return false;
        });
    });
</script>