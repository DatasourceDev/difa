<?php $requirePassword = isset($requirePassword) ? $requirePassword : true; ?>
<?php if ($model->isNewRecord): ?>
    <h4 class="fancy"><?php echo Yii::t('register', 'Account Information'); ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div id="entry_pane">
                <?php
                echo $form->textFieldGroup($model, 'entry_code', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'id' => 'Account_entry_code',
                            'placeholder' => 'เลขบัตรประจำตัวประชาชน 13 หลัก',
                            'class' => 'input-update',
                            'data-target' => '#entry_pane',
                        ),
                    ),
                    'labelOptions' => array(
                        'label' => 'ID Number',
                    ),
                ));
                ?>
            </div>
            <?php if ($requirePassword): ?>
                <?php
                echo $form->passwordFieldGroup($model, 'password_input', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'id' => 'Account_password_input',
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
                            'id' => 'Account_password_confirm',
                            'placeholder' => Yii::t('register', 'minimum 8 characters'),
                        ),
                    ),
                    'labelOptions' => array(
                        'label' => 'Confirm Password',
                        'class' => 'nowrap',
                    ),
                ));
                ?>
            <?php endif; ?>
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
                    'prompt' => '(กรุณาเลือก)',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
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
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'firstname_th', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => 'ชื่อ (ภาษาไทย)',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
            'labelOptions' => array(
                'label' => 'ชื่อ',
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'lastname_th', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => 'นามสกุล (ภาษาไทย)',
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                ),
            ),
            'prepend' => Helper::image('lang_th'),
            'labelOptions' => array(
                'label' => 'นามสกุล',
            ),
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
        <?php
        echo $form->datePickerGroup($profile, 'birth_date', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_birth_date',
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
                    'placeholder' => '',
                    'class' => 'text-uppercase',
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
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                    'placeholder' => 'English',
                    'class' => 'text-uppercase',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'lastname_en', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                    'placeholder' => 'English',
                    'class' => 'text-uppercase',
                ),
            ),
            'prepend' => Helper::image('lang_en'),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">Work Details</h4>
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
        echo $form->dropDownListGroup($profile, 'diplomat_position', array(
            'widgetOptions' => array(
                'data' => $profile->getDiplomatPositionOptions(),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
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
        <h4 class="fancy">Contact Information</h4>
        <div class="form-group">
            <?php echo $form->labelEx($profile, 'contact_voip', array('class' => 'control-label col-sm-4')); ?>
            <div class="col-sm-8">
                <div class="form-inline">
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_voip', array('class' => 'form-control', 'style' => 'width:214px;', 'placeholder' => '')); ?></div>
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
                    <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile_country', array('class' => 'form-control', 'style' => 'width:60px;', 'placeholder' => '')); ?></div>
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
        ));
        ?>
    </div>
</div>
<h4 class="fancy">Overseas Posting</h4>
<div class="row">
    <div class="col-md-12">
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
            'labelOptions' => array(
                'label' => 'Number of Overseas Posting',
                'style' => 'white-space:nowrap;',
            ),
        ));
        ?>
    </div>
</div>
<div id="oversea_pane" class="table-responsive">
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
                        <td><?php echo $form->textField($profile, 'overseaPosting[' . $i . '][year_start]', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
                        <td><?php echo $form->textField($profile, 'overseaPosting[' . $i . '][year_end]', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
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
<h4 class="fancy">Education Background</h4>
<div class="table-responsive">
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
                <th>University/Institute</th>
                <th>Country</th>
                <th class="text-center">From (Year)</th>
                <th class="text-center">To (Year)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>High School</td>
                <td><?php echo $form->textField($profile, 'educate_highschool', array('class' => 'form-control', 'style' => 'width:200px;')); ?></td>
                <td></td>
                <td><?php echo $form->dropDownList($profile, 'educate_highschool_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)', 'style' => 'width:250px;')); ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Bachelor Degree <span class="required">*</span></td>
                <td><?php echo $form->textField($profile, 'educate_bachelor', array('class' => 'form-control', 'style' => 'width:200px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_bachelor_university', array('class' => 'form-control')); ?></td>
                <td><?php echo $form->dropDownList($profile, 'educate_bachelor_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)', 'style' => 'width:250px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_bachelor_year_from', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
                <td><?php echo $form->textField($profile, 'educate_bachelor_year_to', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
            </tr>
            <tr>
                <td>Master Degree</td>
                <td><?php echo $form->textField($profile, 'educate_master', array('class' => 'form-control', 'style' => 'width:200px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_master_university', array('class' => 'form-control')); ?></td>
                <td><?php echo $form->dropDownList($profile, 'educate_master_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)', 'style' => 'width:250px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_master_year_from', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
                <td><?php echo $form->textField($profile, 'educate_master_year_to', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
            </tr>
            <tr>
                <td>Ph.D.</td>
                <td><?php echo $form->textField($profile, 'educate_phd', array('class' => 'form-control', 'style' => 'width:200px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_phd_university', array('class' => 'form-control')); ?></td>
                <td><?php echo $form->dropDownList($profile, 'educate_phd_country', CHtml::listData(CodeCountry::model()->sortBy('name_en')->findAll(), 'name_en', 'name_en'), array('class' => 'form-control', 'prompt' => '(Please select)', 'style' => 'width:250px;')); ?></td>
                <td><?php echo $form->textField($profile, 'educate_phd_year_from', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
                <td><?php echo $form->textField($profile, 'educate_phd_year_to', array('class' => 'form-control', 'maxlength' => 4)); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php if (Yii::app()->request->getQuery('mode') !== 'firsttime'): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#require_changename').change(function () {
                if ($(this).prop('checked')) {
                    $('#Profile_title_id_th').prop('disabled', false);
                    $('#Profile_title_th').prop('disabled', false);
                    $('#AccountProfileDiplomatThai_firstname_th').prop('disabled', false);
                    $('#AccountProfileDiplomatThai_lastname_th').prop('disabled', false);
                    $('#Profile_title_id_en').prop('disabled', false);
                    $('#Profile_title_en').prop('disabled', false);
                    $('#AccountProfileDiplomatThai_firstname_en').prop('disabled', false);
                    $('#AccountProfileDiplomatThai_lastname_en').prop('disabled', false);
                    $('#changename-pane').show();
                } else {
                    $('#Profile_title_id_th').prop('disabled', true);
                    $('#Profile_title_th').prop('disabled', true);
                    $('#AccountProfileDiplomatThai_firstname_th').prop('disabled', true);
                    $('#AccountProfileDiplomatThai_lastname_th').prop('disabled', true);
                    $('#Profile_title_id_en').prop('disabled', true);
                    $('#Profile_title_en').prop('disabled', true);
                    $('#AccountProfileDiplomatThai_firstname_en').prop('disabled', true);
                    $('#AccountProfileDiplomatThai_lastname_en').prop('disabled', true);
                    $('#changename-pane').hide();
                }
            });

            $('#require_changename').trigger('change');

        });
    </script>     
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#Profile_diplomat_level', function () {
            if ($(this).val() === '9999') {
                $('#Profile_diplomat_level_other').val('');
            }
        });
    });
</script>