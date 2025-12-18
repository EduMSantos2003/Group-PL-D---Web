<?php

use common\models\Lista;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ListaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/imagens.css');
$this->registerCssFile('@web/css/butoes.css');
$this->registerJsFile('@web/js/produtos.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="lista-index">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <?= Html::a('Criar Nova Lista', ['create'], ['class' => 'btn-create']) ?>

    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            'tipo',
            'totalEstimado:currency',
            'dataCriacao',
            [
                'class' => ActionColumn::class,
                'template' => '{produtos} {view} {update} {delete}',
                'buttons' => [
                    'produtos' => function ($url, Lista $model) {
                        return Html::a(
                            'Ir para Lista',
                            ['lista-produto/index', 'lista_id' => $model->id],
                            [
                                'title' => 'Ver produtos da lista',
                                'class' => 'btn btn-sm btn-outline-primary me-1'
                            ]
                        );
                    },
                ],
                'urlCreator' => function ($action, Lista $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>
