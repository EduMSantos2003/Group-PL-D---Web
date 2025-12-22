<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],          // GET /api/categoria
                'view'   => ['GET'],          // GET /api/categoria/1
                'create' => ['POST'],         // POST /api/categoria
                'update' => ['PUT', 'PATCH'], // PUT /api/categoria/1
                'delete' => ['DELETE'],       // DELETE /api/categoria/1
            ],
        ];

        return $behaviors;
    }
}
