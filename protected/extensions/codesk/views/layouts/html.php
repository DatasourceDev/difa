<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo isset($this->title) ? CHtml::encode($this->title) . ' - ' : ''; ?><?php echo Yii::app()->name; ?></title>
        <meta name="description" content="<?php echo CHtml::value($this, 'meta.description'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo Yii::app()->baseUrl; ?>/images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->codesk->assetUrl . '/css/normalize.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->codesk->assetUrl . '/css/main.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->codesk->assetUrl . '/css/style.css'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->codesk->assetUrl . '/js/vendor/modernizr-2.6.2.min.js'); ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <?php echo $content; ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->codesk->assetUrl . '/js/plugins.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->codesk->assetUrl . '/js/main.js', CClientScript::POS_END); ?>
    </body>
</html>
