<?php

namespace frontend\controllers;

use yii;
use common\models\Produto;
use common\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/** @var common\models\Produto[] $produtos */
/** @var common\models\ProdutoSearch $searchModel */



/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        // 🔬 Ambiente de testes → RBAC desligado
        if (defined('YII_ENV_TEST') && YII_ENV_TEST) {
            return [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }
        // 🔐 Produção / desenvolvimento normal → RBAC ativo
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['viewStock'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['manageStock'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Produto models.
     *
     * @return string
     */
    /*public function actionIndex()
    {
        $produtos = Produto::find()->all();

        return $this->render('index', [
            'produtos' => $produtos,
        ]);
    }*/
    public function actionIndex()
    {
        $searchModel = new \common\models\ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'produtos' => $dataProvider->getModels(),
        ]);
    }



    /**
     * Displays a single Produto model.
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
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload() && $model->save(false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        $oldImage = $model->imagem; // guarda imagem antiga

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            // usa SEMPRE a lógica do model
            if (!$model->upload()) {
                return $this->render('update', ['model' => $model]);
            }

            // se não foi feito upload novo, mantém a antiga
            if (!$model->imageFile) {
                $model->imagem = $oldImage;
            }

            if ($model->save(false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        //Verificar se o produto está associado a alguma lista
        if ($model->getListaProdutos()->count() > 0) {
            Yii::$app->session->setFlash(
                'error',
                'Não é possível apagar o produto porque está associado a uma ou mais listas.'
            );

            return $this->redirect(['index']);
        }

        // Se não estiver associado, pode apagar
        $model->delete();

        Yii::$app->session->setFlash(
            'success',
            'Produto apagado com sucesso.'
        );

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
