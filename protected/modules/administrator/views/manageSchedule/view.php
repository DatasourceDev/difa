<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
));
?>
<div class="row">
    <div class="col-md-8">
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'exam_type_id',
                    'value' => $model->examType->name,
                ),
                array(
                    'name' => 'exam_code',
                ),
                array(
                    'name' => 'db_date',
                    'type' => 'dateText',
                ),
                array(
                    'name' => 'place_name',
                ),
                array(
                    'name' => 'place_remark',
                ),
                array(
                    'name' => 'max_quota',
                    'type' => 'number',
                ),
                array(
                    'name' => 'remark',
                ),
                array(
                    'name' => 'register_fee',
                ),
                array(
                    'name' => 'is_private',
                    'value' => $model->getTextIsPrivate(),
                ),
                array(
                    'label' => 'วันที่เริ่มรับสมัคร',
                    'name' => 'registerDateStart',
                    'type' => 'dateText',
                ),
                array(
                    'label' => 'วันที่ปิดรับสมัคร',
                    'name' => 'registerDateEnd',
                    'type' => 'dateText',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-md-4">
        <h4 class="fancy">เมนูสำหรับการจัดการโดยเจ้าหน้าที่สถาบัน</h4>
        <?php foreach (AccountType::model()->scopeRegistrable()->findAll() as $item): ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'สมัคร ' . $item->display_name,
                'url' => array('create' . $item->view_name, 'id' => $model->id),
                'buttonType' => 'link',
                'context' => 'info',
                'block' => true,
                'htmlOptions' => array(
                    'style' => 'background-color:' . CHtml::value($item, 'color', '#669999') . ';'
                ),
                'visible' => $model->examType->code === 'IH' ? ($model->examType->hasAccountType($item->id) ? true : false) : true,
            ));
            ?>
        <?php endforeach; ?>
        <hr/>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'นำเข้าข้อมูลจากระบบฝึกอบรม',
            'url' => array('importFile', 'id' => $model->id),
            'buttonType' => 'link',
            'context' => 'success',
            'block' => true,
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'สมัครสอบจากบัญชีเดิมในระบบ',
            'url' => array('accountApplyFromList', 'id' => $model->id),
            'buttonType' => 'link',
            'context' => 'primary',
            'block' => true,
        ));
        ?>
    </div>    
</div>
<hr/>
<h4 class="fancy">ข้อมูลชุดสอบ</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $examSetProvider,
    'columns' => array(
        array(
            'name' => 'exam_set_id',
        ),
        array(
            'name' => 'db_date',
            'type' => 'dateText',
        ),
        array(
            'name' => 'time_start',
            'type' => 'time',
            'headerHtmlOptions' => array(
                'class' => 'text-center col-sm-1',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'time_end',
            'type' => 'time',
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
            'header' => 'ใบรายชื่อ',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{print_th} {print_en} {xls}',
            'buttons' => array(
                'print_th' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/lang_th.png',
                    'label' => 'พิมพ์',
                    'url' => 'array("reportExamSchedule/printNameList", "id" => $data->primaryKey, "lang" => "th")',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
                'print_en' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/lang_en.png',
                    'label' => 'Print',
                    'url' => 'array("reportExamSchedule/printNameList", "id" => $data->primaryKey, "lang" => "en")',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
                'xls' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/icon/xls.png',
                    'label' => 'Export to Excel',
                    'url' => 'array("reportExamSchedule/exportNameList", "id" => $data->primaryKey)',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
            ),
        ),
        array(
            'header' => 'ใบเซ็นชื่อ',
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{print_th} {print_en} {xls}',
            'buttons' => array(
                'print_th' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/lang_th.png',
                    'label' => 'พิมพ์',
                    'url' => 'array("reportExamSchedule/printNameSign","id" => $data->primaryKey, "lang" => "th")',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
                'print_en' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/lang_en.png',
                    'label' => 'Print',
                    'url' => 'array("reportExamSchedule/printNameSign","id" => $data->primaryKey, "lang" => "en")',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
                'xls' => array(
                    'imageUrl' => $this->module->assetUrl . '/images/icon/xls.png',
                    'label' => 'Export to Excel',
                    'url' => 'array("reportExamSchedule/exportNameSign", "id" => $data->primaryKey)',
                    'options' => array(
                        'target' => '_blank',
                    ),
                ),
            ),
        ),
    ),
));
?>
<?php $this->endContent(); ?>