<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use Yii;
use common\models\Local;

use yii\web\Response;
use yii\filters\ContentNegotiator;

class LocalController extends ActiveController
{
    public $modelClass = 'common\models\Local';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove AccessControl herdado
        unset($behaviors['access']);

        //  FORÇAR JSON SEMPRE
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index'        => ['GET'],          // GET /api/local
                'view'         => ['GET'],          // GET /api/local/1
                'create'       => ['POST'],         // POST /api/local
                'update'       => ['PUT','PATCH'],  // PUT /api/local/1
                'delete'       => ['DELETE'],       // DELETE /api/local/1
                'locais-casa'  => ['GET'],          // GET /api/local/casa/2
            ],
        ];

        return $behaviors;
    }

    /**
     * 🔥 GET /api/local/casa/{id}
     * Devolve os locais de uma casa (JSON PURO)
     */
    public function actionLocaisCasa($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Local::find()
            ->where(['casa_id' => $id])
            ->asArray()
            ->all();
    }
}
