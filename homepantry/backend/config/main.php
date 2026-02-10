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

    // ACCESS CONTROL (apenas para back-office)
    'as access' => [
        'class' => \yii\filters\AccessControl::class,
        'except' => [
            'site/login',
            'site/error',
            'site/logout',

            // API toda fora do back-office access control
            'api/*',
        ],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin', 'gestorCasa'],
            ],
        ],
        'denyCallback' => function () {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(['/site/login']);
            }
            throw new \yii\web\ForbiddenHttpException(
                'Não tem permissões para aceder ao back-office.'
            );
        },
    ],

    // 🔌 API MODULE
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\Module',
        ],
    ],

    'components' => [

        // JSON entrada (POST / PUT / PATCH)
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],

        // JSON saída
        //'response' => [
        //    'format' => yii\web\Response::FORMAT_JSON,
        //    'charset' => 'UTF-8',
        //],

        // USER (API token / sem sessão)
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],

        //  URL MANAGER
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,

            'rules' => [

                //  AUTH (LOGIN)
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/auth'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ],
                ],

                // MATEMÁTICA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/matematica'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET raizdois' => 'raizdois',
                    ],
                ],

                // CASA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/casa'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/locais'   => 'locais',
                        'GET {id}/stock'    => 'stock',
                        'GET {id}/produtos' => 'produtos',
                    ],
                ],

                // LOCAL
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/local'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET casa/{id}'     => 'locais-casa',
                        'GET {id}/produtos' => 'produtos',
                    ],
                ],

                // STOCK PRODUTO
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/stock-produto'],
                    'pluralize' => false,
                ],

                // PRODUTO
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/produto'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/historico-preco' => 'historico-preco',
                    ],
                ],

                // CATEGORIA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/categoria'],
                    'pluralize' => false,
                ],

                // LISTA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/lista'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/produtos'  => 'produtos',
                        'POST {id}/produtos' => 'adicionar-produto',
                    ],
                ],

                // LISTA-PRODUTO
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/lista-produto'],
                    'pluralize' => false,
                ],
            ],
        ],

        // SESSION (opcional, para backoffice)
        'session' => [
            'name' => 'advanced-backend',
        ],

        // LOG
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        // ERROS
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],

    'params' => $params,
];
