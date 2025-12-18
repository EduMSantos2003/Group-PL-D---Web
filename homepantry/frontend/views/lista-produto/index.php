<?php

use common\models\ListaProduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var $lista common\models\Lista */
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos da lista: ' . $lista->nome;
$this->params['breadcrumbs'][] = ['label' => 'Listas', 'url' => ['lista/index']];
$this->params['breadcrumbs'][] = $lista->nome;
?>

<div class="lista-produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            'Adicionar produto',
            ['create', 'lista_id' => $lista->id],
            ['class' => 'btn btn-success']
        ) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'produto.nome',
                'label' => 'Produto',
            ],
            'quantidade',
            'precoUnitario:currency',
            'subTotal:currency',

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model) use ($lista) {
                    return Url::toRoute([
                        'lista-produto/' . $action,
                        'id' => $model->id,
                        'lista_id' => $lista->id,
                    ]);
                },
            ],
        ],
    ]); ?>

</div>
