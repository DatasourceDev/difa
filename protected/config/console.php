<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    // preloading 'log' component
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.models.custom.*',
        'application.components.*',
        'ext.giix.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'components' => array(
        'db' => require(dirname(__FILE__) . '/database.php'),
        'dbCore' => require(dirname(__FILE__) . '/database_backup.php'),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'logFile' => 'console.log',
                    'levels' => 'error, warning, trace',
                ),
            ),
        ),
    ),
);
