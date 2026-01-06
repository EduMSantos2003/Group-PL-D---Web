<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\web\ConflictHttpException;
use yii\db\IntegrityException;
use yii\web\NotFoundHttpException;

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],
                'view'   => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }

    // desativar delete default
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }

    // 🔹 FIND MODEL (OBRIGATÓRIO)
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Categoria não encontrada.');
    }

    // DELETE personalizado
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try {
            $model->delete();
            return [
                'success' => true,
                'message' => 'Categoria apagada com sucesso'
            ];
        } catch (IntegrityException $e) {
            throw new ConflictHttpException(
                'Não é possível apagar a categoria porque existem produtos associados.'
            );
        }
    }
}