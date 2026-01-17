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

        $local = Local::findOne($model->local_id);

        if ($local) {
            $topic = "casa/{$local->casa_id}/stock";

            $payload = [
                'acao' => 'create',
                'casa_id' => $local->casa_id,
                'local_id' => $model->local_id,
                'produto_id' => $model->produto_id,
                'quantidade' => $model->quantidade,
            ];

            MqttHelper::publish($topic, json_encode($payload));
        }

        return $model;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function () {
            $query = \common\models\StockProduto::find()
                ->with(['produto', 'local']);

            $localId = \Yii::$app->request->get('local_id');
            if ($localId) {
                $query->andWhere(['local_id' => $localId]);
            }

            $casaId = \Yii::$app->request->get('casa_id');
            if ($casaId) {
                $query->joinWith('local')
                    ->andWhere(['local.casa_id' => $casaId]);
            }

            return new \yii\data\ActiveDataProvider([
                'query' => $query,
                'pagination' => false
            ]);
        };

        return $actions;
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

            $payload = [
                'acao' => 'update',
                'casa_id' => $local->casa_id,
                'local_id' => $model->local_id,
                'produto_id' => $model->produto_id,
                'quantidade' => $model->quantidade,
            ];

            MqttHelper::publish($topic, json_encode($payload));
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

            $payload = [
                'acao' => 'delete',
                'casa_id' => $local->casa_id,
                'local_id' => $model->local_id,
                'produto_id' => $model->produto_id,
            ];

            MqttHelper::publish($topic, json_encode($payload));
        }

        \Yii::$app->response->statusCode = 204;
    }





}
