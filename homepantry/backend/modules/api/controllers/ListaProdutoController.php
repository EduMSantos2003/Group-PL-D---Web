<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;

class ListaProdutoController extends ActiveController
{
    public $modelClass = 'common\models\ListaProduto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],
                'view'   => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT','PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }
}
