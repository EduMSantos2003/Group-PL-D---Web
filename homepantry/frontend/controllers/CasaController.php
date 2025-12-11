<?php


namespace frontend\controllers;

use common\models\Casa;
use common\models\CasaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;



class CasaController extends \yii\web\Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            // Apenas quem tiver a permissão manageCasas (gestorCasa, admin)
                            'roles' => ['manageCasas'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        if (\Yii::$app->user->isGuest) {
                            return \Yii::$app->response->redirect(['/site/login']);
                        }
                        throw new ForbiddenHttpException('Não tem permissão para aceder a esta página.');
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
