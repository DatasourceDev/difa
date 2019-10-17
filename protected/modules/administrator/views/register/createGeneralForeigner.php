<div class="topic">Member Register <small>(Foreigner)</small></div>
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
            echo $form->passwordFieldGroup($model, 'password_input', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
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
        echo $form->textFieldGroup($profile, 'midname_en', array(
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
    <div class="col-md-6">
        <?php
        echo $form->datePickerGroup($profile, 'birth_date', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
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
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Office Information</h4>
        <?php
        echo $form->textFieldGroup($profile, 'work_office_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_work_office_other',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_position', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_level_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_work_level_other',
                    'placeholder' => '',
                ),
            ),
            'labelOptions' => array(
                'label' => 'Level',
            ),
            'hint' => 'if no level, use hyphen (-) instead.',
        ));
        ?>
    </div>
    <div class="col-md-6">
        <h4 class="fancy">Highest Education</h4>
        <?php
        echo $form->dropDownListGroup($profile, 'educate_degree', array(
            'widgetOptions' => array(
                'data' => $profile->getEducationDegreeOptions(),
                'htmlOptions' => array(
                    'id' => 'Profile_educate_degree',
                    'prompt' => '(Please select)',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'educate_degree_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_educate_degree_other',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'educate_subject', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'educate_university', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'educate_country', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Office Address</h4>
        <?php
        echo $form->textAreaGroup($profile, 'work_address', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'rows' => 4,
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'work_address_country_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_address_postcode', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <h4 class="fancy">
            Address for sending examination result
            <div class="pull-right">
                <small>
                    <?php
                    echo $form->checkBox($profile, 'is_same_address', array(
                        'id' => 'Profile_is_same_address',
                        'class' => 'input-update',
                        'data-target' => '#reply_address_pane',
                        'data-callback' => 'updateAddress',
                    ));
                    ?> Use same address as office
                </small>
            </div>
        </h4>
        <div id="reply_address_pane">
            <?php
            echo $form->textAreaGroup($profile, 'reply_address', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'rows' => 4,
                        'placeholder' => '',
                        'disabled' => $profile->is_same_address === ActiveRecord::YES,
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'reply_address_country_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                    'htmlOptions' => array(
                        'prompt' => '(Please select)',
                        'disabled' => $profile->is_same_address === ActiveRecord::YES,
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'reply_address_postcode', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                        'disabled' => $profile->is_same_address === ActiveRecord::YES,
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Contact Information</h4>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_phone', array('class' => 'control-label col-sm-3')); ?>
            <div class="col-sm-9">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '66')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '999-999-9999')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone_ext', array('class' => 'form-control', 'style' => 'width:80px;', 'placeholder' => 'ext')); ?></div>
                </div>
            </div>
        </div>
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
            'labelOptions' => array(
                'label' => 'E-mail',
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <h4 class="fancy">Emergency Contact</h4>
        <?php
        echo $form->textFieldGroup($profile, 'emergency_name', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'emergency_phone', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
</div>
<h4 class="fancy">Passport Information</h4>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->textFieldGroup($profile, 'passport_no', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'passport_issue_country', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php if (!$model->isNewRecord && $profile->passportFile->getFileUrl('thumbnail')): ?>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <?php echo CHtml::image($profile->passportFile->getFileUrl('thumbnail') . '?t=' . time()); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
        echo $form->fileFieldGroup($profile, 'passport_file', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
</div>
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

        if ($('#Profile_title_id_en').val() === 'O') {
            $('#Profile_title_en').closest('.form-group').show();
        } else {
            $('#Profile_title_en').val($('#Profile_title_id_en').find(":selected").text());
            $('#Profile_title_en').closest('.form-group').hide();
        }

        if ($('#Profile_educate_degree').val() === 'O') {
            $('#Profile_educate_degree_other').closest('.form-group').show();
        } else {
            $('#Profile_educate_degree_other').val($('#Profile_educate_degree').find(":selected").text());
            $('#Profile_educate_degree_other').closest('.form-group').hide();
        }
    }
</script>