<?php

return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'NST Cron',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.components.*',
        'application.models.*',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
 
        // Your DB connection
        'db'=>array(
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=nst',
            'emulatePrepare' => true,
            'username' => 'postgres',
            'password' => '911911',
            'charset' => 'utf8',
        ),
    ),

    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'smsAccount'    => '30004',
        'smsPassword'   => md5('sunyusunyu123'),
    ),
);