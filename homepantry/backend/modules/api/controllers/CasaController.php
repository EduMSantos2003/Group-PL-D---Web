<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
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
