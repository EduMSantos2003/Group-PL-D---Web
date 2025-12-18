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
    'as access' => [
        'class' => \yii\filters\AccessControl::class,
        'except' => [
            'site/login',
            'site/error',
            'site/logout',
            'api/*'
        ],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin', 'gestorCasa'],
            ],
        ],



        'denyCallback' => function ($rule, $action) {
            if (\Yii::$app->user->isGuest) {
                // não autenticado → vai para login
                return \Yii::$app->response->redirect(['/site/login']);
            }
            // autenticado mas sem permissões → 403
            throw new \yii\web\ForbiddenHttpException(
                'Não tem permissões para aceder ao back-office.'
            );
        },
    ],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\Module',
        ],
    ],
    'components' => [

        'urlManager'=>[
            'enablePrettyUrl' => false,
            'showScriptName'=>false,
            'rules'=>[
                ['class'=>'yii\rest\UrlRule','controller'=>'api/casa'],
            ],
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
