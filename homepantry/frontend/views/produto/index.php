<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto[] $produtos */

$this->title = 'Produtos';

// breadcrumbs iguais ao resto do site
//$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;


$this->registerCssFile('@web/css/imagens.css');
$this->registerCssFile('@web/css/butoes.css');
$this->registerJsFile('@web/js/produtos.js', ['depends' => [\yii\web\JqueryAsset::class]]);

/** @var common\models\ProdutoSearch $searchModel */
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Criar Produto', ['create'], ['class' => 'btn-create']) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-3'],
    ]); ?>

    <div class="input-group" style="max-width: 420px;">
        <span class="input-group-text">🔍</span>
        <?= Html::activeTextInput($searchModel, 'nome', [
            'class' => 'form-control',
            'placeholder' => 'Pesquisar Produto',
        ]) ?>
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a('Limpar', ['index'], ['class' => 'btn btn-outline-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="row">

        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-4 mb-4">
                <div class="produto-card shadow-sm" style="opacity:0; transform:translateY(20px);">

                    <?php if ($produto->imagem): ?>
                        <img src="<?= Yii::getAlias('@web/uploads/produtos/' . $produto->imagem) ?>" class="produto-img">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/500x300?text=Sem+Imagem" class="produto-img">
                    <?php endif; ?>

                    <div class="p-3">

                        <h4 class="fw-bold mb-2"><?= Html::encode($produto->nome) ?></h4>

                        <p class="text-muted mb-3">
                            <strong>Preço:</strong> <?= $produto->preco ?> € <br>
                            <strong>Unidade:</strong> <?= $produto->unidade ?> <br>
                            <strong>Validade:</strong> <?= $produto->validade ?> <br>
                        </p>

                        <div class="d-flex justify-content-between">

                            <?= Html::a('Ver', ['view', 'id' => $produto->id], ['class'=>'btn-ver']) ?>
                            <?= Html::a('Editar', ['update', 'id' => $produto->id], ['class'=>'btn-editar']) ?>
                            <?= Html::a('Apagar', ['delete', 'id' => $produto->id], [
                                'class' => 'btn-apagar',
                                'data' => [
                                    'confirm' => 'Tem certeza que deseja apagar este produto?',
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