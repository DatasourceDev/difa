<div class="login-box">
    <div class="login-logo">
        <b>DVIFA</b> Test Manager
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = $this->beginWidget('CActiveForm'); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="form-group has-feedback">
            <?php echo $form->textField($model, 'username', array('type' => 'email', 'class' => 'form-control', 'placeholder' => 'Username')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->passwordField($model, 'password_input', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
            <?php echo $form->error($model, 'password_input'); ?>
        </div>
        <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#User_username').select();
    });
</script>