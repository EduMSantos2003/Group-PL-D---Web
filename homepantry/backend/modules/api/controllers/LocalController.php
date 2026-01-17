<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\web\ConflictHttpException;
use yii\db\IntegrityException;
use Yii;
use Throwable;
use common\models\Local;
use common\models\Produto;


class LocalController extends ActiveController
{
    public $modelClass = 'common\models\Local';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['access']);

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'        => ['GET'],
                'view'         => ['GET'],
                'create'       => ['POST'],
                'update'       => ['PUT','PATCH'],
                'delete'       => ['DELETE'],
                'locais-casa'  => ['GET'],
                'produtos'     => ['GET'],   // 👈 produtos por local
            ],
        ];

        return $behaviors;
    }

    /**
     * DESATIVAR DELETE AUTOMÁTICO
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']); //  FUNDAMENTAL
        return $actions;
    }

    protected function findModel($id)
    {
        $model = Local::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Local não encontrado.');
        }

        return $model;
    }


    /**
     *  DELETE /api/local/{id}
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $model->delete();

            Yii::$app->response->statusCode = 204;
            return null;

        } catch (IntegrityException $e) {

            throw new ConflictHttpException(
                'Não é possível apagar o local porque tem stock associado.'
            );

        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     *  GET /api/local/casa/{id}
     */
    public function actionLocaisCasa($id)
    {
        return Local::find()
            ->where(['casa_id' => $id])
            ->asArray()
            ->all();
    }

    /**
     * GET /api/local/{id}/produtos
     */
    public function actionProdutos($id)
    {
        $local = $this->findModel($id);

        return Produto::find()
            ->innerJoin('stock_produtos sp', 'sp.produto_id = produtos.id')
            ->where(['sp.local_id' => $id])
            ->asArray()
            ->all();
    }



}
