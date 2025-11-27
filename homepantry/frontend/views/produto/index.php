<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto[] $produtos */

$this->title = 'Produtos';
<<<<<<< HEAD
=======
//$this->params['breadcrumbs'][] = $this->title;
>>>>>>> 8ffdd0185d3bdabee1134d75b179960f5dddc091
?>

<<<<<<< HEAD
<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>
=======
    <?php $this->beginBlock('hero');?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Produtos</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="<?= Url::to(['site/index']) ?>">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="<?= Url::to(['']) ?>">Pages</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="<?= Url::to(['']) ?>">Produtos</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <?php $this -> endBlock() ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
>>>>>>> 8ffdd0185d3bdabee1134d75b179960f5dddc091

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
