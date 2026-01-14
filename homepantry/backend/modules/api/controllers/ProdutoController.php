<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ConflictHttpException;
use yii\db\IntegrityException;
use Throwable;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remover AccessControl (como em Casa)
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

    public function actions()
    {
        $actions = parent::actions();

        // vamos tratar o delete manualmente
        unset($actions['delete']);

        return $actions;
    }

    /**
     * DELETE /api/produto/{id}
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->modelClass::findOne($id);

            if ($model === null) {
                throw new NotFoundHttpException('Produto não encontrado.');
            }

            $model->delete();

            \Yii::$app->response->statusCode = 200;
            return ['message' => 'Produto apagado com sucesso'];

        } catch (IntegrityException $e) {

            throw new ConflictHttpException(
                'Não é possível apagar o produto porque está associado a stock ou histórico.'
            );

        } catch (Throwable $e) {
            throw $e;
        }
    }
}
