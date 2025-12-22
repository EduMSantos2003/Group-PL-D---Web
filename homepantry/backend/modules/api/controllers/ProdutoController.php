<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],        // GET /api/produto
                'view'   => ['GET'],        // GET /api/produto/1
                'create' => ['POST'],       // POST /api/produto
                'update' => ['PUT','PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }
}
