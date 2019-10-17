<?php echo Helper::htmlTopic('ระบบรายงาน', 'รายงานผลการทดสอบวัดระดับความสามารถทางภาษาอังกฤษ'); ?>
<?php $this->beginContent('/layouts/wrapper/searchBox', array()); ?>
<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('index'),
        ));
?>
<?php
echo $form->datePickerGroup($application, 'search[exam_schedule_date_start]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_date_start',
            'placeholder' => '',
            'class' => 'date-update',
            'data-target' => '#exam_schedule_id',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ตั้งแต่วันที่',
        'required' => false,
    ),
));
?>
<?php
echo $form->datePickerGroup($application, 'search[exam_schedule_date_end]', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_date_end',
            'placeholder' => '',
            'class' => 'date-update',
            'data-target' => '#exam_schedule_id',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ถึงวันที่',
        'required' => false,
    ),
));
?>
<?php
echo $form->dropDownListGroup($application, 'exam_schedule_id', array(
    'widgetOptions' => array(
        'htmlOptions' => array(
            'id' => 'exam_schedule_id',
            'prompt' => '(กรุณาเลือกรอบสอบ)',
            'class' => 'input-update',
            'data-method' => 'get',
            'data-target' => '#ExamApplication_search_account_type',
        ),
        'data' => CHtml::listData($application->getScheduleOnDateRange(), 'id', 'textExamCode'),
    ),
    'labelOptions' => array(
        'label' => 'รอบสอบ',
        'required' => true,
    ),
));
?>
<?php
echo $form->dropDownListGroup($application, 'search[account_type]', array(
    'widgetOptions' => array(
        'data' => CHtml::listData(ExamSchedule::getAccountTypes($application->exam_schedule_id), 'id', 'name_th'),
        'htmlOptions' => array(
            'prompt' => '(กรุณาเลือกประเภทสมาชิก)',
        ),
    ),
    'labelOptions' => array(
        'label' => 'ประเภทสมาชิก',
        'required' => true,
    ),
));
?>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ค้นหา',
            'icon' => 'search',
            'context' => 'info',
            'buttonType' => 'submit',
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ล้างเงื่อนไข',
            'icon' => 'refresh',
            'buttonType' => 'link',
            'url' => array('index'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>
<?php if ($showTable): ?>
    <div class="btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ส่งออกไฟล์ XLS',
            'context' => 'success',
            'icon' => 'print',
            'buttonType' => 'link',
            'url' => array('index', 'mode' => 'xls',
                'ExamApplication' => array(
                    'exam_schedule_id' => $application->exam_schedule_id,
                    'search' => array(
                        'account_type' => $application->search['account_type'],
                    ),
                )),
            'htmlOptions' => array(
                'target' => '_blank',
            ),
        ));
        ?>
    </div>
    <div class="grid-view">
        <table class="table table-bordered table-condensed">
            <colgroup>
                <col width="100"/>
                <col/>
                <col width="150"/>
                <col width="100"/>
                <col width="100"/>
                <col width="100"/>
                <col width="100"/>
                <col width="100"/>
            </colgroup>
            <thead>
                <tr>
                    <th colspan="8">ผลการทดสอบวัดระดับความสามารถทางภาษาอังกฤษ สำหรับ <?php echo CHtml::value(AccountType::model()->findByPk($application->search['account_type']), 'name_th'); ?> รอบสอบ <?php echo CHtml::value($application, 'examSchedule.exam_code'); ?></th>
                </tr>
                <tr class="bg-primary">
                    <th class="text-center" rowspan="2">เลขที่สอบ</th>
                    <th class="text-center" rowspan="2">ชื่อ-สกุล</th>
                    <th class="text-center" rowspan="2">ตำแหน่ง</th>
                    <th class="text-center" rowspan="2">ปีที่บรรจุ</th>
                    <th class="text-center" colspan="4">ผลการสอบ</th>
                </tr>
                <tr class="bg-primary">
                    <th class="text-center">ทักษะการอ่าน</th>
                    <th class="text-center">ทักษะการฟัง</th>
                    <th class="text-center">ทักษะการเขียน</th>
                    <th class="text-center">ทักษะการพูด</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dataProvider->totalItemCount) : ?>
                    <?php
                    $department = null;
                    $office = null;
                    ?>
                    <?php foreach ($dataProvider->data as $data): ?>
                        <?php if (CHtml::value($data, 'department') !== $department): ?>
                            <tr class="bg-info text-bold">
                                <td colspan="8"><?php echo CHtml::value($data, 'department', '(ไม่ระบุหน่วยงาน)'); ?></td>
                            </tr>
                            <?php $department = CHtml::value($data, 'department'); ?>
                        <?php endif; ?>
                        <?php if (CHtml::value($data, 'office') !== $office): ?>
                            <tr class="bg-success">
                                <td colspan="8"><?php echo CHtml::value($data, 'office', '(ไม่ระบุสังกัด)'); ?></td>
                            </tr>
                            <?php $office = CHtml::value($data, 'office'); ?>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center"><?php echo CHtml::value($data, 'deskNumber'); ?></td>
                            <td><?php echo CHtml::value($data, 'fullnameTh'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data, 'position'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data, 'work_year'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('R'), 'htmlGradeConfirmed', '<span class="text-muted">-</span>'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('L'), 'htmlGradeConfirmed', '<span class="text-muted">-</span>'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('W'), 'htmlGradeConfirmed', '<span class="text-muted">-</span>'); ?></td>
                            <td class="text-center"><?php echo CHtml::value($data->getExamSetBySubject('S'), 'htmlGradeConfirmed', '<span class="text-muted">-</span>'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center"><span class="text-muted">-- ไม่พบข้อมูล --</span></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="well">
        กรุณาเลือก <span class="text-primary">รอบสอบ</span> และ <span class="text-primary">ประเภทสมาชิก</span> เพื่อออกรายงาน
    </div>
<?php endif; ?>