<?php

use common\models\StockProduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;


/** @var yii\web\View $this */
/** @var common\models\StockProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Stock Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
        // Html::a('Create Stock Produto', ['create'], ['class' => 'btn btn-success']);
    </p>
-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="input-group" style="max-width: 420px;">
        <span class="input-group-text">🔍</span>
        <?= Html::activeTextInput($searchModel, 'produto_id', [
                'class' => 'form-control',
                'placeholder' => 'Pesquisar Produto',
        ]) ?>
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a('Limpar', ['index'], ['class' => 'btn btn-outline-danger']) ?>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'produto_id',
//            'utilizador_id',
//            'local_id',
            [
                'attribute' => 'produto_id',
                'label' => 'Produto',
                'value' => 'produto.nome',   // ou produto.designacao (consoante o teu Produto)
            ],
            [
                'attribute' => 'utilizador_id',
                'label' => 'Utilizador',
                'value' => 'utilizador.username', // ou utilizador.email / utilizador.nome, conforme o teu User
            ],
            [
                'attribute' => 'local_id',
                'label' => 'Local',
                'value' => 'local.nome',
            ],
            'quantidade',
            //'validade',
            //'preco',
            //'dataCriacao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, StockProduto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>




</div>
