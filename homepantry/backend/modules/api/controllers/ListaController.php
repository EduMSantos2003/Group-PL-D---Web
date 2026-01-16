<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;

use common\models\Lista;
use common\models\ListaProduto;

class ListaController extends ActiveController
{
    public $modelClass = 'common\models\Lista';

    /**
     *  DESATIVAR ACTIONS AUTOMÁTICAS DO ActiveController
     * (obrigatório para usar actionDelete personalizada)
     */
    public function actions()
    {
        $actions = parent::actions();

        // remover DELETE automático
        unset($actions['delete']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'             => ['GET'],
                'view'              => ['GET'],
                'create'            => ['POST'],
                'update'            => ['PUT', 'PATCH'],
                'delete'            => ['DELETE'],

                // Master / Detail
                'produtos'          => ['GET'],
                'adicionar-produto' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * GET /api/lista/{id}/produtos
     */
    public function actionProdutos($id)
    {
        $lista = Lista::findOne($id);

        if ($lista === null) {
            throw new NotFoundHttpException('Lista não encontrada');
        }

        $items = ListaProduto::find()
            ->where(['lista_id' => $id])
            ->with('produto')   // precisa da relation getProduto() no model
            ->all();

        $res = [];

        foreach ($items as $lp) {
            $res[] = [
                'id' => $lp->id,
                'lista_id' => $lp->lista_id,
                'produto_id' => $lp->produto_id,
                'produto_nome' => $lp->produto ? $lp->produto->nome : null,
                'quantidade' => $lp->quantidade,
                'precoUnitario' => $lp->precoUnitario,
                'subTotal' => $lp->subTotal,
            ];
        }

        return $res;
    }


    /**
     * POST /api/lista/{id}/adicionar-produto
     * Body JSON exemplo:
     * {
     *   "produto_id": 10,
     *   "quantidade": 2
     * }
     */
    public function actionAdicionarProduto($id)
    {
        $lista = Lista::findOne($id);

        if ($lista === null) {
            throw new NotFoundHttpException('Lista não encontrada');
        }

        $model = new ListaProduto();
        $model->lista_id = $id;

        // carregar JSON do body
        $model->load(Yii::$app->request->bodyParams, '');

        if ($model->save()) {
            return $model;
        }

        throw new BadRequestHttpException(json_encode($model->errors));
    }

    /**
     * DELETE /api/lista/{id}
     */
    public function actionDelete($id)
    {
        $model = Lista::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Lista não encontrada');
        }

        //  Impedir remoção se existirem produtos associados
        if ($model->getListaProdutos()->count() > 0) {
            throw new ConflictHttpException(
                'Não é possível apagar a lista porque tem produtos associados.'
            );
        }

        $model->delete();

        // 204 No Content
        Yii::$app->response->statusCode = 204;
    }
}
