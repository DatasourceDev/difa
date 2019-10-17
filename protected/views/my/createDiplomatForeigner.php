<div class="topic">Registration <small>(Foreign Diplomats)</small></div>
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
$this->renderPartial('application.views.shared.register.formDiplomatForeigner', array(
    'form' => $form,
    'model' => $model,
    'profile' => $profile,
))
?>
<h4 class="fancy">Security Questions</h4>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->dropDownListGroup($model, 'secure_question_1', array(
            'widgetOptions' => array(
                'data' => $model->getSecureQuestionOptions($model->secure_question_2),
                'htmlOptions' => array(
                    'id' => 'Account_secure_question_1',
                    'class' => 'input-update',
                    'data-target' => '#Account_secure_question_2',
                    'prompt' => '(Please select)',
                    'disabled' => true,
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($model, 'secure_answer_1', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($model, 'secure_question_2', array(
            'widgetOptions' => array(
                'data' => $model->getSecureQuestionOptions($model->secure_question_1),
                'htmlOptions' => array(
                    'id' => 'Account_secure_question_2',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($model, 'secure_answer_2', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
</div>
<?php if ($model->isNewRecord): ?>
    <?php if (CCaptcha::checkRequirements()): ?>
        <h4 class="fancy">Spam Prevention</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label col-sm-3')); ?>
                    <div class="col-sm-9 captcha">
                        <?php $this->widget('CCaptcha', array('captchaAction' => 'register/captcha')); ?>
                        <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')); ?>
                        <div class="hint">Please enter the letters as they are shown in the image above.
                            <br/>Letters are not case-sensitive.</div>
                        <?php echo $form->error($model, 'verifyCode'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <h4 class="fancy">Terms of Service / Policy</h4>
    <div class="form-group">
        <div class="col-sm-11 col-sm-offset-1">
            <?php echo Configuration::getKey(Yii::app()->language === 'th' ? 'web_register_term_th' : 'web_register_term_en'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-11 col-sm-offset-1">
            <?php
            echo $form->checkBoxGroup($model, 'is_agree', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'uncheckValue' => null,
                    ),
                ),
            ));
            ?>
        </div>
    </div>
<?php endif; ?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Submit',
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("Do you want to submit the form?")',
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
            $('#reply_address_pane input, #reply_address_pane select, #reply_address_pane textarea').prop('disabled', true);
        } else {
            $('#reply_address_pane input, #reply_address_pane select, #reply_address_pane textarea').prop('disabled', false);
        }
    }

    function initForm() {

        if ($('#Profile_emp_type').val() === '0') {
            $('#emp-pane').show();
            $('#self-pane').hide();
        } else {
            $('#emp-pane').hide();
            $('#self-pane').show();
        }

        if ($('#Profile_title_id_en').val() === 'O') {
            $('#Profile_title_en').closest('.form-group').show();
        } else {
            $('#Profile_title_en').val($('#Profile_title_id_en').find(":selected").text());
            $('#Profile_title_en').closest('.form-group').hide();
        }

        if ($('#Profile_work_office_id').val() === '9999') {
            $('#Profile_work_office_other').closest('.form-group').show();
        } else {
            $('#Profile_work_office_other').closest('.form-group').hide();
        }
        if ($('#Profile_religion_id').val() === '9999') {
            $('#Profile_religion_other').closest('.form-group').show();
        } else {
            $('#Profile_religion_other').val($('#Profile_religion_id').find(":selected").text());
            $('#Profile_religion_other').closest('.form-group').hide();
        }
        if ($('#Profile_diplomat_level').val() === '9999') {
            $('#Profile_diplomat_level_other').closest('.form-group').show();
        } else {
            $('#Profile_diplomat_level_other').closest('.form-group').hide();
        }
    }
</script>