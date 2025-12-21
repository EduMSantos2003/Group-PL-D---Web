<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class CasaController extends ActiveController
{
    public $modelClass = Casa::class;

    /**
     * Expõe o endpoint:
     * GET /api/casa/{id}/locais
     */
    public function actions()
    {
        $actions = parent::actions();

        // Desativamos o "view" default
        unset($actions['view']);

        return $actions;
    }

    /**
     * ACTION PERSONALIZADA (Master → Detail)
     */
    public function actionLocais($id)
    {
        // 1️⃣ Procurar a casa (MASTER)
        $casa = Casa::findOne($id);

        if ($casa === null) {
            throw new NotFoundHttpException('Casa não encontrada');
        }

        // 2️⃣ Devolver os Locais associados
        return $casa->locais;
    }
}

