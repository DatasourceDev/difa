<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $this->module->title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/css/normalize.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/css/main.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/css/style.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/css/navbar.customize.css'); ?>
        <?php Yii::app()->clientScript->registerCssFile($this->module->assetUrl . '/css/mobile.css'); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/modernizr-2.8.3.min.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/store.min.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/vendor/jquery-idleTimeout.min.js'); ?>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php echo $content; ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/plugins.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile($this->module->assetUrl . '/js/main.js', CClientScript::POS_END); ?>
    </body>
</html>
