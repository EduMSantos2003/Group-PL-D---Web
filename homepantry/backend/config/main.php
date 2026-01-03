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

        'urlManager' => [

            'rules' => [

                // 🔹 CASA (MASTER)
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/casa'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        // MASTER → DETAIL
                        'GET {id}/locais' => 'locais',
                        'GET {id}/stock'  => 'stock', //StockProdutos
                    ],
                ],

                //Local
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/local'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET casa/{id}' => 'locais-casa',
                    ],
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/stock-produto'],  //StockProdutos
                    'pluralize' => false,
                ],


                // 🔹 LOCAL (DETAIL CRUD)
                // 🔥 API REST


                // PRODUTO (3.º CRUD)
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/produto'],
                    'pluralize' => false,
                ],
                //CATEGORIA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/categoria'],
                    'pluralize' => false,
                ],

                // 🔹 LISTA
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/lista'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/produtos' => 'produtos',
                        'POST {id}/produtos' => 'adicionar-produto',
                    ],

                ],

                // 🔹 LISTA PRODUTO
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/lista-produto'],
                    'pluralize' => false,
                ],

                // HISTORICO PRECO
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/historico-preco'],
                    'pluralize' => false,
                ],


            ],
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true
            ],
        ],

        'session' => [
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
    ],

];
