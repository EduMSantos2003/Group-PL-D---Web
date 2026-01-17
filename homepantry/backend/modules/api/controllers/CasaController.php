<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use common\models\StockProduto;
use common\models\Casa;
use yii\web\Response;
use common\models\Produto;

class CasaController extends ActiveController
{
    public $modelClass = Casa::class;

    public function actions()
    {
        $actions = parent::actions();

        // desativa o view default (não é obrigatório, mas está ok)
        unset($actions['view']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove AccessControl
        unset($behaviors['access']);

        // FORÇAR JSON
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    protected function findModel($id)
    {
        $model = Casa::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Casa não encontrada.');
        }

        return $model;
    }





    public function actionStock($id)
    {
        $casa = Casa::find()
            ->where(['id' => $id])
            ->with([
                'locais.stockProdutos.produto'
            ])
            ->one();

        if (!$casa) {
            throw new \yii\web\NotFoundHttpException('Casa não encontrada');
        }

        $resultado = [];

        foreach ($casa->locais as $local) {
            foreach ($local->stockProdutos as $stock) {
                $resultado[] = [
                    'local' => $local->nome,
                    'produto_id' => $stock->produto_id,
                    'produto' => $stock->produto->nome,
                    'quantidade' => $stock->quantidade,
                    'validade' => $stock->validade,
                    'preco' => $stock->preco,
                ];
            }
        }

        return $resultado;
    }



    /**
     * GET /api/casa/{id}/locais
     * MASTER → DETAIL
     */
    public function actionLocais($id)
    {
        return \common\models\Local::find()
            ->select(['id', 'casa_id', 'nome'])
            ->where(['casa_id' => $id])
            ->asArray()
            ->all();
    }

    /**
     * GET /api/casa/{id}/produtos
     */
    public function actionProdutos($id)
    {
        // valida se a casa existe
        $this->findModel($id);

        return Produto::find()
            ->innerJoin('stock_produtos sp', 'sp.produto_id = produtos.id')
            ->innerJoin('locais l', 'l.id = sp.local_id')
            ->where(['l.casa_id' => $id])
            ->distinct()
            ->asArray()
            ->all();
    }




}
