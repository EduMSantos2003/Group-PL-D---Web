<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto[] $produtos */

$this->title = 'Produtos';

$this->registerCssFile('@web/css/produtos.css');
$this->registerJsFile('@web/js/produtos.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Criar Produto', ['create'], ['class' => 'btn-create']) ?>
    </div>

    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
