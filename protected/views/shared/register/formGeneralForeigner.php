<?php $requirePassword = isset($requirePassword) ? $requirePassword : true; ?>
<?php if ($model->isNewRecord): ?>
    <?php if ($requirePassword): ?>
        <h4 class="fancy"><?php echo Yii::t('register', 'Account Information'); ?> <small>: Username will be sent to your email address.</small></h4>
        <div class="row">
            <div class="col-md-6">
                <?php
                echo $form->passwordFieldGroup($model, 'password_input', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => Yii::t('register', 'minimum 8 characters'),
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
                            'placeholder' => Yii::t('register', 'minimum 8 characters'),
                        ),
                    ),
                    'labelOptions' => array(
                        'label' => 'Confirm Password',
                        'style' => 'white-space:nowrap;',
                    ),
                ));
                ?>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    <?php endif; ?>
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
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'title_en', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_title_en',
                    'class' => 'text-uppercase',
                    'placeholder' => '',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
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
                    'class' => 'text-uppercase',
                    'disabled' => !$profile->isNewRecord,
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
                    'class' => 'text-uppercase',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
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
                    'class' => 'text-uppercase',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
        <!-- Change Name -->
        <?php if ($this->action->id === 'profile' && Yii::app()->request->getQuery('mode') !== 'firsttime'): ?>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <?php
                    echo $form->checkbox($profile, 'require_changename', array(
                        'id' => 'require_changename',
                    ));
                    ?> I want to change name.
                </div>
            </div>
            <div id="changename-pane">
                <?php
                echo $form->fileFieldGroup($profile, 'name_file', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                        ),
                    ),
                    'hint' => 'Accept only ' . implode(', ', Helper::getAllowedDocumentExtension()) . ' and file size not over 1MB',
                    'labelOptions' => array(
                        'required' => true,
                    ),
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <?php
        echo $form->datePickerGroup($profile, 'birth_date', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => Yii::t('register', 'yyyy-mm-dd'),
                ),
            ),
            'append' => Helper::glyphicon('calendar'),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'nationality_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeCountry::model()->forNationality()->sortBy('nationality')->findAll(), 'id', 'nationality'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'religion_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeReligion::model()->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'id' => 'Profile_religion_id',
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'religion_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_religion_other',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Work Details</h4>
        <?php
        echo $form->textFieldGroup($profile, 'work_office_other', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_work_office_other',
                    'class' => 'text-uppercase',
                    'placeholder' => '',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
            'hint' => 'As printed on the certificate.',
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
            'hint' => '',
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'work_year', array(
            'widgetOptions' => array(
                'data' => Helper::getYearList(100),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-md-6">
        <h4 class="fancy">Higher Education</h4>
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
            'labelOptions' => array(
                'class' => 'nowrap',
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
        <div class="same-addr pull-right">
            <?php
            echo $form->checkBox($profile, 'is_same_address', array(
                'id' => 'Profile_is_same_address',
                'class' => 'input-update',
                'data-target' => '#reply_address_pane',
                'data-callback' => 'updateAddress',
            ));
            ?> <strong>Same as office address</strong>
        </div>
        <h4 class="fancy">
            Address for sending certificate
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
            <?php echo $form->labelEx($profile, 'contact_phone', array('class' => 'control-label col-sm-4')); ?>
            <div class="col-sm-8">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '+')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_phone_ext', array('class' => 'form-control', 'style' => 'width:80px;', 'placeholder' => 'ext')); ?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_fax', array('class' => 'control-label col-sm-4')); ?>
            <div class="col-sm-8">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_fax_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '+')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_fax', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '')); ?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_mobile', array('class' => 'control-label col-sm-4')); ?>
            <div class="col-sm-8">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '+')); ?></div>
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile', array('class' => 'form-control', 'style' => 'width:150px;', 'placeholder' => '')); ?></div>
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
                'label' => 'email',
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
        echo $form->dropDownListGroup($profile, 'emp_type', array(
            'widgetOptions' => array(
                'data' => $profile->getEmpTypeOptions(),
                'htmlOptions' => array(
                    'id' => 'Profile_emp_type',
                ),
            ),
            'labelOptions' => array(
                'class' => 'nowrap',
            ),
        ));
        ?>
        <div id="emp-pane">
            <?php
            echo $form->textFieldGroup($profile, 'passport_no', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'required' => true,
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
                'labelOptions' => array(
                    'required' => true,
                ),
            ));
            ?>
            <?php
            echo $form->datePickerGroup($profile, 'passport_issue_date', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => Yii::t('register', 'yyyy-mm-dd'),
                    ),
                ),
                'labelOptions' => array(
                    'required' => true,
                ),
                'append' => Helper::glyphicon('calendar'),
            ));
            ?>
            <?php
            echo $form->datePickerGroup($profile, 'passport_expire_date', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => Yii::t('register', 'yyyy-mm-dd'),
                    ),
                ),
                'labelOptions' => array(
                    'required' => true,
                ),
                'append' => Helper::glyphicon('calendar'),
            ));
            ?>
            <div class="form-group">
                <?php echo $form->labelEx($profile, 'emp_pic_file', array('class' => 'col-sm-4 control-label', 'required' => true)); ?>
                <div class="col-sm-8">
                    <div id="register-photo" class="thumbnail">
                        <?php echo CHtml::image($profile->getPhotoUrl()); ?>
                    </div>
                    <span class="help-block">
                        Please attach copy of your personal details page only.<br/>Accept only <?php echo implode(', ', Helper::getAllowedImageExtension()); ?>
                    </span>
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'Select file...',
                        'context' => 'success',
                        'htmlOptions' => array(
                            'id' => 'btn-upload-pane',
                        ),
                    ));
                    ?>
                    <?php
                    echo $form->hiddenField($profile, 'emp_pic_file', array(
                        'id' => 'emp-pic-file',
                    ))
                    ?>
                    <?php echo $form->error($profile, 'emp_pic_file'); ?>
                </div>
            </div>
        </div>
        <div id="self-pane">
            <?php
            echo $form->fileFieldGroup($profile, 'self_file', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => 'Attachment File <span class="required">*</span>',
                ),
                'hint' => 'Accept only ' . implode(', ', Helper::getAllowedDocumentExtension()) . ' and file size not over 1MB<br/>Example file ' . CHtml::link('[download]', array('/get/downloadSelfExample')),
            ));
            ?>
            <?php if (!$model->isNewRecord && $profile->selfFile->getFileUrl()): ?>
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'label' => 'Download Attachment',
                            'icon' => 'download',
                            'context' => 'info',
                            'url' => CHtml::value($this, 'module.id') === 'administrator' ? $profile->selfFile->getFileUrl() : array('my/getSelfFile'),
                            'buttonType' => 'link',
                            'htmlOptions' => array(
                                'target' => '_blank',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (Yii::app()->request->getQuery('mode') !== 'firsttime'): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn-upload-pane').click(function () {
                $('#upload-modal').modal('show');
            });
            $('#require_changename').change(function () {
                if ($(this).prop('checked')) {
                    $('#Profile_title_id_th').prop('disabled', false);
                    $('#Profile_title_th').prop('disabled', false);
                    $('#AccountProfileGeneralForeigner_firstname_th').prop('disabled', false);
                    $('#AccountProfileGeneralForeigner_lastname_th').prop('disabled', false);
                    $('#Profile_title_id_en').prop('disabled', false);
                    $('#Profile_title_en').prop('disabled', false);
                    $('#AccountProfileGeneralForeigner_firstname_en').prop('disabled', false);
                    $('#AccountProfileGeneralForeigner_midname_en').prop('disabled', false);
                    $('#AccountProfileGeneralForeigner_lastname_en').prop('disabled', false);
                    $('#changename-pane').show();
                } else {
                    $('#Profile_title_id_th').prop('disabled', true);
                    $('#Profile_title_th').prop('disabled', true);
                    $('#AccountProfileGeneralForeigner_firstname_th').prop('disabled', true);
                    $('#AccountProfileGeneralForeigner_lastname_th').prop('disabled', true);
                    $('#Profile_title_id_en').prop('disabled', true);
                    $('#Profile_title_en').prop('disabled', true);
                    $('#AccountProfileGeneralForeigner_firstname_en').prop('disabled', true);
                    $('#AccountProfileGeneralForeigner_midname_en').prop('disabled', true);
                    $('#AccountProfileGeneralForeigner_lastname_en').prop('disabled', true);
                    $('#changename-pane').hide();
                }
            });

            $('#require_changename').trigger('change');

        });
    </script>     
<?php endif; ?>
<?php
$this->renderPartial('application.views.shared.register.formGeneralForeignUpload', array(
    'model' => $profile,
));
?>
