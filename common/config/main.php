<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true
        ],
        'errorHandler' => [
            //web
            'class' => 'bedezign\yii2\audit\components\web\ErrorHandler'
        ]
    ],
    'modules' => [
        'gii',
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableRegistration' => false,
            'enableGeneratingPassword' => true,
            'admins' => ['admin']
        ],
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            // List of actions to track. '*' is allowed as the last character to use as wildcard
            'trackActions' => ['*'], 
            // Actions to ignore. '*' is allowed as the last character to use as wildcard (eg 'debug/*')
            'ignoreActions' => ['audit/*', 'debug/*'],
            // Maximum age (in days) of the audit entries before they are truncated
            'maxAge' => '60',
            // IP address or list of IP addresses with access to the viewer, null for everyone (if the IP matches)
            // 'accessIps' => ['127.0.0.1', '192.168.*'], 
            // Role or list of roles with access to the viewer, null for everyone (if the user matches)
            'accessRoles' => null,
            // User ID or list of user IDs with access to the viewer, null for everyone (if the role matches)
            'accessUsers' => [1],
            // 'userIdentifierCallback' => ['dektrium\user\models\User', 'getUserName'],
            // Compress extra data generated or just keep in text? For people who don't like binary data in the DB
            'compressData' => true,
            'panels' => [
                'audit/request',
                'audit/error',
                'audit/trail'
            ],
            'panelsMerge' => [
                'audit/curl' => ['log' => false],
            ],
        ],
    ],
];
