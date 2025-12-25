<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

use yii\filters\VerbFilter;
use common\components\MqttHelper;
use common\models\Local;


class StockProdutoController extends ActiveController
{
    public $modelClass = 'common\models\StockProduto';

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

    //CREATE MQTT   PUBLISH
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(\Yii::$app->request->bodyParams, '');

        if (!$model->save()) {
            return $model;
        }

        // descobrir a casa através do local
        $local = Local::findOne($model->local_id);

        if ($local) {
            $topic = "casa/{$local->casa_id}/stock";
            MqttHelper::publish($topic, 'Stock atualizado POST');
        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(\Yii::$app->request->bodyParams, '');

        if (!$model->save()) {
            return $model;
        }

        $local = Local::findOne($model->local_id);

        if ($local) {
            $topic = "casa/{$local->casa_id}/stock";
            MqttHelper::publish($topic, 'Stock atualizado UPDATE');
        }

        return $model;
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $local = Local::findOne($model->local_id);

        $model->delete();

        if ($local) {
            $topic = "casa/{$local->casa_id}/stock";
            MqttHelper::publish($topic, 'Stock atualizado DELETE');
        }

        \Yii::$app->response->statusCode = 204;
    }




}
