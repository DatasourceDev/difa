<div class="topic">Member Profile <small>(ประเภท ตัวแทนหน่วยงาน)</small></div>
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
                ));
                ?>
            </div>
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
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">ข้อมูลหน่วยงาน/สังกัด</h4>
        <?php
        echo $form->dropDownListGroup($profile, 'work_office_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeDepartment::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'id' => 'Profile_work_office_id',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_office', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'Profile_work_office',
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_department', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 class="fancy">ข้อมูลการติดต่อ</h4>
        <?php
        echo $form->emailFieldGroup($profile, 'contact_phone', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->emailFieldGroup($profile, 'contact_mobile', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
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
<h4 class="fancy">คำถามสำหรับความปลอดภัย</h4>
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
                    'prompt' => '(กรุณาเลือก)',
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
                    'prompt' => '(กรุณาเลือก)',
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
        <h4 class="fancy">รหัสป้องกัน Spam</h4>
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
        'url' => array('/register'),
    ));
    ?>
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
    });

    function initForm() {
        if ($('#Profile_work_office_id').val() === '9999') {
            $('#Profile_work_office').closest('.form-group').show();
        } else {
            $('#Profile_work_office').closest('.form-group').hide();
        }
    }
</script>