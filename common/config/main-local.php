<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=db;dbname=ptt',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
        ],
        'hosxpDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ptt',
            'username' => 'root',
            'password' => 'P@ssw0rd2@19##',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        // 'mongodb' => [
        //     'class' => '\yii\mongodb\Connection',
        //     //'dsn' => 'mongodb+srv://freeman:abcd1234@cluster0-1108c.mongodb.net/intel',
        //     // -- Local
        //     'dsn' => 'mongodb://freeman:abcd1234@database:27017/intel', 
        //     //    -- joth14 - cloud
        //     //'dsn' => 'mongodb+srv://admin:abcd1234@cluster0-qbizb.mongodb.net/textx',
            
        //     'defaultDatabaseName'=>'intel',
        // ],
         'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb+srv://freeman:abcd1234@cluster0-1108c.mongodb.net/images_project',
            'defaultDatabaseName'=>'images_project',
        ],
    ],
];
