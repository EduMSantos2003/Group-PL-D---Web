<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Tarefa;

class TarefaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // só autenticados
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $tarefas = Tarefa::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        return $this->render('index', [
            'tarefas' => $tarefas,
        ]);
    }

    public function actionToggle($id)
    {
        $tarefa = Tarefa::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($tarefa) {
            $tarefa->feito = !$tarefa->feito;
            $tarefa->save(false);
        }

        return $this->redirect(['index']);
    }
}
