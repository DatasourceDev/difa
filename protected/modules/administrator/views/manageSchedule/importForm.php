<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'action' => array('importFile', 'id' => $model->exam_schedule_id, 'mode' => 'save'),
        ));
?>
<?php echo $form->hiddenField($model, 'course_name'); ?>
<?php echo $form->hiddenField($model, 'course_date'); ?>
<?php echo $form->hiddenField($model, 'import_type'); ?>
<?php echo $form->hiddenField($model, 'exam_schedule_objective_id'); ?>

<h4 class="fancy">พบข้อมูลที่สามารถนำเข้าทั้งหมด <span class="text-primary"><?php echo count($model->importData); ?></span> รายการ</h4>
<?php if (count($model->importData) > $model->examSchedule->getCountSeatAvailable()): ?>
    <div class="alert alert-danger">ไม่สามารถนำเข้าได้ เนื่องจากเกินจำนวนโควต้าที่เหลือ (ปัจจุบันเหลือจำนวน <span class="text-primary"><?php echo $model->examSchedule->getCountSeatAvailable(); ?></span> ที่นั่ง)</div>
    <div class="well well-sm">
        <?php echo Helper::buttonBack(array('importFile','id' => $model->exam_schedule_id)); ?>
    </div>
<?php else: ?>
    <div class="well well-sm">
        <?php echo Helper::buttonBack(array('importFile','id' => $model->exam_schedule_id)); ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'นำเข้าข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
    </div>
<?php endif; ?>
<?php if ($model->import_type === ExamScheduleImport::TYPE_FOREIGN): ?>
    <table class="table table-condensed text-small">
        <?php foreach ($model->importData as $count => $item): ?>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <td rowspan="4"><?php echo $count + 1; ?></td>
                <th class="text-right">Title</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][title_en]'); ?></td>
                <th class="text-right">Firstname</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][firstname_en]'); ?></td>
                <th class="text-right">Middlename</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][midname_en]'); ?></td>
                <th class="text-right">Lastname</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][lastname_en]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">วันเกิด</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][birth_date]'); ?></td>
                <th class="text-right">จังหวัด</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][birth_province]'); ?></td>
                <th class="text-right">สัญชาติ</th>
                <td><?php echo $form->dropDownList($model, 'importData[' . $count . '][nationality]', CHtml::listData(CodeCountry::model()->forNationality()->sortBy('nationality')->findAll(), 'id', 'nationality'), array('style' => 'width:150px;', 'prompt' => '(กรุณาเลือก)')); ?></td>
                <th class="text-right">มือถือ</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][mobile]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">อีเมล์</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][email]'); ?></td>
                <th class="text-right">ตำแหน่ง</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][position]'); ?></td>
                <th class="text-right">ระดับ</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][level]'); ?></td>
                <th class="text-right">หน่วยงาน</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][office]'); ?></td>
            </tr>
            <tr class="border-bottom <?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">Passport No.</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_no]'); ?></td>
                <th class="text-right">Issuer Country</th>
                <td><?php echo $form->dropDownList($model, 'importData[' . $count . '][passport_issue_country]', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'id', 'name_en'), array('style' => 'width:150px;', 'prompt' => '(กรุณาเลือก)')); ?></td>
                <th class="text-right">Issue on:</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_issue_date]'); ?></td>
                <th class="text-right">Expire on:</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_expire_date]'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <table class="table table-condensed text-small">
        <?php foreach ($model->importData as $count => $item): ?>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <td rowspan="6"><?php echo $count + 1; ?></td>
                <th class="text-right">บัตรประชาชน</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][username]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">คำนำหน้า</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][title_th]'); ?></td>
                <th class="text-right">ชื่อ</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][firstname_th]'); ?></td>
                <th class="text-right">ชื่อกลาง</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][midname_th]'); ?></td>
                <th class="text-right">นามสกุล</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][lastname_th]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">Title</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][title_en]'); ?></td>
                <th class="text-right">Firstname</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][firstname_en]'); ?></td>
                <th class="text-right">Middlename</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][midname_en]'); ?></td>
                <th class="text-right">Lastname</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][lastname_en]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">วันเกิด</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][birth_date]'); ?></td>
                <th class="text-right">จังหวัด</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][birth_province]'); ?></td>
                <th class="text-right">สัญชาติ</th>
                <td><?php echo $form->dropDownList($model, 'importData[' . $count . '][nationality]', CHtml::listData(CodeCountry::model()->forNationality()->sortBy('nationality')->findAll(), 'id', 'nationality'), array('style' => 'width:150px;', 'prompt' => '(กรุณาเลือก)')); ?></td>
                <th class="text-right">มือถือ</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][mobile]'); ?></td>
            </tr>
            <tr class="<?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">อีเมล์</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][email]'); ?></td>
                <th class="text-right">ตำแหน่ง</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][position]'); ?></td>
                <th class="text-right">ระดับ</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][level]'); ?></td>
                <th class="text-right">หน่วยงาน</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][office]'); ?></td>
            </tr>
            <tr class="border-bottom <?php echo $count % 2 ? 'bg-info' : 'bg-warning' ?>">
                <th class="text-right">Passport No.</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_no]'); ?></td>
                <th class="text-right">Issuer Country</th>
                <td><?php echo $form->dropDownList($model, 'importData[' . $count . '][passport_issue_country]', CHtml::listData(CodeCountry::model()->sortBy('name_th')->findAll(), 'id', 'name_th'), array('style' => 'width:150px;', 'prompt' => '(กรุณาเลือก)')); ?></td>
                <th class="text-right">Issue on:</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_issue_date]'); ?></td>
                <th class="text-right">Expire on:</th>
                <td><?php echo $form->textField($model, 'importData[' . $count . '][passport_expire_date]'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php $this->endWidget(); ?>