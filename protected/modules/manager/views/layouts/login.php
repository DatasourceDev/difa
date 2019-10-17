<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->module->title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/alt/bootstrap/css/bootstrap.min.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/alt/dist/css/AdminLTE.min.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/alt/dist/css/skins/skin-red-light.min.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/alt/css/style.css'); ?>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .login-page, .register-page {background:#6A499E;}
            .login-logo {color:#ffffff;}
        </style>
    </head>
    <body class="hold-transition login-page">
        <?php echo $content; ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/alt/plugins/jQuery/jQuery-2.1.4.min.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/alt/bootstrap/js/bootstrap.min.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/alt/dist/js/app.min.js', CClientScript::POS_END); ?>
    </body>
</html>
