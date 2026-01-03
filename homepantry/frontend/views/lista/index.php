<?php

use common\models\Lista;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\ListaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/imagens.css');
$this->registerCssFile('@web/css/butoes.css');
?>
<div class="lista-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Criar Nova Lista', ['create'], ['class' => 'btn-create']) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-3'],
    ]); ?>

    <div class="d-flex justify-content-center">
        <div class="input-group" style="max-width: 420px;">
            <span class="input-group-text">🔍</span>

            <?= Html::activeTextInput($searchModel, 'globalSearch', [
                'class' => 'form-control',
                'placeholder' => 'Pesquisar nome ou tipo da lista',
            ]) ?>

            <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Limpar', ['index'], ['class' => 'btn btn-outline-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

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
    ]);

    ?>


</div>
