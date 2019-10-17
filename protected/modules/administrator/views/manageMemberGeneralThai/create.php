<div class="topic">ลงทะเบียน <small>[ข้าราชการ พนักงานรัฐวิสาหกิจ และพนักงานในกำกับของรัฐ]</small></div>
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
$this->renderPartial('application.views.shared.register.formGeneralThai', array(
    'form' => $form,
    'model' => $model,
    'profile' => $profile,
))
?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Cancel',
        'buttonType' => 'link',
        'context' => 'danger',
        'url' => array('index'),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Submit',
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("ยืนยันการลงทะเบียน?")',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-register').change(function () {
            initForm();
        });
        initForm();
        $(".captcha a").trigger("click");
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

        if ($('#Profile_emp_type').val() === '0') {
            $('#emp-pane').show();
            $('#self-pane').hide();
        } else {
            $('#emp-pane').hide();
            $('#self-pane').show();
        }

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

        if ($('#Profile_work_office_id').val() === '9999') {
            $('#Profile_work_office_other').closest('.form-group').show();
            $('#Profile_work_office_other_th').closest('.form-group').show();
        } else {
            if ($('#Profile_work_office_id').select2("data")) {
                $('#Profile_work_office_other').val($('#Profile_work_office_id').select2("data").name_en);
            }
            $('#Profile_work_office_other').closest('.form-group').hide();
            if ($('#Profile_work_office_id').select2("data")) {
                $('#Profile_work_office_other_th').val($('#Profile_work_office_id').select2("data").name_th);
            }
            $('#Profile_work_office_other_th').closest('.form-group').hide();
        }

        if ($('#Profile_religion_id').val() === '9999') {
            $('#Profile_religion_other').closest('.form-group').show();
        } else {
            $('#Profile_religion_other').val($('#Profile_religion_id').find(":selected").text());
            $('#Profile_religion_other').closest('.form-group').hide();
        }

        if ($('#Profile_work_level').val() === '99') {
            $('#Profile_work_level_other').closest('.form-group').show();
        } else {
            $('#Profile_work_level_other').val($('#Profile_work_level').find(":selected").text());
            $('#Profile_work_level_other').closest('.form-group').hide();
        }

        if ($('#Profile_educate_degree').val() === 'O') {
            $('#Profile_educate_degree_other').closest('.form-group').show();
        } else {
            $('#Profile_educate_degree_other').closest('.form-group').hide();
        }
    }
</script>