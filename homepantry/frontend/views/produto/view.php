<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->nome;

$this->registerCssFile('@web/css/butoes.css');
$this->registerCssFile('@web/css/imagens.css');
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

    </div>

    <!-- IMAGEM -->
    <div class="produto-img-container mb-4">
        <?php if ($model->imagem): ?>
            <img src="<?= Yii::getAlias('@web/' . $model->imagem) ?>" class="produto-img">
        <?php else: ?>
            <img src="https://via.placeholder.com/500x300?text=Sem+Imagem" class="produto-img">
        <?php endif; ?>
    </div>

    <!-- DETALHES -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'categoria_id',
            'nome',
            'descricao',
            'unidade',
            'preco',
            'validade',
            [
                'attribute' => 'imagem',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img('@web/' . $model->imagem, [
                        'class' => 'produto-thumbnail'
                    ]);
                }
            ]
        ],
    ]) ?>

    <!-- BOTÕES UPDATE -->
    <div class="d-flex gap-3 mb-4">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn-ver']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn-apagar',
            'data' => [
                'confirm' => 'Tem certeza que deseja apagar este produto?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
