<?php

namespace frontend\controllers;

use Yii;
use common\models\Lista;
use common\models\ListaProduto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class ListaProdutoController extends Controller
{
    public function actionIndex($lista_id)
    {
        $lista = Lista::findOne($lista_id);

        if (!$lista) {
            throw new NotFoundHttpException('Lista não encontrada.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => ListaProduto::find()->where(['lista_id' => $lista_id]),
        ]);

        return $this->render('index', [
            'lista' => $lista,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($lista_id)
    {
        $lista = Lista::findOne($lista_id);

        if (!$lista) {
            throw new NotFoundHttpException('Lista não encontrada.');
        }

        $model = new ListaProduto();
        $model->lista_id = $lista_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'index',
                'lista_id' => $lista_id
            ]);
        }

        return $this->render('create', [
            'model' => $model,
            'lista' => $lista,
        ]);
    }

    public function actionDelete($id, $lista_id)
    {
        $model = ListaProduto::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Produto da lista não encontrado.');
        }

        $model->delete();

        return $this->redirect([
            'index',
            'lista_id' => $lista_id
        ]);
    }

    public function actionUpdate($id, $lista_id)
    {
        $model = ListaProduto::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Produto da lista não encontrado.');
        }

        // segurança extra: garantir que pertence à lista certa
        if ($model->lista_id != $lista_id) {
            throw new NotFoundHttpException('Produto não pertence a esta lista.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
                'index',
                'lista_id' => $lista_id
            ]);
        }

        return $this->render('update', [
            'model' => $model,
            'lista' => Lista::findOne($lista_id),
        ]);
    }


    public function actionClear($lista_id)
    {
        $lista = Lista::findOne($lista_id);
        if (!$lista) {
            throw new \yii\web\NotFoundHttpException('Lista não encontrada.');
        }

        // Apagar todos os produtos da lista
        ListaProduto::deleteAll(['lista_id' => $lista_id]);

        // Atualizar total da lista
        $lista->totalEstimado = 0;
        $lista->save(false);

        // 🔔 MQTT (opcional mas TOP)
        $mensagem = json_encode([
            'acao' => 'clear',
            'lista_id' => $lista_id,
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        exec(
            '"C:\Program Files\mosquitto\mosquitto_pub.exe" '
            . '-h localhost '
            . '-t lista/' . $lista_id . ' '
            . '-m ' . escapeshellarg($mensagem)
        );

        Yii::$app->session->setFlash('success', 'Todos os produtos da lista foram apagados.');

        return $this->redirect(['index', 'lista_id' => $lista_id]);
    }



}
