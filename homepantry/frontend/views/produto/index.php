<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var common\models\Produto[] $produtos */

$this->title = 'Produtos';

// breadcrumbs iguais ao resto do site
//$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/produtos.css');

$this->registerJsFile('@web/js/produtos.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="container mt-4">

    <?php $this->beginBlock('hero'); ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">
                <?= Html::encode($this->title) ?>
            </h1>

            <nav aria-label="breadcrumb" class="animated slideInDown">
                <?= Breadcrumbs::widget([
                    'options' => ['class' => 'breadcrumb mb-0'],
                    'links'   => $this->params['breadcrumbs'],
                ]) ?>
            </nav>

        </div>
    </div>
    <!-- Page Header End -->

    <?php $this->endBlock(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Criar Produto', ['create'], ['class' => 'btn-create']) ?>
    </div>

    <div class="row">

        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-4 mb-4">
                <div class="produto-card shadow-sm" style="opacity:0; transform:translateY(20px);">

                    <?php if ($produto->imagem): ?>
                        <img src="<?= Yii::getAlias('@web/' . $produto->imagem) ?>" class="produto-img">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x220?text=Sem+Imagem" class="produto-img">
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
