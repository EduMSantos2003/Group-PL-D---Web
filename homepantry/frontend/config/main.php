<?php

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],

    // COMPORTAMENTO GLOBAL DE ACESSO (FRONTEND)
    'as access' => [
        'class' => AccessControl::class,
        'denyCallback' => function ($rule, $action) {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(['site/login']);
            }
            throw new ForbiddenHttpException('Não tens permissão para aceder a esta página.');
        },
        'rules' => [
            // --- ROTAS PÚBLICAS (SEM LOGIN) ---
            [
                'allow' => true,
                'controllers' => ['site'],
                'actions' => [
                    'index',
                    'login',
                    'logout',
                    'signup',
                    'error',
                    'request-password-reset',
                    'reset-password',
                ],
            ],

            // --- RESTO DO FRONTEND: APENAS LOGIN OBRIGATÓRIO ---
            [
                'allow' => true,
                'roles' => ['@'], // qualquer utilizador autenticado
            ],
        ],
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'advanced-frontend',
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
    ],
    'params' => $params,
];
