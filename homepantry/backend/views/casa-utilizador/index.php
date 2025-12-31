<?php

use common\models\CasaUtilizador;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CasaUtilizadorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Casa Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="casa-utilizador-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Associar Utilizador a Casa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',

            [
                'attribute' => 'utilizador_id',
                'label' => 'Utilizador',
                'value' => fn($model) => $model->utilizador->username,
            ],
            [
                'attribute' => 'casa_id',
                'label' => 'Casa',
                'value' => fn($model) => $model->casa->nome,
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CasaUtilizador $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
