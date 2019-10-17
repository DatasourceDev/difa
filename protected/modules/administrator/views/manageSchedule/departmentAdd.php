<h4>เลือกหน่วยงาน</h4>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'filter' => $department,
    'columns' => array(
        array(
            'filter' => CodeDepartment::getDepartmentTypeOptions(),
            'name' => 'department_type_id',
            'value' => 'CHtml::value($data,"departmentType")',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อหน่วยงาน',
            'name' => 'name_th',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{select}',
            'buttons' => array(
                'select' => array(
                    'label' => 'เลือก',
                    'icon' => 'arrow-right',
                    'url' => 'array("departmentSelect","id" => $data->id,"exam_schedule_id" => ' . $model->id . ')',
                ),
            ),
        ),
    ),
));
?>