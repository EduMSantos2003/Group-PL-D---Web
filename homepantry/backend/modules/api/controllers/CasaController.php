<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use common\models\StockProduto;
use common\models\Casa;

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
        $casa = Casa::findOne($id);

        if ($casa === null) {
            throw new NotFoundHttpException('Casa não encontrada');
        }

        return $casa->locais;
    }
}
