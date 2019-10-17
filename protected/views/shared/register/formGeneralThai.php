<?php
/* @var $form CodeskActiveForm */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery-file-upload-9.12.5/js/vendor/jquery.ui.widget.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery-file-upload-9.12.5/js/jquery.iframe-transport.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery-file-upload-9.12.5/js/jquery.fileupload.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/jquery-file-upload-9.12.5/css/jquery.fileupload.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/bootstrap-datepicker-thai.js'); ?>
<?php $requirePassword = isset($requirePassword) ? $requirePassword : true; ?>
<?php //echo $form->errorSummary(array($model, $profile));                                   ?>
<div id="form-register">
    <?php if ($model->isNewRecord): ?>
        <h4 class="fancy"><?php echo Yii::t('register', 'Account Information'); ?></h4>
        <div class="row">
            <div class="col-md-8">
                <div id="entry_pane">
                    <?php
                    echo $form->textFieldGroup($model, 'entry_code', array(
                        'widgetOptions' => array(
                            'htmlOptions' => array(
                                'id' => 'Account_entry_code',
                                'class' => 'input-update',
                                'data-target' => '#entry_pane',
                                'placeholder' => '',
                            ),
                        ),
                        'labelOptions' => array(
                            'style' => 'white-space:nowrap;',
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
                    ));
                    ?>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    <?php endif; ?>
    <h4 class="fancy">ข้อมูลผู้สมัคร</h4>
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
                'labelOptions' => array(
                    'label' => 'ระบุคำนำหน้า <span class="required">*</span>',
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'firstname_th', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                        'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
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
                        'disabled' => !$profile->isNewRecord && Yii::app()->request->getQuery('mode') !== 'firsttime',
                    ),
                ),
                'prepend' => Helper::image('lang_th'),
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
                        ?> ต้องการเปลี่ยน ชื่อ-นามสกุล
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
                        'hint' => 'เฉพาะไฟล์ประเภท ' . implode(',', Helper::getAllowedDocumentExtension()) . ' ที่มีขนาดไม่เกิน 1MB',
                        'labelOptions' => array(
                            'required' => true,
                        ),
                    ));
                    ?>
                </div>
            <?php endif; ?>
            <?php
            echo $form->datePickerGroup($profile, 'birth_date_th', array(
                'widgetOptions' => array(
                    'options' => array(
                        'format' => 'dd/mm/yyyy',
                        'language' => 'th',
                    ),
                    'htmlOptions' => array(
                        'id' => 'Profile_birth_date_th',
                        'class' => 'input-allow fake-th-date-picker',
                        'readonly' => true,
                        'placeholder' => Yii::t('register', 'dd-mm-yyyy (เช่น 15/01/2559)'),
                        'data-target' => '#Profile_birth_date',
                    ),
                ),
                'labelOptions' => array(
                    'label' => $form->labelEx($profile, 'birth_date'),
                ),
                'hint' => $form->error($profile, 'birth_date'),
                'append' => Helper::glyphicon('calendar'),
            ));
            ?>
            <?php
            echo $form->hiddenField($profile, 'birth_date', array(
                'id' => 'Profile_birth_date',
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'nationality_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeCountry::model()->forNationality()->sortBy('name_th')->findAll(), 'id', 'name_th'),
                    'htmlOptions' => array(
                        'prompt' => '(กรุณาเลือก)',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'religion_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeReligion::model()->findAll(), 'id', 'name_th'),
                    'htmlOptions' => array(
                        'id' => 'Profile_religion_id',
                        'prompt' => '(กรุณาเลือก)',
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
                'labelOptions' => array(
                    'label' => 'Other Title <span class="required">*</span>',
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'firstname_en', array(
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="fancy">ข้อมูลการทำงาน</h4>
            <?php
            echo $form->dropDownListGroup($profile, 'work_office_type', array(
                'widgetOptions' => array(
                    'data' => CodeDepartment::getDepartmentTypeOptions(),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_office_type',
                        'prompt' => '(กรุณาเลือก)',
                        'class' => 'input-update',
                        'data-target' => '#Profile_work_office_id',
                    ),
                ),
                'labelOptions' => array(
                    'class' => 'nowrap',
                ),
            ));
            ?>
            <?php
            echo $form->select2Group($profile, 'work_office_id', array(
                'widgetOptions' => array(
                    'asDropDownList' => false,
                    'options' => array(
                        'placeholder' => '(กรุณาเลือก)',
                        'allowClear' => true,
                        'formatResult' => 'js:formatDepartment',
                        'formatSelection' => 'js:formatDepartmentSelection',
                        'escapeMarkup' => 'js:function (m) { return m;}',
                        'ajax' => array(
                            'cache' => true,
                            'url' => $this->createUrl('/register/getDepartmentList'),
                            'data' => 'js:function(term, page){
                                return {
                                    work_office_type : $("#Profile_work_office_type").val(),
                                    term : term,
                                    page : page
                                }
                            }',
                            'results' => 'js:function(data, page, query){
                                return {results : data}
                            }',
                        ),
                        'initSelection' => 'js:function(element, callback) {        
                            var id = $(element).val();
                            if (id !== "") {
                                $.get("' . $this->createUrl('/register/getDepartmentList') . '" ,{ id : id, work_office_type : $("#Profile_work_office_type").val() }, function(data){
                                    callback(data);
                                },"json");
                            }
                        }',
                    ),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_office_id',
                        'prompt' => '(Please select)',
                    ),
                ),
                'labelOptions' => array(
                    'class' => 'nowrap',
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_office_other_th', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'id' => 'Profile_work_office_other_th',
                        'class' => 'text-uppercase',
                        'placeholder' => '',
                    ),
                ),
                'prepend' => Helper::image('lang_th'),
            ));
            ?>
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
            ));
            ?>

            <?php
            //echo $form->textFieldGroup($profile, 'work_department_th', array(
            //    'widgetOptions' => array(
            //        'htmlOptions' => array(
            //            'class' => 'text-uppercase',
            //            'placeholder' => '',
            //        ),
            //    ),
            //    'labelOptions' => array(
            //        'required' => true,
            //        'class' => 'nowrap',
            //    ),
            //    'prepend' => Helper::image('lang_th'),
            //));
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
            echo $form->dropDownListGroup($profile, 'work_level', array(
                'widgetOptions' => array(
                    'data' => $profile->getWorkLevelOptions(),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_level',
                        'prompt' => '(กรุณาเลือก)',
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
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'work_year', array(
                'widgetOptions' => array(
                    'data' => Helper::getYearList(100, true),
                    'htmlOptions' => array(
                        'prompt' => '(กรุณาเลือก)',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'emp_type', array(
                'widgetOptions' => array(
                    'data' => $profile->getEmpTypeOptions(),
                    'htmlOptions' => array(
                        'id' => 'Profile_emp_type',
                    ),
                ),
            ));
            ?>
            <div id="emp-pane">
                <?php
                echo $form->textFieldGroup($profile, 'emp_card', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => 'เลขที่บัตรข้าราชการ / พนักงานรัฐวิสาหกิจ',
                        ),
                    ),
                    'labelOptions' => array(
                        'required' => true,
                    ),
                ));
                ?>
                <div class="form-group">
                    <?php echo $form->labelEx($profile, 'emp_pic_file', array('class' => 'col-sm-4 control-label', 'required' => true)); ?>
                    <div class="col-sm-8">
                        <div id="register-photo" class="thumbnail">
                            <?php echo CHtml::image($profile->getPhotoUrl()); ?>
                        </div>
                        <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'label' => 'อัพโหลดไฟล์',
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
                <?php
                echo $form->datePickerGroup($profile, 'emp_card_issue_date_th', array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format' => 'dd/mm/yyyy',
                            'language' => 'th',
                        ),
                        'htmlOptions' => array(
                            'class' => 'input-allow fake-th-date-picker',
                            'data-target' => '#AccountProfileGeneralThai_emp_card_issue_date',
                            'placeholder' => Yii::t('register', 'dd/mm/yyyy (เช่น 01/10/2559)'),
                            'readonly' => true,
                        ),
                    ),
                    'labelOptions' => array(
                        'label' => $form->labelEx($profile, 'emp_card_issue_date'),
                        'required' => true,
                    ),
                    'hint' => $form->error($profile, 'emp_card_issue_date'),
                    'append' => Helper::glyphicon('calendar'),
                ));
                ?>
                <?php echo $form->hiddenField($profile, 'emp_card_issue_date'); ?>
                <?php
                echo $form->datePickerGroup($profile, 'emp_card_expire_date_th', array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format' => 'dd/mm/yyyy',
                            'language' => 'th',
                        ),
                        'htmlOptions' => array(
                            'class' => 'input-allow fake-th-date-picker',
                            'data-target' => '#AccountProfileGeneralThai_emp_card_expire_date',
                            'placeholder' => Yii::t('register', 'dd/mm/yyyy (เช่น 31/09/2560)'),
                            'readonly' => true,
                        ),
                    ),
                    'labelOptions' => array(
                        'label' => $form->labelEx($profile, 'emp_card_expire_date'),
                        'required' => true,
                    ),
                    'hint' => $form->error($profile, 'emp_card_expire_date'),
                    'append' => Helper::glyphicon('calendar'),
                ));
                ?>
                <?php echo $form->hiddenField($profile, 'emp_card_expire_date'); ?>
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
                        'label' => 'แนบไฟล์หลักฐาน ' . Helper::htmlRequired(),
                    ),
                    'hint' => 'เฉพาะไฟล์ประเภท ' . implode(',', Helper::getAllowedDocumentExtension()) . ' ที่มีขนาดไม่เกิน 1MB<br/>ตัวอย่างรูปแบบไฟล์ข้อมูล ' . CHtml::link('[ดาวน์โหลด]', array('//get/downloadSelfExample')),
                ));
                ?>
                <?php if (!$model->isNewRecord && $profile->selfFile->getFileUrl()): ?>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <?php
                            $this->widget('booster.widgets.TbButton', array(
                                'label' => 'ดาวน์โหลดไฟล์ที่แนบ',
                                'icon' => 'download',
                                'context' => 'info',
                                'url' => CHtml::value($this, 'module.id') === 'administrator' ? array('manageMember/getSelfFile', 'id' => $model->id) : array('my/getSelfFile'),
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
        <div class="col-md-6">
            <h4 class="fancy">ข้อมูลการศึกษา</h4>
            <?php
            echo $form->dropDownListGroup($profile, 'educate_degree', array(
                'widgetOptions' => array(
                    'data' => $profile->getEducationDegreeOptions(),
                    'htmlOptions' => array(
                        'id' => 'Profile_educate_degree',
                        'prompt' => '(กรุณาเลือก)',
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
                'labelOptions' => array(
                    'label' => 'โปรดระบุ <span class="required">*</span>',
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
                    'data' => CHtml::listData(CodeCountry::model()->sortBy('name_th')->findAll(), 'name_th', 'name_th'),
                    'htmlOptions' => array(
                        'prompt' => '(กรุณาเลือก)',
                    ),
                ),
            ));
            ?>
            <br/>
            <br/>
            <h4 class="fancy">ชื่อหน่วยงานที่ต้องการให้ระบุในใบรายงานผลสอบ (ภาษาอังกฤษ)</h4>
            <?php
            echo $form->textFieldGroup($profile, 'work_department', array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-md-12 text-center',
                ),
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class' => 'text-uppercase',
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => false,
                ),
                'prepend' => Helper::image('lang_en'),
                'hint' => '(กรุณากรอกเป็นภาษาอังกฤษ)',
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="fancy">ที่อยู่ที่ทำงาน</h4>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_name', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_homeno', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_building', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_floor', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_soi', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($profile, 'work_address_street', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'work_address_province_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeProvince::model()->sortBy('name')->findAll(), 'id', 'name'),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_address_province_id',
                        'class' => 'input-update',
                        'data-target' => '#Profile_work_address_amphur_id, #Profile_work_address_tumbon_id',
                        'prompt' => '(กรุณาเลือก)',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'work_address_amphur_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeAmphur::model()->sortBy('name')->findAllByAttributes(array(
                                'code_province_id' => $profile->work_address_province_id,
                            )), 'id', 'name'),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_address_amphur_id',
                        'class' => 'input-update',
                        'data-target' => '#Profile_work_address_tumbon_id',
                        'prompt' => '(กรุณาเลือก)',
                    ),
                ),
            ));
            ?>
            <?php
            echo $form->dropDownListGroup($profile, 'work_address_tumbon_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(CodeTumbon::model()->sortBy('name')->findAllByAttributes(array(
                                'code_province_id' => $profile->work_address_province_id,
                                'code_amphur_id' => $profile->work_address_amphur_id,
                            )), 'id', 'name'),
                    'htmlOptions' => array(
                        'id' => 'Profile_work_address_tumbon_id',
                        'prompt' => '(กรุณาเลือก)',
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
                ?> <strong>ใช้ที่อยู่เดียวกันกับที่ทำงาน</strong>
            </div>
            <h4 class="fancy">
                ที่อยู่สำหรับส่งผลสอบ
            </h4>
            <div id="reply_address_pane">
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_name', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_homeno', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_building', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_floor', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_soi', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->textFieldGroup($profile, 'reply_address_street', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'placeholder' => '',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->dropDownListGroup($profile, 'reply_address_province_id', array(
                    'widgetOptions' => array(
                        'data' => CHtml::listData(CodeProvince::model()->sortBy('name')->findAll(), 'id', 'name'),
                        'htmlOptions' => array(
                            'id' => 'Profile_reply_address_province_id',
                            'class' => 'input-update',
                            'data-target' => '#Profile_reply_address_amphur_id, #Profile_reply_address_tumbon_id',
                            'prompt' => '(กรุณาเลือก)',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->dropDownListGroup($profile, 'reply_address_amphur_id', array(
                    'widgetOptions' => array(
                        'data' => CHtml::listData(CodeAmphur::model()->sortBy('name')->findAllByAttributes(array(
                                    'code_province_id' => $profile->reply_address_province_id,
                                )), 'id', 'name'),
                        'htmlOptions' => array(
                            'id' => 'Profile_reply_address_amphur_id',
                            'class' => 'input-update',
                            'data-target' => '#Profile_reply_address_tumbon_id',
                            'prompt' => '(กรุณาเลือก)',
                            'disabled' => $profile->is_same_address === ActiveRecord::YES,
                        ),
                    ),
                ));
                ?>
                <?php
                echo $form->dropDownListGroup($profile, 'reply_address_tumbon_id', array(
                    'widgetOptions' => array(
                        'data' => CHtml::listData(CodeTumbon::model()->sortBy('name')->findAllByAttributes(array(
                                    'code_province_id' => $profile->reply_address_province_id,
                                    'code_amphur_id' => $profile->reply_address_amphur_id,
                                )), 'id', 'name'),
                        'htmlOptions' => array(
                            'id' => 'Profile_reply_address_tumbon_id',
                            'prompt' => '(กรุณาเลือก)',
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
            <h4 class="fancy">ข้อมูลการติดต่อ</h4>
            <div class="form-group">
                <?php echo $form->labelEx($profile, 'contact_phone', array('class' => 'control-label col-sm-4')); ?>
                <div class="col-sm-8">
                    <div class="form-inline">
                        <div class="form-group"><?php echo $form->textField($profile, 'contact_phone', array('class' => 'form-control input-numeric', 'style' => 'width:150px;', 'placeholder' => '', 'maxlength' => '9')); ?></div>
                        <div class="form-group"><?php echo $form->textField($profile, 'contact_phone_ext', array('class' => 'form-control', 'style' => 'width:80px;', 'placeholder' => 'ต่อ')); ?></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($profile, 'contact_fax', array('class' => 'control-label col-sm-4')); ?>
                <div class="col-sm-8">
                    <div class="form-inline">
                        <div class="form-group"><?php echo $form->textField($profile, 'contact_fax', array('class' => 'form-control input-numeric', 'style' => 'width:150px;', 'placeholder' => '', 'maxlength' => '9')); ?></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($profile, 'contact_mobile', array('class' => 'control-label col-sm-4')); ?>
                <div class="col-sm-8">
                    <div class="form-inline">
                        <div class="form-group"><?php echo $form->textField($profile, 'contact_mobile', array('class' => 'form-control input-numeric', 'style' => 'width:150px;', 'placeholder' => '', 'maxlength' => '10')); ?></div>
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
        <div class="col-md-6">
            <h4 class="fancy">บุคคลที่สามารถติดต่อในกรณีฉุกเฉิน</h4>
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
</div>
<?php if (Yii::app()->request->getQuery('mode') !== 'firsttime'): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#require_changename').change(function () {
                if ($(this).prop('checked')) {
                    $('#Profile_title_id_th').prop('disabled', false);
                    $('#Profile_title_th').prop('disabled', false);
                    $('#AccountProfileGeneralThai_firstname_th').prop('disabled', false);
                    $('#AccountProfileGeneralThai_lastname_th').prop('disabled', false);
                    $('#Profile_title_id_en').prop('disabled', false);
                    $('#Profile_title_en').prop('disabled', false);
                    $('#AccountProfileGeneralThai_firstname_en').prop('disabled', false);
                    $('#AccountProfileGeneralThai_lastname_en').prop('disabled', false);
                    $('#changename-pane').show();
                } else {
                    $('#Profile_title_id_th').prop('disabled', true);
                    $('#Profile_title_th').prop('disabled', true);
                    $('#AccountProfileGeneralThai_firstname_th').prop('disabled', true);
                    $('#AccountProfileGeneralThai_lastname_th').prop('disabled', true);
                    $('#Profile_title_id_en').prop('disabled', true);
                    $('#Profile_title_en').prop('disabled', true);
                    $('#AccountProfileGeneralThai_firstname_en').prop('disabled', true);
                    $('#AccountProfileGeneralThai_lastname_en').prop('disabled', true);
                    $('#changename-pane').hide();
                }
            });
            $('#require_changename').trigger('change');
        });
    </script>     
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function () {

        $('#btn-upload-pane').click(function () {
            $('#upload-modal').modal('show');
        });

        $(document).on('change', '#Profile_work_office_type', function () {
            $("#Profile_work_office_id").select2("val", null);
        });

        $(document).on('change', '#Profile_work_office_id', function () {
            if ($(this).val() === '9999') {
                $('#Profile_work_office_other_th').val('');
                $('#Profile_work_office_other_th').closest('.form-group').find('label').html('ชื่อหน่วยงาน <span class="required">*</span');

                $('#Profile_work_office_other').val('');
                $('#Profile_work_office_other').closest('.form-group').find('label').html('Agency <span class="required">*</span');

                $('#AccountProfileGeneralThai_work_department').closest('.form-group').find('label').html('Division <span class="required">*</span');
                $('#AccountProfileGeneralThai_work_department_th').closest('.form-group').find('label').html('หน่วยงาน/กรม/สำนัก <span class="required">*</span');
            } else {
                $('#Profile_work_office_other').closest('.form-group').find('label').html('Other Department <span class="required">*</span');
                $('#AccountProfileGeneralThai_work_department').closest('.form-group').find('label').html('Division <span class="required">*</span');

                $('#Profile_work_office_other_th').closest('.form-group').find('label').html('หน่วยงานอื่นๆ <span class="required">*</span');
                $('#AccountProfileGeneralThai_work_department_th').closest('.form-group').find('label').html('กรม/สำนัก <span class="required">*</span');
            }
        });
    });



    function formatDepartment(item) {
        if (item) {
            return  '<div>' + item.name_th + '<div><small class="text-muted">' + item.name_en + '</small></div></div>';
        }
    }
    function formatDepartmentSelection(item) {
        if (item) {
            return  item.name_th + ' / ' + item.name_en;
        }
    }
</script>
<?php
$this->renderPartial('application.views.shared.register.formGeneralThaiUpload', array(
    'model' => $profile,
));
?>
