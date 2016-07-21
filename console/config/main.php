<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => '\console\controllers',
    'components' => [	
		'db_esm' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=202.53.254.83;dbname=dbc002',
                'username' => 'lgoffice321',
                'password' =>'r4h4514',
                'charset' => 'utf8',
        ],
		// 'response' => [
			// 'format' => yii\web\Response::FORMAT_JSON,
			// 'charset' => 'UTF-8',
			//...
		// ],
		/* 'makefile' => [
			'class' => '\console\controllers\Makefile',
		], */	
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		/* 'as access' => [
			'class' => 'mdm\admin\components\AccessControl',
			'allowActions' => [
				'*', // add or remove allowed actions to this list
			]
		], */
		/* 'request' => [
            'cookieValidationKey' => 'dWut4SrmYAaXg0NfqpPwnJa23RMIUG7j_it',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
            ]
        ], */
    ],
    'params' => $params,
];
