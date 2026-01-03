<?php

use common\models\StockProduto;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var common\models\StockProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Stock Produtos';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsVar('STOCK_INC_URL', Url::to(['/stock-produto/increment']));
$this->registerJsVar('STOCK_DEC_URL', Url::to(['/stock-produto/decrement']));
$this->registerJsFile('@web/js/stock.js', [
        'depends' => [\yii\web\JqueryAsset::class],
]);

$this->registerCssFile('@web/css/imagens.css');
$this->registerCssFile('@web/css/butoes.css');
$this->registerJsFile('@web/js/produtos.js', [
        'depends' => [\yii\web\JqueryAsset::class]
]);
?>

<div class="stock-produto-index">
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Entrada de Novo Produto', ['create'], ['class' => 'btn-create']) ?>
        </div>

        <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
                'options' => ['class' => 'mb-4'],
        ]); ?>

        <div class="d-flex justify-content-center">
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

        <div class="row">

            <?php foreach ($dataProvider->getModels() as $stock): ?>
                <div class="col-md-4 mb-4">
                    <div class="produto-card shadow-sm" style="opacity:0; transform:translateY(20px);">

                        <!-- 🔽 IMAGEM DO PRODUTO -->
                        <?php if ($stock->produto && $stock->produto->imagem): ?>
                            <img
                                    src="<?= Yii::getAlias('@web/uploads/produtos/' . $stock->produto->imagem) ?>"
                                    class="produto-img"
                                    alt="<?= Html::encode($stock->produto->nome) ?>"
                            >
                        <?php else: ?>
                            <img
                                    src="https://via.placeholder.com/500x300?text=Sem+Imagem"
                                    class="produto-img"
                                    alt="Sem imagem"
                            >
                        <?php endif; ?>
                        <!-- 🔼 FIM IMAGEM -->

                        <div class="p-3">

                            <h4 class="fw-bold mb-2">
                                <?= Html::encode($stock->produto->nome) ?>
                            </h4>

                            <p class="text-muted mb-3">
                                <strong>Quantidade:</strong>
                                <span id="qtd-<?= $stock->id ?>"><?= $stock->quantidade ?></span><br>

                                <strong>Preço total:</strong>
                                <span id="preco-<?= $stock->id ?>"><?= $stock->preco ?> €</span><br>

                                <strong>Local:</strong> <?= $stock->local->nome ?><br>
                                <strong>Validade:</strong> <?= $stock->validade ?><br>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-success"
                                        onclick="alterarStock(<?= $stock->id ?>, 'inc')">➕
                                </button>

                                <button type="button"
                                        id="dec-<?= $stock->id ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        <?= $stock->quantidade <= 0 ? 'disabled' : '' ?>
                                        onclick="alterarStock(<?= $stock->id ?>, 'dec')">
                                    ➖
                                </button>

                            </div>

                            <div class="d-flex justify-content-between">
                                <?= Html::a('Ver', ['view', 'id' => $stock->id], ['class'=>'btn-ver']) ?>
                                <?= Html::a('Editar', ['update', 'id' => $stock->id], ['class'=>'btn-editar']) ?>
                                <?= Html::a('Apagar', ['delete', 'id' => $stock->id], [
                                        'class' => 'btn-apagar',
                                        'data' => [
                                                'confirm' => 'Tem certeza que deseja apagar esta entrada de stock?',
                                                'method' => 'post',
                                        ],
                                ]) ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>