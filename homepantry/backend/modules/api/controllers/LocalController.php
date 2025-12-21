<?php

    namespace backend\modules\api\controllers;

    use yii\rest\ActiveController;
    use yii\filters\VerbFilter;

class LocalController extends ActiveController
{
    /**
     * Modelo usado pelo controller
     * Cada request vai criar/ler instâncias de common\models\Local
     */
    public $modelClass = 'common\models\Local';

    /**
     * Define que métodos HTTP são permitidos
     * para cada ação REST
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'  => ['GET'],          // GET /api/local
                'view'   => ['GET'],          // GET /api/local/1
                'create' => ['POST'],         // POST /api/local ✅
                'update' => ['PUT','PATCH'],  // PUT /api/local/1
                'delete' => ['DELETE'],       // DELETE /api/local/1
            ],
        ];

        return $behaviors;
    }
}
