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
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
    ]); ?>

    <div class="d-flex justify-content-center my-3">
        <div class="input-group" style="max-width: 420px;">
            <span class="input-group-text">🔍</span>

            <?= Html::activeTextInput($searchModel, 'globalSearch', [
                'class' => 'form-control',
                'placeholder' => 'Pesquisar produto, utilizador ou local',
            ]) ?>



            <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('Limpar', ['index'], ['class' => 'btn btn-outline-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null, //  remove filtros por coluna
        'columns' => [
            [
                'label' => 'Produto',
                'value' => 'produto.nome',
            ],
            [
                'label' => 'Utilizador',
                'value' => 'utilizador.username',
            ],
            [
                'label' => 'Local',
                'value' => 'local.nome',
            ],
            'quantidade',
            [
                'class' => ActionColumn::class,
            ],
        ],
    ]); ?>


</div>
