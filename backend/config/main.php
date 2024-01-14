<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        // 后台认证从Adminuser中匹配
        'user' => [
            'identityClass' => 'common\models\Adminuser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        	'suffix'=>'.html',
            'rules' => [
            	'<controller:(post|comment)>s'=>'<controller>/index',
            	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
            	'<controller:\w+>/<id:\d+>/<action:(create|update|delete)>'=>'<controller>/<action>',
                // 添加 RSS Feed 路由
                'rss' => 'site/rss',
            ],
        ],
    ],
    'params' => $params,
];
