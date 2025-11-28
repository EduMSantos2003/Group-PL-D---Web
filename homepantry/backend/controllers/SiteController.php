<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'index', 'error'],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        // guest → manda para login
                        return Yii::$app->response->redirect(['/site/login']);
                    }

                    // autenticado mas sem permissão
                    throw new \yii\web\ForbiddenHttpException('Não tens permissões para aceder ao backend.');
                },
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        // qualquer user autenticado pode fazer logout
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        // só admin e gestorCasa podem ver o dashboard
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'gestorCasa'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Ajusta os namespaces/model names se for preciso
        $stats = [
            'utilizadores' => \common\models\User::find()->count(),
            'casas'        => \common\models\Casa::find()->count(),
            'produtos'     => \common\models\Produto::find()->count(),
            'listas'       => \common\models\Lista::find()->count(),
            'locais'       => \common\models\Local::find()->count(),
        ];

        // Produtos em stock a terminar em breve (ex: próximos 7 dias)
        $produtosExpirar = \common\models\StockProduto::find()
            ->with('produto')
            ->orderBy(['validade' => SORT_ASC])
            ->limit(5)
            ->all();

        // Listas recentes
        $listasRecentes = \common\models\Lista::find()
            ->orderBy(['dataCriacao' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('index', [
            'stats'           => $stats,
            'produtosExpirar' => $produtosExpirar,
            'listasRecentes'  => $listasRecentes,
        ]);
    }


    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //$this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
