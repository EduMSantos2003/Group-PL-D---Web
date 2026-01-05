<?php

namespace backend\controllers;

use common\models\Casa;
use common\models\CasaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CasaUtilizador;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;



/**
 * CasaController implements the CRUD actions for Casa model.
 */
class CasaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['manageCasas'],
                        ],
                    ],
                    'denyCallback' => function () {
                        if (Yii::$app->user->isGuest) {
                            return Yii::$app->response->redirect(['/site/login']);
                        }
                        throw new ForbiddenHttpException('Não tem permissão para gerir casas.');
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Casa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CasaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Casa model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Casa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Casa();

        if ($this->request->isPost && $model->load($this->request->post())) {

            if ($model->save()) {

                //  ASSOCIA A CASA AO UTILIZADOR
                $casaUser = new CasaUtilizador();
                $casaUser->casa_id = $model->id;
                $casaUser->utilizador_id = Yii::$app->user->id;
                $casaUser->save(false);

                return $this->redirect(['index']);
            }

            // DEBUG (se falhar)
            echo '<pre>';
            print_r($model->errors);
            exit;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Casa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Casa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        CasaUtilizador::deleteAll(['casa_id' => $id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Casa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Casa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Casa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
