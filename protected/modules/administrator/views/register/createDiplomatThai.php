<div class="topic">Member Register <small>(Thai Diplomat)</small></div>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'id' => 'frm-register',
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php if ($model->isNewRecord): ?>
    <h4 class="fancy"><?php echo Yii::t('register', 'Account Information'); ?></h4>
    <div class="row">
        <div class="col-md-6">
            <?php
            echo $form->textFieldGroup($model, 'entry_code', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'id' => 'Account_entry_code',
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => Yii::t('register', 'Citizen ID'),
                ),
            ));
            ?>
            <?php
            echo $form->passwordFieldGroup($model, 'password_input', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'id' => 'Account_password_input',
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => Yii::t('register', 'Password'),
                ),
            ));
            ?>
            <?php
            echo $form->passwordFieldGroup($model, 'password_confirm', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'id' => 'Account_password_confirm',
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => Yii::t('register', 'Confirm Again'),
                ),
            ));
            ?>
        </div>
        <div class="col-md-6">
        </div>
    </div>
<?php endif; ?>
<h4 class="fancy"><?php echo Yii::t('register', 'General'); ?></h4>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->radioButtonListGroup($profile, 'gender', array(
            'widgetOptions' => array(
                'data' => $profile->getGenderOptions(),
            ),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->dropDownListGroup($profile, 'title_id_th', array(
            'widgetOptions' => array(
                'data' => CodeTitle::getThaiOptions(),
                'htmlOptions' => array(
                    'id' => 'Profile_title_id_th',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'title_th', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_title_th',
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'firstname_th', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'lastname_th', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
        ));
        ?>
        <?php
        echo $form->datePickerGroup($profile, 'birth_date', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_birth_date',
                    'placeholder' => '',
                ),
            ),
            'append' => Helper::glyphicon('calendar'),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'religion_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeReligion::model()->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'nationality_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo $form->dropDownListGroup($profile, 'title_id_en', array(
            'widgetOptions' => array(
                'data' => CodeTitle::getEnglishOptions(),
                'htmlOptions' => array(
                    'id' => 'Profile_title_id_en',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'title_en', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_title_en',
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'firstname_en', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'lastname_en', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Diplomat Information</h4>
        <?php
        echo $form->dropDownListGroup($profile, 'diplomat_type', array(
            'widgetOptions' => array(
                'data' => $profile->getDiplomatTypeOptions(),
                'htmlOptions' => array(
                    'class' => 'input-update',
                    'data-target' => '#Profile_diplomat_level',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'diplomat_position', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'diplomat_level', array(
            'widgetOptions' => array(
                'data' => $profile->getDiplomatLevelOptions($profile->diplomat_type),
                'htmlOptions' => array(
                    'id' => 'Profile_diplomat_level',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'diplomat_level_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_diplomat_level_other',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'diplomat_office', array(
            'widgetOptions' => array(
                'data' => Helper::listArray($profile->getDiplomatOfficeOptions()),
                'htmlOptions' => array(
                    'id' => 'Profile_diplomat_office',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <h4 class="fancy">Contact Information</h4>
        <?php
        echo $form->textFieldGroup($profile, 'contact_voip', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_fax', array('class' => 'control-label col-sm-3')); ?>
            <div class="col-sm-9">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_fax_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '66')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_fax', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '999-999-9999')); ?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_mobile', array('class' => 'control-label col-sm-3')); ?>
            <div class="col-sm-9">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '66')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '999-999-9999')); ?></div>
                </div>
            </div>
        </div>
        <?php
        echo $form->emailFieldGroup($profile, 'contact_email', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::glyphicon('envelope'),
        ));
        ?>
    </div>
</div>
<h4 class="fancy">Overseas Posting</h4>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->dropDownListGroup($profile, 'oversea_posting', array(
            'widgetOptions' => array(
                'data' => array(
                    '0' => 'Never',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                ),
                'htmlOptions' => array(
                    'id' => 'Profile_oversea_posting',
                    'class' => 'input-update',
                    'data-target' => '#oversea_pane',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
    </div>
</div>
<div id="oversea_pane">
    <table class="table table-bordered table-condensed table-striped">
        <colgroup>
            <col/>
            <col/>
            <col/>
            <col/>
            <col width="100"/>
            <col width="100"/>
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th>Office</th>
                <th>City</th>
                <th>Country</th>
                <th class="text-center">From (Year)</th>
                <th class="text-center">To (Year)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($profile->oversea_posting): ?>
                <?php for ($i = 0; $i < $profile->oversea_posting; $i++): ?>
                    <tr>
                        <td><?php echo $i + 1; ?><?php echo $form->hiddenField($profile, 'overseaPosting[' . $i . '][office]'); ?></td>
                        <td><?php echo $form->dropDownList($profile, 'overseaPosting[' . $i . '][office]', $profile->getOverseaOfficeOptions(), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
                        <td><?php echo $form->textField($profile, 'overseaPosting[' . $i . '][city]', array('class' => 'form-control')); ?></td>
                        <td><?php echo $form->dropDownList($profile, 'overseaPosting[' . $i . '][country]', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
                        <td><?php echo $form->textField($profile, 'overseaPosting[' . $i . '][year_start]', array('class' => 'form-control')); ?></td>
                        <td><?php echo $form->textField($profile, 'overseaPosting[' . $i . '][year_end]', array('class' => 'form-control')); ?></td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center" colspan="6">No items</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<h4 class="fancy">Education</h4>
<table class="table table-bordered table-condensed table-striped">
    <colgroup>
        <col/>
        <col width="150"/>
        <col/>
        <col width="150"/>
        <col width="100"/>
        <col width="100"/>
    </colgroup>
    <thead>
        <tr>
            <th>Degree</th>
            <th>Subject</th>
            <th>Country</th>
            <th>University/Institute</th>
            <th class="text-center">From (Year)</th>
            <th class="text-center">To (Year)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>High School</td>
            <td><?php echo $form->textField($profile, 'educate_highschool', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->dropDownList($profile, 'educate_highschool_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Bachelor</td>
            <td><?php echo $form->textField($profile, 'educate_bachelor', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->dropDownList($profile, 'educate_bachelor_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_bachelor_university', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_bachelor_year_from', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_bachelor_year_to', array('class' => 'form-control')); ?></td>
        </tr>
        <tr>
            <td>Master</td>
            <td><?php echo $form->textField($profile, 'educate_master', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->dropDownList($profile, 'educate_master_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_master_university', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_master_year_from', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_master_year_to', array('class' => 'form-control')); ?></td>
        </tr>
        <tr>
            <td>Ph.D.</td>
            <td><?php echo $form->textField($profile, 'educate_phd', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->dropDownList($profile, 'educate_phd_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_phd_university', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_phd_year_from', array('class' => 'form-control')); ?></td>
            <td><?php echo $form->textField($profile, 'educate_phd_year_to', array('class' => 'form-control')); ?></td>
        </tr>
    </tbody>
</table>
<h4 class="fancy">Security Question</h4>
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
                    <div class="col-sm-9">
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
    <h4 class="fancy">Term of Service / Policy</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dui purus, imperdiet in lectus nec, aliquet aliquam magna. Mauris malesuada lacus dapibus malesuada posuere. Cras vel lorem non justo vulputate molestie vitae at turpis. Quisque ac dui consectetur, rhoncus justo at, ullamcorper massa. Praesent consectetur, leo eget pellentesque luctus, urna purus ultricies velit, a venenatis tortor justo et justo. Donec fringilla nisl ac ante malesuada, ac rhoncus leo hendrerit. In et nulla ultricies, suscipit libero venenatis, aliquet eros. Nullam ut erat dictum, volutpat elit ac, varius dolor.</p>
    <p>Nunc a orci mollis orci dignissim posuere et a neque. Cras vitae feugiat urna, ac tincidunt eros. Duis tempor, nulla eget pharetra convallis, quam mauris porta nisl, in condimentum odio mi eget eros. Curabitur pretium ut dui ultricies malesuada. Cras eu nunc ullamcorper metus molestie condimentum a in leo. Aenean ac condimentum neque. Cras et efficitur lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus vitae luctus urna. Pellentesque elementum elit nec volutpat congue. Duis tempor cursus risus, sed viverra diam tempor et.</p>
    <?php
    echo $form->checkBoxGroup($model, 'is_agree', array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'uncheckValue' => null,
            ),
        ),
    ));
    ?>
<?php endif; ?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Cancel',
        'buttonType' => 'link',
        'url' => CHtml::value($model, 'accountType.accountManagerLink'),
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Submit',
        'buttonType' => 'submit',
        'context' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'onclick' => 'return confirm("ยืนยันการบันทึกข้อมูล")',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-register').change(function () {
            if ($('#Account_entry_code').val() && $('#Account_password_input').val() && $('#Account_password_confirm').val() && $('#Profile_birth_date').val()) {
                $.get('<?php echo $this->createUrl('checkExistingAccount'); ?>', {
                    data: {
                        entry_code: $('#Account_entry_code').val(),
                        password_input: $('#Account_password_input').val(),
                        password_confirm: $('#Account_password_confirm').val(),
                        birth_date: $('#Profile_birth_date').val()
                    }
                }, function (data) {
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
            $('#reply_address_pane input, #reply_address_pane select, #reply_address_pane textarea').prop('disabled', true);
        } else {
            $('#reply_address_pane input, #reply_address_pane select, #reply_address_pane textarea').prop('disabled', false);
        }
    }

    function initForm() {

        $('#Profile_title_id_en').val($('#Profile_title_id_th').val());

        if ($('#Profile_title_id_th').val() === 'O') {
            $('#Profile_title_th').closest('.form-group').show();
        } else {
            $('#Profile_title_th').val($('#Profile_title_id_th').find(":selected").text());
            $('#Profile_title_th').closest('.form-group').hide();
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
            $('#Profile_work_office_other').val($('#Profile_work_office_id').find(":selected").text());
            $('#Profile_work_office_other').closest('.form-group').hide();
        }

        if ($('#Profile_diplomat_level').val() === '9999') {
            $('#Profile_diplomat_level_other').closest('.form-group').show();
        } else {
            $('#Profile_diplomat_level_other').val($('#Profile_diplomat_level').find(":selected").text());
            $('#Profile_diplomat_level_other').closest('.form-group').hide();
        }
    }
</script>