<div class="btn-toolbar margin-bottom">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มรอบสอบ',
        'icon' => 'plus',
        'buttonType' => 'link',
        'url' => array('calendar'),
        'context' => 'primary'
    ));
    ?>
</div>
<?php $this->beginWidget('booster.widgets.TbCollapse'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <span class="glyphicon glyphicon-search"></span> ค้นหาตามเงื่อนไข
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup($model, 'exam_code'); ?>        
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->datePickerGroup($model, 'db_date'); ?>        
                    </div>
                    <div class="col-sm-4">
                        <?php
                        echo $form->dropDownListGroup($model, 'exam_type_id', array(
                            'widgetOptions' => array(
                                'data' => CHtml::listData(ExamType::model()->scopeActive()->findAll(), 'id', 'name'),
                                'htmlOptions' => array(
                                    'prompt' => '(ทั้งหมด)',
                                ),
                            ),
                        ));
                        ?>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup($model, 'place_name'); ?>        
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup($model, 'place_remark'); ?>        
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup($model, 'register_fee'); ?>        
                    </div>
                </div>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ค้นหา',
                    'icon' => 'search',
                    'buttonType' => 'submit',
                    'context' => 'info',
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ล้างเงื่อนไข',
                    'icon' => 'refresh',
                    'buttonType' => 'link',
                    'url' => array('index'),
                    'context' => 'success',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'exam_code',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::value($data,"exam_code"),array("view","id" => $data->id))',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'db_date',
            'type' => 'date',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-2',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ประเภท',
            'name' => 'exam_type_id',
            'value' => 'CHtml::value($data,"examType.name")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'place_name',
        ),
        array(
            'name' => 'place_remark',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ค่าธรรมเนียม<wbr/>การสมัคร',
            'name' => 'register_fee',
            'type' => 'money',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'จำนวนทักษะ',
            'name' => 'countExamScheduleItem',
            'type' => 'number',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'จำนวนผู้สมัคร',
            'name' => 'countValidAttendee',
            'type' => 'number',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'max_quota',
            'value' => 'CHtml::value($data,"max_quota") . (CHtml::value($data,"countQuotaPreserved") ? " <small class=\"text-danger\">(-". CHtml::value($data,"countQuotaPreserved") .")</small>" : "")',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'คงเหลือ',
            'value' => 'CHtml::value($data,"countSeatAvailable")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{delete}',
        ),
    ),
));
?>