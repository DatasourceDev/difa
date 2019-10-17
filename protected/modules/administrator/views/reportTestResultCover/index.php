<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบปะหน้าซอง สำหรับส่งผลสอบให้หน่วยงาน'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'frm-export-2',
    'type' => 'horizontal',
    'action' => array('print'),
    'method' => 'post',
    'htmlOptions' => array(
        'target' => '_blank',
    ),
        ));
?>
<div class="well well-sm">
    <h4>ข้อมูลในการพิมพ์ใบปะหน้าซอง</h4>
    <?php echo $form->textFieldGroup($cover, 'approve_date'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_name'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_position'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_footer1'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_footer2'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_footer3'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_footer4'); ?>         
    <?php echo $form->textFieldGroup($cover, 'approve_footer5'); ?>         
    <?php
    echo $form->hiddenField($cover, 'items', array(
        'id' => 'items',
    ));
    ?>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'พิมพ์ใบปะหน้าซอง',
                'icon' => 'print',
                'context' => 'info',
                'buttonType' => 'submit',
                'htmlOptions' => array(
                    'id' => 'btn-export',
                ),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'selectableRows' => 2,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'header' => 'รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examScheduleAccount.examSchedule.exam_code")',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ-นามสกุล',
            'name' => 'profile.fullname',
            'type' => 'text',
        ),
        array(
            'header' => 'หน่วยงาน',
            'name' => 'profile.textDepartment',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ที่อยู่หน่วยงาน',
            'name' => 'profile.textDepartmentAddress',
            'type' => 'text',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
    ),
));
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-export-2').submit(function () {
            var items = $('.grid-view').yiiGridView('getSelection');
            if (items.length) {
                $('#items', this).val(items);
                return true;
            } else {
                alert('กรุณาเลือกรายการที่ต้องการพิมพ์');
                return false;
            }

        });
    });
</script>