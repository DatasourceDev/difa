<div class="row">
    <div class="col-sm-8">
        <div class="topic"><?php echo Helper::t('Member Login', 'Member Login'); ?></div>
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'login-form',
            'type' => 'horizontal',
            'enableClientValidation' => true,
            'focus' => array($model, 'username'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <?php
        echo $form->textFieldGroup($model, 'username', array(
            'prepend' => Helper::glyphicon('user'),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => 'เลขบัตรประจำตัวประชาชน 13 หลัก',
                ),
            ),
            'labelOptions' => array(
                'label' => Helper::t('Username', 'Username'),
            ),
        ));
        ?>
        <?php
        echo $form->passwordFieldGroup($model, 'password', array(
            'prepend' => Helper::glyphicon('lock'),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'placeholder' => '',
                ),
            ),
            'labelOptions' => array(
                'label' => Helper::t('Password', 'Password'),
            ),
        ));
        ?>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'Login',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'Forgot Password?',
                    'buttonType' => 'link',
                    'context' => 'warning',
                    'url' => array('site/forgot'),
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'Forgot Username?',
                    'buttonType' => 'link',
                    'context' => 'warning',
                    'url' => array('site/forgotUsername'),
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <div class="text-danger">
                    * Username is your identification
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'register-general-modal',
));
?>
<div class="modal-header bg-primary">
    <h3 class="fancy modal-title text-center"><?php echo Yii::t('register', 'Please select'); ?></h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Thai'),
                'block' => true,
                'context' => 'success',
                'buttonType' => 'link',
                'url' => array('register/createGeneralThai'),
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Foreigner'),
                'block' => true,
                'context' => 'warning',
                'buttonType' => 'link',
                'url' => array('register/createGeneralForeigner'),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-register-general').on('click', function () {
            checkButtonState($(this));
        });
        checkButtonState($('#btn-register-general'));
    });

    function checkButtonState(e) {
        if (!$(e).hasClass('active')) {
            $('#general-pane').show();
        } else {
            $('#general-pane').hide();
        }
        return false;
    }
</script>