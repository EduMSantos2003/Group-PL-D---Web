<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto[] $produtos */

$this->title = 'Produtos';
?>

<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm">

                    <!-- Imagem -->
                    <?php if ($produto->imagem): ?>
                        <img src="<?= Yii::getAlias('@web/' . $produto->imagem) ?>"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x200?text=Sem+Imagem"
                             class="card-img-top">
                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title" ><?= Html::encode($produto->nome) ?></h5>

                        <p class="card-text">
                            <strong>Preço:</strong> <?= $produto->preco ?> € <br>
                            <strong>Unidade:</strong> <?= $produto->unidade ?> <br>
                            <strong>Validade:</strong> <?= $produto->validade ?> <br>
                        </p>

                        <div class="d-flex justify-content-between">
                            <?= Html::a('Ver', ['view', 'id' => $produto->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('Editar', ['update', 'id' => $produto->id], ['class' => 'btn btn-warning btn-sm']) ?>
                            <?= Html::a('Apagar', ['delete', 'id' => $produto->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja eliminar este produto?',
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
