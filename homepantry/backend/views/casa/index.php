<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\CasaSearch $searchModel */

$this->title = 'Casas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="casa-index">

    <p>
        <?= Html::a('Criar Casa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'nome',
                'label' => 'Nome da Casa',
            ],

            [
                'attribute' => 'dataCriacao',
                'label' => 'Criada em',
                'format' => ['date', 'php:Y-m-d H:i'],
                'contentOptions' => ['style' => 'width:180px;']
            ],

            [
                'attribute' => 'utilizadorPrincipal_id',
                'label' => 'Responsável',
                'value' => function ($model) {
                    return $model->utilizadorPrincipal->username ?? '(sem utilizador)';
                },
                'filter' => ArrayHelper::map(
                    User::find()->all(),
                    'id',
                    'username'
                ),
                'contentOptions' => ['style' => 'width:180px;']
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
