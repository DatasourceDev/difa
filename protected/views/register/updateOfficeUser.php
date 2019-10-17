<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'id' => 'frm-register',
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php echo $form->errorSummary(array($model, $profile)); ?>
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
        echo $form->dropDownListGroup($profile, 'work_office_type', array(
            'widgetOptions' => array(
                'data' => CodeDepartment::getDepartmentTypeOptions(),
                'htmlOptions' => array(
                    'class' => 'input-update',
                    'prompt' => '(Please select)',
                    'data-target' => '#Profile_work_office_id',
                    'disabled' => true,
                ),
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($profile, 'work_office_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeDepartment::model()->withIn($profile->work_office_type)->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'id' => 'Profile_work_office_id',
                    'prompt' => '(Please select)',
                    'disabled' => true,
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
                    'disabled' => true,
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_department', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                    'disabled' => true,
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
        echo $form->textFieldGroup($profile, 'contact_phone', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'contact_mobile', array(
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
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Cancel',
        'buttonType' => 'link',
        'url' => Yii::app()->homeUrl,
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