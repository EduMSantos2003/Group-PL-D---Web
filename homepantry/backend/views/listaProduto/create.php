<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ListaProduto $model */

$this->title = 'Create Lista Produto';
$this->params['breadcrumbs'][] = ['label' => 'Lista Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
