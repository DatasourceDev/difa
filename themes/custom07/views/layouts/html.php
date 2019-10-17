<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Devawongse Varopakarn Institute of Foreign Affairs</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/normalize.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/core.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/style.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/navbar.customize.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/mobile.css'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/modernizr-2.8.3.min.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile('https://www.google.com/recaptcha/api.js');?>
        <!--    Overrided by settings -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/customTheme'?>">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php echo $content; ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js', CClientScript::POS_END); ?>
    </body>
</html>
