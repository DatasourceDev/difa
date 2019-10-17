<?php
$form = $this->beginWidget('CodeskActiveForm', array(
    'type' => 'horizontal',
    'formSize' => 'small',
    'htmlOptions' => array(
        'id' => 'frm-register',
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
$this->renderPartial('application.views.shared.register.formDiplomatThai', array(
    'form' => $form,
    'model' => $model,
    'profile' => $profile,
    'requirePassword' => false,
))
?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Cancel',
        'buttonType' => 'link',
        'context' => 'danger',
        'url' => array('view', 'id' => $schedule->id),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Submit',
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("ยืนยันการบันทึกข้อมูล?")',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-register').change(function () {
            if ($('#Account_entry_code').val()) {
                $.get('<?php echo $this->createUrl('checkExistingAccount', array('exam_schedule_id' => $schedule->id)); ?>', {id: $('#Account_entry_code').val()}, function (data) {
                    if (data !== 'OK') {
                        $('#base-modal .modal-content').html(data);
                        $('#base-modal').modal('show');
                    }
                });
            }
            initForm();
        });
        initForm();
    });

    function updateAddress() {
        if ($('#Profile_is_same_address').prop('checked')) {
            $('#reply_address_pane input, #reply_address_pane select').prop('disabled', true);
        } else {
            $('#reply_address_pane input, #reply_address_pane select').prop('disabled', false);
        }
    }

    function initForm() {
        $('#Profile_title_id_en').val($('#Profile_title_id_th').val());

        if ($('#Profile_title_id_th').val() === 'O') {
            $('#Profile_title_th').closest('.form-group').show();
        } else {
            $('#Profile_title_th').closest('.form-group').hide();
        }

        if ($('#Profile_title_id_en').val() === 'O') {
            $('#Profile_title_en').closest('.form-group').show();
        } else {
            $('#Profile_title_en').closest('.form-group').hide();
        }
        if ($('#Profile_religion_id').val() === '9999') {
            $('#Profile_religion_other').closest('.form-group').show();
        } else {
            $('#Profile_religion_other').val($('#Profile_religion_id').find(":selected").text());
            $('#Profile_religion_other').closest('.form-group').hide();
        }
        if ($('#Profile_work_office_id').val() === '9999') {
            $('#Profile_work_office_other').closest('.form-group').show();
        } else {
            $('#Profile_work_office_other').val($('#Profile_work_office_id').find(":selected").text());
            $('#Profile_work_office_other').closest('.form-group').hide();
        }

        if ($('#Profile_diplomat_level').val() === '9999') {
            $('#Profile_diplomat_level_other').closest('.form-group').show();
        } else {
            $('#Profile_diplomat_level_other').closest('.form-group').hide();
        }
    }
</script>