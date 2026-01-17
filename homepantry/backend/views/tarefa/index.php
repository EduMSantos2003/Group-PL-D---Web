<?php

use common\models\Tarefa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\TarefaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tarefa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'descricao',
            [
                'attribute' => 'feito',
                'value' => fn($model) => $model->feito ? 'Sim' : 'Não',
                'filter' => [
                    0 => 'Não',
                    1 => 'Sim',
                ],
            ],
            /*[
                'label' => 'Utilizador',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : '(sem utilizador)';
                },
            ],*/

            [
                'attribute' => 'user_id',
                'label' => 'Utilizador',
                'value' => fn($model) => $model->user->username ?? '',
                'filter' => \yii\helpers\ArrayHelper::map(
                    \common\models\User::find()->all(),
                    'id',
                    'username'
                ),
            ],

        ],
    ]); ?>


</div>
