<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ListaProduto $model */

$this->title = 'Update Lista Produto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lista Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lista-produto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
