<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'language' => 'en',
    'layout' => '/layouts/main',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.custom.*',
        'application.components.*',
        'ext.giix.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules' => array(
        'administrator' => array(
            'preload' => array('booster'),
            'components' => array(
                'booster' => array(
                    'class' => 'ext.yiibooster.components.Booster',
                ),
            ),
        ),
        'manager' => array(
            'preload' => array('booster'),
            'components' => array(
                'booster' => array(
                    'class' => 'ext.yiibooster.components.Booster',
                ),
            ),
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'lol',
            'ipFilters' => array('*'),
            'generatorPaths' => array(
                'ext.giix.generators',
            ),
        ),
    ),
    // application components
    'components' => array(
        'request' => array(
            //'enableCsrfValidation' => true,
            //'enableCookieValidation' => true,
        ),
        'session' => array(
            'class' => 'CDbHttpSession',
            'autoCreateSessionTable' => true,
            'connectionID' => 'db',
            'timeout' => 86400,
        ),
        'curl' => array(
            'class' => 'ext.curl.Curl',
        ),
        'qz' => array(
            'class' => 'ext.qz-print.QzPrintComponent',
            'signRequestUrl' => '/site/qzSignRequest',
        ),
        'exec' => array(
            'class' => 'ExecComponent',
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'encryption' => 'ssl',
                'username' => 'difates2016@gmail.com',
                'password' => 'ytxtvlrmupeytwqf',
                'port' => 465,
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),

        'widgetFactory' => array(
            'widgets' => array(
                'TbListView' => array(
                    'template' => '{items}{summary}{pager}',
                    'summaryText' => 'Displaying {start}-{end} of {count} result.',
                ),
                'TbGridView' => array(
                    'template' => '{items}{summary}{pager}',
                    'summaryText' => 'Displaying {start}-{end} of {count} result.',
                ),
                'TbDatePicker' => array(
                    'options' => array(
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ),
                ),
                'TbDateRangePicker' => array(
                    'options' => array(
                        'format' => 'YYYY-MM-DD',
                    ),
                ),
            ),
        ),
        'booster' => array(
            'class' => 'ext.yiibooster.components.Booster',
            'forceCopyAssets' => false,
        ),
        'format' => array(
            'class' => 'Formatter',
        ),
        'user' => array(
            'class' => 'WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'appendParams' => false,
            'showScriptName' => false,
            'urlFormat' => 'path',
            'rules' => array(
                'getQr' => 'get/qr',
                'getBarcode' => 'get/barcode',
                '<controller:(ktb)>/service.wsdl' => '<controller>/ws',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'dbCore' => require(dirname(__FILE__) . '/database_backup.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, trace',
                    'filter' => 'CLogFilter',
                    'maxFileSize' => 1024 * 64,
                    'maxLogFiles' => 20,
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'logFile' => 'access.log',
                    'filter' => 'CLogFilter',
                    'maxFileSize' => 1024 * 64,
                    'maxLogFiles' => 20,
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'warning',
                    'categories' => 'security',
                    'logFile' => 'security.log',
                    'filter' => 'CLogFilter',
                    'maxFileSize' => 1024 * 64,
                    'maxLogFiles' => 20,
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'autoreply@difa-tes.mfa.go.th',
        'taxId' => '099400016006290',
        'reCaptcha' => array(
            'url' => 'https://www.google.com/recaptcha/api/siteverify',
            'siteKey' => '6LdxHw4UAAAAACpaGWWuVapdNAmkFrQsFddzbhHc',
            'secret' => '6LdxHw4UAAAAAEwxBDxMGlEZqXRYfxkQgTPltH5C',
        ),
    ),
);
