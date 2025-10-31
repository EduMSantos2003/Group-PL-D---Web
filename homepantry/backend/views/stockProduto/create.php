<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\StockProduto $model */

$this->title = 'Create Stock Produto';
$this->params['breadcrumbs'][] = ['label' => 'Stock Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
