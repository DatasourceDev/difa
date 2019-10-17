<?php
$this->beginContent('/manageSchedule/_view', array(
    'model' => $model,
    'includeMenu' => false,
));
?>
<h4 class="fancy">นำเข้าข้อมูลจากระบบฝึกอบรม</h4>
<div class="row">
    <div class="col-sm-8">
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'type' => 'horizontal',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        ));
        ?>
        <?php echo $form->textFieldGroup($import, 'course_name'); ?>
        <?php echo $form->datePickerGroup($import, 'course_date'); ?>
        <?php
        echo $form->radioButtonListGroup($import, 'import_type', array(
            'widgetOptions' => array(
                'data' => ExamScheduleImport::getImportTypeOptions(),
            ),
        ));
        ?>
        <?php
        echo $form->radioButtonListGroup($import, 'exam_schedule_objective_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(ExamScheduleObjective::model()->findAllByAttributes(array(
                            'exam_schedule_id' => $model->id,
                        )), 'id', 'name_th'),
            ),
        ));
        ?>
        <?php
        echo $form->fileFieldGroup($import, 'import_file', array(
            'hint' => 'สำหรับไฟล์นามสกุล .xls หรือ .xlsx เท่านั้น',
        ));
        ?>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'นำเข้าข้อมูล',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ย้อนกลับ',
                    'buttonType' => 'link',
                    'url' => array('view', 'id' => $model->id),
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="col-sm-4">
        <h4 class="fancy"><span class="text-bold text-underline">หมายเหตุ</span> รูปแบบแบบของข้อมูลในไฟล์ Excel ต้องตรงตามที่ระบบกำหนด ดังนี้</h4>
        <table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">คอลั่มน์</th>
                    <th>ข้อมูล</th>
                </tr>
            </thead>
            <tbody id="table-comment">
                <?php foreach ($import->columnMapper() as $col => $name): ?>
                    <tr> 
                        <td class="text-center"><?php echo chr(ord('A') + $col); ?></td>
                        <td><?php echo $name; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="ExamScheduleImport[import_type]"]').change(function () {
            $.post($(this).closest('form').attr('action'), $(this).closest('form').serialize(), function (data) {
                $('#table-comment').html($('#table-comment', data).html());
            });
            return false;
        });
        $('input[name="ExamScheduleImport[import_type]"]:checked').trigger('change');
    });
</script>