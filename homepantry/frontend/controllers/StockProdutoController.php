<?php

namespace frontend\controllers;

use common\models\StockProduto;
use common\models\StockProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\Produto;
use Yii;
use common\models\Local;
use common\models\CasaUtilizador;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * StockProdutoController implements the CRUD actions for StockProduto model.
 */
class StockProdutoController extends Controller
{
    /**
     * @inheritDoc
     */

    public function actionGetPreco($id)
    {
        $produto = Produto::find()
            ->select(['preco'])
            ->where(['id' => $id])
            ->one();

        return $this->asJson([
            'preco' => $produto ? $produto->preco : null
        ]);
    }

    public function actionIncrement()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $stock = StockProduto::findOne($id);

        if (!$stock) {
            return ['success' => false];
        }

        $stock->quantidade += 1;

        // 🔒 recalcular a partir do preço do produto (mais correto)
        $precoUnitario = $stock->produto->preco;
        $stock->preco = $precoUnitario * $stock->quantidade;

        $stock->save(false);
        $stock->produto->atualizarUnidade();


        return [
            'success' => true,
            'quantidade' => $stock->quantidade,
            'preco' => $stock->preco,
        ];
    }


    public function actionDecrement()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $stock = StockProduto::findOne($id);

        if (!$stock || $stock->quantidade <= 0) {
            return ['success' => false];
        }

        $stock->quantidade -= 1;

        $precoUnitario = $stock->produto->preco;
        $stock->preco = $precoUnitario * $stock->quantidade;

        $stock->save(false);
        $stock->produto->atualizarUnidade();


        return [
            'success' => true,
            'quantidade' => $stock->quantidade,
            'preco' => $stock->preco,
        ];
    }

    public function behaviors()
    {
        // Ambiente de testes → RBAC desligado
        if (defined('YII_ENV_TEST') && YII_ENV_TEST) {
            return [
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        // Ambiente normal (dev / prod) → RBAC ativo
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [

                    // Ver stock → qualquer user autenticado
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],

                    // Membro da casa
                    [
                        'allow' => true,
                        'actions' => ['increment', 'decrement', 'update'],
                        'roles' => ['membroCasa'],
                    ],

                    // Gestor de stock
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete', 'increment', 'decrement'],
                        'roles' => ['manageStock'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all StockProduto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StockProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StockProduto model.
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
     * Creates a new StockProduto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new StockProduto();

        $userId = Yii::$app->user->id;

        // casas do utilizador
        $casasIds = CasaUtilizador::find()
            ->select('casa_id')
            ->where(['utilizador_id' => $userId]);

        // locais dessas casas
        $locais = Local::find()
            ->where(['casa_id' => $casasIds])
            ->orderBy('nome')
            ->all();

        // formato para dropdown
        $locaisList = ArrayHelper::map($locais, 'id', 'nome');

        // SUBMIT
        if ($model->load($this->request->post())) {

            $produto = Produto::findOne($model->produto_id);

            if ($produto) {
                $model->preco = $produto->preco * $model->quantidade;
                $model->validade = $produto->validade;
            }

            $model->utilizador_id = $userId;

            if ($model->save()) {
                $model->produto->atualizarUnidade();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'locaisList' => $locaisList,
        ]);
    }




    /**
     * Updates an existing StockProduto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $quantidadeOriginal = $model->quantidade;

        $userId = Yii::$app->user->id;

        // casas do utilizador
        $casasIds = CasaUtilizador::find()
            ->select('casa_id')
            ->where(['utilizador_id' => $userId]);

        // locais dessas casas
        $locais = Local::find()
            ->where(['casa_id' => $casasIds])
            ->orderBy('nome')
            ->all();

        $locaisList = ArrayHelper::map($locais, 'id', 'nome');

        if ($model->load($this->request->post())) {
            $model->quantidade = $quantidadeOriginal; // 🔒 bloqueia alteração
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'locaisList' => $locaisList,
        ]);
    }



    /**
     * Deletes an existing StockProduto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // 1️⃣ Obter o modelo corretamente
        $model = $this->findModel($id);

        // 2️⃣ Guardar o produto associado (antes de apagar)
        $produto = $model->produto;

        try {
            // 3️⃣ Apagar o stock_produto
            $model->delete();

            // 4️⃣ Atualizar stock do produto (se existir)
            if ($produto !== null) {
                $produto->atualizarUnidade();
            }

            // 5️⃣ Mensagem de sucesso
            Yii::$app->session->setFlash(
                'success',
                'Produto removido do stock com sucesso.'
            );

        } catch (\yii\db\IntegrityException $e) {

            // 6️⃣ Mensagem de erro amigável
            Yii::$app->session->setFlash(
                'error',
                'Não é possível apagar este registo porque está associado a outros dados.'
            );
        }

        // 7️⃣ Redirecionar
        return $this->redirect(['index']);
    }


    /**
     * Finds the StockProduto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StockProduto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockProduto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
