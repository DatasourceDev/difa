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
<div class="row">
    <?php if ($model->isNewRecord): ?>
        <div class="col-md-6">
            <h4 class="fancy"><?php echo Yii::t('register', 'Account Information'); ?></h4>
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
                        'label' => 'ชื่อบัญชี',
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
    <?php endif; ?>
    <div class="col-md-6">
        <h4 class="fancy">ผู้ประสานงาน</h4>

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
    <div class="col-md-6">
        <h4 class="fancy">ข้อมูลหน่วยงาน/สังกัด</h4>
        <?php
        echo $form->dropDownListGroup($profile, 'work_office_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(CodeDepartment::model()->sortBy('name_en')->findAll(), 'id', 'name_en'),
                'htmlOptions' => array(
                    'prompt' => '(Please select)',
                ),
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($profile, 'work_office', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'labelOptions' => array(
                'label' => 'ระบุหน่วยงาน <span class="required">*</span>',
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
            'labelOptions' => array(
                'class' => 'nowrap',
            ),
            'hint' => 'กรุณากรอกข้อมูลชื่อหน่วยงานเป็นภาษาอังกฤษเพื่อออกใบรับรอง',
        ));
        ?>
    </div>
</div>
<?php if ($model->isNewRecord): ?>
    <h4 class="fancy">ข้อมูลรอบสอบที่ต้องการมอบหมาย</h4>
    <div class="row">
        <div class="col-sm-6">
            <?php
            echo $form->dropDownListGroup($model, 'default_exam_schedule_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(ExamSchedule::model()->sortBy('exam_code DESC')->findAll(), 'id', 'exam_code'),
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => 'รอบสอบ',
                ),
            ));
            ?>
            <?php
            echo $form->textFieldGroup($model, 'default_max_quota', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'placeholder' => '',
                    ),
                ),
                'labelOptions' => array(
                    'label' => 'จำนวนโควต้า',
                ),
            ));
            ?>
        </div>
        <div class="col-sm-6"></div>
    </div>
<?php endif; ?>
<div class="btn-toolbar well">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Cancel',
        'buttonType' => 'link',
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

    function initForm() {
        if ($('#AccountProfileOfficeUser_work_office_id').val() === '<?php echo CodeDepartment::OTHER; ?>') {
            $('#AccountProfileOfficeUser_work_office').closest('.form-group').show();
        } else {
            $('#AccountProfileOfficeUser_work_office').closest('.form-group').hide();
        }
    }
</script>